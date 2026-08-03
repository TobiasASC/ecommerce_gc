<?php

namespace App\Http\Controllers;
use App\Models\Pedido;
use Illuminate\Http\Request;

class ClientePedidoController extends Controller
{
    // Muestra todos los pedidos del cliente, incluye busqueda por codigo y filtro por rol
    public function pedidos(Request $request)
    {
    // Iniciamos la consulta filtrando por el ID del usuario logueado
        $query = Pedido::where('usuario_id', auth()->id());

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

    
        return view('cliente.clientePedidos', compact('pedidos'));
    }

    
    // Muestral os detalles del pedido 
    public function detalle($id)
    {
        // Buscamos el pedido, pero OBLIGAMOS a que el usuario_id coincida con el logueado
        $pedido = Pedido::with(['detalles.producto'])
                        ->where('usuario_id', auth()->id())
                        ->findOrFail($id); // Si intenta poner el ID de otro pedido, dará error 404

        return view('cliente.detallePedido', compact('pedido'));
    }
}
