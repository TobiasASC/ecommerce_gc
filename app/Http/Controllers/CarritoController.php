<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\MetodoPago;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    private function obtenerCarrito()
    {
    return Pedido::firstOrCreate(
        [
            'usuario_id' => auth()->id(),
            'estado' => 'carrito',
        ],
        [
            'total' => 0,
            // Genera un numero de pedido tipo PED-4920493 usando un número aleatorio
            'codigo_pedido' => 'PED-' . rand(100000, 999999), 
        ]
    );
    }

    public function index(){
        $carrito = $this->obtenerCarrito();
        $items = $carrito->detalles()->with('producto')->get();
        $metodosPago = MetodoPago::all();

        return view('cliente.clienteCarrito', compact('carrito', 'items', 'metodosPago'));
    }



    private function recalcularTotal(Pedido $carrito)
    {
    // sum() suma todos los subtotales de los ítems del carrito
    $total = $carrito->detalles()->sum('subtotal');
    $carrito->update(['total' => $total]);
    }



    // Agrega un producto al carrito o actualiza su cantidad si ya existe
    public function agregar(Request $request) {
    $request->validate([
        'producto_id' => 'required|exists:productos,id',
        'cantidad' => 'required|integer|min:1',
    ]);

    $producto = Producto::findOrFail($request->producto_id);
    $carrito = $this->obtenerCarrito();
    $item = $carrito->detalles()->where('producto_id', $producto->id)->first();

    // Calcular cuánto tiene ya en el carrito (si no tiene, es 0)
    $cantidadEnCarrito = $item ? $item->cantidad : 0;
    
    // Sumar lo que ya tiene + lo que quiere agregar ahora
    $cantidadTotalDeseada = $cantidadEnCarrito + $request->cantidad;

    // Verificar si el stock soporta la cantidad TOTAL
    if ($producto->stock_actual < $cantidadTotalDeseada) {
        return back()->with('error', 'No hay suficiente stock para la cantidad total solicitada');
    }

    if ($item) {
        // Si ya existe: suma la cantidad
        $item->cantidad += $request->cantidad;
        $item->subtotal = $item->cantidad * $item->precio_unitario;
        $item->save();
    } else {
        // Si no existe: crea un nuevo ítem
        $carrito->detalles()->create([
            'producto_id' => $producto->id,
            'cantidad' => $request->cantidad,
            'precio_unitario' => $producto->precio_venta,
            'subtotal' => $producto->precio_venta * $request->cantidad,
        ]);
    }

    $this->recalcularTotal($carrito);
    return back()->with('success', 'Producto agregado al carrito');
    }



    public function vaciar()
    {
    // Buscar el carrito activo del usuario 
    $carrito = $this->obtenerCarrito();

    if ($carrito) {
        // Eliminar todos los detalles asociados usando la relación hasMany
        $carrito->detalles()->delete();

        // Reiniciar los montos del pedido a 0
        $carrito->total = 0;
        $carrito->save();
    }

    // Redireccionamos a la vista del carrito con un mensaje
    return redirect()->route('carrito.mostrar')->with('success', 'Se han quitado todos los productos del pedido.');
    }




    // Actualiza la cantidad de un producto específico en el carrito
    public function actualizar(Request $request, $id)
    {
        // Validar que la cantidad sea correcta
        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        $carrito = $this->obtenerCarrito();

        // Buscar el ítem asegurando que pertenezca al carrito del usuario actual
        $item = $carrito->detalles()->where('id', $id)->first();

        if (!$item) {
            return back()->with('error', 'El producto no se encontró en el pedido.');
        }

        // Verificar stock antes de actualizar
        if ($item->producto->stock_actual < $request->cantidad) {
            return back()->with('error', 'No hay suficiente stock para la cantidad solicitada.');
        }

        // Actualizar cantidad y subtotal del ítem
        $item->cantidad = $request->cantidad;
        $item->subtotal = $item->cantidad * $item->precio_unitario;
        $item->save();

        // Recalcular el total general del carrito
        $this->recalcularTotal($carrito);

        return back()->with('success', 'Cantidad actualizada correctamente.');
    }

    public function eliminar($id)
    {
        $carrito = $this->obtenerCarrito();
        
        // Cambiamos 'id' por 'producto_id' para garantizar que solo borre ese ítem específico
        $carrito->detalles()->where('producto_id', $id)->delete();
        
        $this->recalcularTotal($carrito);
        
        return redirect()->route('carrito.mostrar')
                         ->with('success', 'Producto eliminado correctamente del carrito.');
    }

    public function procesar(Request $request){
        $request->validate([
            'metodo_pago_id' => 'required|exists:metodo_pagos,id',
            
            // Validaciones de tarjeta
            'numero_tarjeta' => 'required_if:metodo_pago_id,1|nullable|string',
            'titular_tarjeta' => 'required_if:metodo_pago_id,1|nullable|string',
            'vencimiento'    => 'required_if:metodo_pago_id,1|nullable|string',
            'cvv'            => 'required_if:metodo_pago_id,1|nullable|string',
            
        ]);

        $pedido = Pedido::where('usuario_id', Auth::id())
                        ->where('estado', 'carrito')
                        ->first();

        // Si no hay carrito o no tiene productos, lo devolvemos
        if (!$pedido || $pedido->detalles()->count() === 0) {
            return redirect()->route('cliente.carrito')->with('error', 'Tu carrito está vacío o la sesión expiró.');
        }

        // --- VALIDACIÓN DE STOCK ANTES DE COMPRAR ---
        foreach ($pedido->detalles as $detalle) {
            $producto = $detalle->producto;
            
            // Verificamos si la cantidad pedida es mayor al stock real
            if ($detalle->cantidad > $producto->stock_actual) {
                return redirect()->route('cliente.carrito')->with('error', 'Lo sentimos, no hay stock suficiente para el producto: ' . $producto->nombre . '. Stock disponible: ' . $producto->stock_actual);
            }
        }
        
        // Obtener el total sumando los detalles (por seguridad)
        $totalPedido = $pedido->detalles()->sum('subtotal');

        
        // Actualizar el pedido
        $estadoFinal = 'confirmado'; 
        $metodo = MetodoPago::find($request->metodo_pago_id);

        if ($metodo && in_array($metodo->descripcion, ['Transferencia Bancaria'])) {
            $estadoFinal = 'pendiente_pago';
        }

        
        $pedido->update([
            'total'          => $totalPedido,
            'estado'         => $estadoFinal, 
            'metodo_pago_id' => $request->metodo_pago_id,
            'fecha_venta'    => now(),
        ]);

        // DESCONTAR STOCK DE LOS PRODUCTOS
        foreach ($pedido->detalles as $detalle) {
            $producto = $detalle->producto;
            if ($producto) {
                $producto->stock_actual -= $detalle->cantidad;
                if ($producto->stock_actual < 0) {
                    $producto->stock_actual = 0;
                }
                $producto->save();
            }
        }

        // Redirigimos a la pantalla de éxito pasando el ID del pedido
        return redirect()->route('compra.confirmada')->with('pedido_id', $pedido->id);
    }


    }







