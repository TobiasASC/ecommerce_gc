<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;

class AdminPedidoController extends Controller
{
    // Devuelve todos los pedidos de los usuarios
    public function pedidos(Request $request)
    {
        // Iniciamos la consulta correctamente usando query()
        $query = Pedido::query(); 

        // Filtro de Búsqueda de texto (por código de pedido)
        if ($request->filled('search')) {
            $query->where('codigo_pedido', 'like', '%' . $request->search . '%');
        }

        // Filtro por Estado (Pendiente / Confirmado)
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Ordenamos por los más recientes y paginamos
        $pedidos = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Mantenemos los parámetros de búsqueda en la URL de paginación
        $pedidos->appends($request->all());

        return view('admin.adminPedidos', compact('pedidos'));
    }

    // Devuelve el detalle de todos los pedidos
    public function detalle($id)
    {
        // El admin puede buscar cualquier pedido. 
        // Usamos with() para cargar al cliente y los productos en la misma consulta (Eager Loading)
        $pedido = Pedido::with(['usuario', 'detalles.producto'])->findOrFail($id);

        return view('admin.detallePedido', compact('pedido'));
    }




    // Le asigna al estado del pedido el valor "confirmado"
    public function confirmar(Request $request, $id)
    {
    // 1. Buscamos el pedido en la base de datos
    $pedido = Pedido::findOrFail($id);

    // 2. Verificamos que no esté ya confirmado para evitar doble proceso
    if (strtolower($pedido->estado) === 'confirmado') {
        return back()->with('error', 'Este pedido ya había sido confirmado previamente.');
    }

    // 3. Cambiamos el estado y guardamos
    $pedido->estado = 'confirmado';
    $pedido->save();

    // 4. Redirigimos con un mensaje de éxito
    return back()->with('success', 'El pedido #' . $pedido->codigo_pedido . ' ha sido confirmado exitosamente.');
    }



    


}
