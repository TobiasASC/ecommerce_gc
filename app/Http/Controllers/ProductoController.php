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




    /**
     * Muestra la lista de productos para el administrador (con filtro por categoría)
     */
    public function indexAdmin(Request $request)
    {
        
        // Obtenemos todas las categorías para llenar el <select>
        $categorias = Categoria::all();

        // Iniciamos la consulta de productos
        $query = Producto::query();

        // Si el request trae un 'categoria_id', filtramos la consulta
        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        // Ejecutamos la consulta ordenando por los más recientes y paginamos (ej: 10 por página)
        $productos = $query->orderBy('created_at', 'desc')->paginate(10);

        // Mantenemos el parámetro de búsqueda en la paginación
        $productos->appends($request->all());

        return view('admin/adminProductos', compact('productos', 'categorias'));
    }

    /**
     * Elimina un producto de la base de datos
     */
    public function destroy($id)
    {
        try {
            $producto = Producto::findOrFail($id);
            
            // Opcional: Eliminar la imagen del servidor si existe
            // if ($producto->imagen_url && file_exists(public_path($producto->imagen_url))) {
            //     unlink(public_path($producto->imagen_url));
            // }

            $producto->delete();

            return redirect()->back()->with('success', 'El producto fue eliminado correctamente.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar el producto. Verifica que no esté asociado a ventas.');
        }
    }

    /**
     * Muestra el formulario para editar un producto (Estructura base)
     */
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        
        // Retornas a la vista de edición que crearás luego
        return view('admin/editarProducto', compact('producto', 'categorias'));
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre'       => 'required|max:255',
            'precio_venta' => 'required|numeric|min:0',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'imagen'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $producto = Producto::findOrFail($id);
        
        // Conservamos la ruta de la imagen actual por si no sube una nueva
        $rutaImagen = $producto->imagen_url;

        // Si el usuario sube un archivo nuevo
        if ($request->hasFile('imagen')) {
            $archivo = $request->file('imagen');
            $nombre = time() . '_' . $archivo->getClientOriginalName();
            
            // Movemos la imagen nueva a la carpeta
            $archivo->move(public_path('img/catalogo'), $nombre);

            // Borramos la imagen vieja del servidor si existe y no es una ruta vacía
            if ($producto->imagen_url && file_exists(public_path($producto->imagen_url))) {
                unlink(public_path($producto->imagen_url));
            }

            // Actualizamos la variable con la nueva ruta
            $rutaImagen = 'img/productos/' . $nombre;
        }

        // Actualizamos los datos en la base de datos
        $producto->update([
            'nombre'       => $request->nombre,
            'descripcion'  => $request->descripcion,
            'precio_venta' => $request->precio_venta,
            'stock_actual' => $request->stock_actual,
            'stock_minimo' => $request->stock_minimo,
            'categoria_id' => $request->categoria_id,
            'imagen_url'   => $rutaImagen // Ojo aquí, asegúrate que sea tu nombre de columna
        ]);

        // Redireccionamos con el nombre correcto de tu ruta
        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado correctamente');
    }
}

