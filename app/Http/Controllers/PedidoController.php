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
                    ->where('estado', 'carrito') // deberia ir 'confirmado' pero para probar va carrito 
                    ->orderBy('created_at', 'desc')
                    ->get();
    
        return view('cliente.clientePedidos', compact('pedidos'));
    }


}
