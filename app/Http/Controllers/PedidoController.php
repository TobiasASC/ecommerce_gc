<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    
    public function pedidosCliente()
    {
        $pedidos = Pedido::where('usuario_id', Auth::id())
                    ->where('estado', 'confirmado') 
                    ->orderBy('created_at', 'desc')
                    ->get();
    
        return view('cliente.clientePedidos', compact('pedidos'));
    }

    public function pedidosAdmin(){
        $pedidos = Pedido::where('estado', 'confirmado') 
                    ->orderBy('created_at', 'desc')
                    ->get();
    
        return view('admin.adminPedidos', compact('pedidos'));
    }


}
