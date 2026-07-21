<?php

namespace App\Http\Controllers;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $query = Producto::where('activo', true)
            ->where('stock_actual', '>', 0);

        if (request('buscar')) {
            $query->where('nombre', 'like', '%' . request('buscar') . '%');
        }

        $productos = $query->get();

        $categorias = Categoria::where('activo', true)->get();

        return view('catalogo', compact(
            'productos',
            'categorias'
        ));
    }

public function categoria($id)
{
    // 1. Iniciamos la consulta filtrando por la categoría, activo y stock
    $query = Producto::where('categoria_id', $id)
        ->where('activo', true)
        ->where('stock_actual', '>', 0);

    // 2. AGREGAMOS LA BÚSQUEDA: Si el usuario escribió algo en el buscador, lo filtramos
    if (request('buscar')) {
        $query->where('nombre', 'like', '%' . request('buscar') . '%');
    }

    // 3. Ejecutamos la consulta
    $productos = $query->get();

    $categorias = Categoria::where('activo', true)->get();

    return view('catalogo', compact(
        'productos',
        'categorias'
    ));
}
}
