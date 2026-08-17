<?php

namespace App\Http\Controllers;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    // Retorna productos, categorias y catalogo
    public function index()
    {
        $query = Producto::where('activo', true);

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



    // Devuelve productos filtrados segun la categoria
    public function categoria($id)
    {
    // Inicia la consulta filtrando por la categoría, activo y stock
        $query = Producto::where('categoria_id', $id)
        ->where('activo', true)
        ->where('stock_actual', '>', 0);

    // AGREGA LA BUSQUEDA: Si el usuario escribió algo en el buscador, lo filtramos
    if (request('buscar')) {
        $query->where('nombre', 'like', '%' . request('buscar') . '%');
    }

    // Ejecuta la consulta
    $productos = $query->get();

    $categorias = Categoria::where('activo', true)->get();

    return view('catalogo', compact(
        'productos',
        'categorias'
    ));
    }

    // Muestra detalles del producto
    public function mostrarEspecifico($id)
    {
        $producto = Producto::with('categoria')
        ->where('activo', true)
        ->where('stock_actual', '>', 0)
        ->findOrFail($id);

        return view('infoProducto', compact(
            'producto'
        ));
    }

    public function buscar(Request $request)
    {
        $query = $request->input('query');
        $productos = Producto::where('nombre', 'like', '%' . $query . '%')
            ->where('activo', true)
            ->get();
        $categorias = Categoria::where('activo', true)->get();

        return view('catalogo', compact('productos', 'categorias'));
    }

    public function sugerencias(Request $request)
    {
        $query = $request->input('query');
        $productos = Producto::where('nombre', 'like', '%' . $query . '%')
            ->where('activo', true)
            ->limit(5)
            ->get(['id', 'nombre']);

        return response()->json($productos);
    }
}
