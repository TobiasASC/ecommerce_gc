<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\MetodoPago;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    // Obtiene el ultimo pedido del cliente en estado "carrito" o crea un nuevo pedido en ese estado
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


    // Muestra la vista del carrito junto con el detalle y metodo de pago
    public function index(){
        $carrito = $this->obtenerCarrito();
        $items = $carrito->detalles()->with('producto')->get();
        $metodosPago = MetodoPago::all();

        return view('cliente.clienteCarrito', compact('carrito', 'items', 'metodosPago'));
    }


   
    // Recalcula el monto total del pedido
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


    // Vacia el carrito (elimina detalles del pedido)
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
    
    // Elimina un producto del carrito
    public function eliminar($id)
    {
        $carrito = $this->obtenerCarrito();
        
        // Cambiamos 'id' por 'producto_id' para garantizar que solo borre ese ítem específico
        $carrito->detalles()->where('producto_id', $id)->delete();
        
        $this->recalcularTotal($carrito);
        
        return redirect()->route('carrito.mostrar')
                         ->with('success', 'Producto eliminado correctamente del carrito.');
    }
    
    // Procesa la compra y redirecciona a vista de compra confirmada
    public function procesar(Request $request)
    {
    // Validamos el método de pago y que el comprobante sea una imagen segura
    $request->validate([
        'metodo_pago_id' => 'required|exists:metodo_pagos,id',
        'comprobante'    => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Máximo 5MB
    ]);

    $pedido = Pedido::where('usuario_id', Auth::id())
                    ->where('estado', 'carrito')
                    ->first();

    // Si no hay carrito o no tiene productos, lo devolvemos
    if (!$pedido || $pedido->detalles()->count() === 0) {
        return redirect()->route('carrito.mostrar')->with('error', 'Tu carrito está vacío o la sesión expiró.');
    }

    // --- VALIDACIÓN DE STOCK ANTES DE COMPRAR ---
    foreach ($pedido->detalles as $detalle) {
        $producto = $detalle->producto;
        if ($detalle->cantidad > $producto->stock_actual) {
            return redirect()->route('cliente.carrito')->with('error', 'Lo sentimos, no hay stock suficiente para el producto: ' . $producto->nombre . '. Stock disponible: ' . $producto->stock_actual);
        }
    }
    
    $totalPedido = $pedido->detalles()->sum('subtotal');
    $estadoFinal = 'pendiente'; 
    $metodo = MetodoPago::find($request->metodo_pago_id);

    // --- LÓGICA PARA GUARDAR EL COMPROBANTE ---
    $rutaComprobante = null;
    if ($request->hasFile('comprobante')) {
        // Guarda la imagen en storage/app/public/comprobantes
        $rutaComprobante = $request->file('comprobante')->store('comprobantes', 'public');
    }

    // Actualizar el pedido
    $pedido->update([
        'total'          => $totalPedido,
        'estado'         => $estadoFinal, 
        'metodo_pago_id' => $request->metodo_pago_id,
        'fecha_venta'    => now(),
        'comprobante_url'    => $rutaComprobante, // Guardamos la ruta de la imagen
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

    return redirect()->route('compra.confirmada')->with('pedido_id', $pedido->id);
    }


    }







