<?php

namespace App\Http\Controllers;
use App\Models\Producto;
use App\Models\Categoria;
use App\Support\MediaStorage;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Muestra la lista de productos para el administrador (con filtro por categoría)
     */
    public function index(Request $request)
    {
        // Obtenemos todas las categorías para llenar el <select>
        $categorias = Categoria::all();

        // Iniciamos la consulta de productos
        $query = Producto::query();

        // BÚSQUEDA DINÁMICA: Si el request trae un 'search', filtramos la consulta
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->search . '%')
                ->orWhere('descripcion', 'like', '%' . $request->search . '%');
            });
        }

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

    
    // Elimina un producto de la base de datos
    public function destroy($id)
    {
        try {
            $producto = Producto::findOrFail($id);

            $producto->delete();

            return redirect()->back()->with('success', 'El producto fue eliminado correctamente.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar el producto. Verifica que no esté asociado a ventas.');
        }
    }

    
    // Muestra el formulario para editar un producto 
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        
        // Retornas a la vista de edición que crearás luego
        return view('admin/editarProducto', compact('producto', 'categorias'));
    }
    
    // Actualiza los campos de un producto
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

            if ($producto->imagen_url) {
                MediaStorage::delete($producto->imagen_url);
            }

            $rutaImagen = MediaStorage::store($archivo, 'img/productos');
        }

        // Actualizamos los datos en la base de datos
        $producto->update([
            'nombre'       => $request->nombre,
            'descripcion'  => $request->descripcion,
            'precio_venta' => $request->precio_venta,
            'stock_actual' => $request->stock_actual,
            'stock_minimo' => $request->stock_minimo,
            'categoria_id' => $request->categoria_id,
            'imagen_url'   => $rutaImagen 
        ]);

        // Redireccionamos con el nombre correcto de tu ruta
        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado correctamente');
    }
    
    // Retorna la vista para crear un nuevo producto
    public function crear()
    {
        $categorias = Categoria::where('activo', true)
            ->get();

        return view(
            'admin.crearProducto',
            compact('categorias')
        );
    }
    
    // Guarda los datos del  nuevo producto
    public function guardar(Request $request)
    {
        $request->validate([

            'nombre' => 'required|max:255',

            'precio_venta' => 'required|numeric|min:0',

            'stock_actual' => 'required|integer|min:0',

            'stock_minimo' => 'required|integer|min:0',

            'categoria_id' => 'required|exists:categorias,id',

            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $rutaImagen = null;

        if ($request->hasFile('imagen')) {
            $rutaImagen = MediaStorage::store($request->file('imagen'), 'img/productos');
        }

        Producto::create([

            'nombre' => $request->nombre,

            'descripcion' => $request->descripcion,

            'precio_venta' => $request->precio_venta,

            'stock_actual' => $request->stock_actual,

            'stock_minimo' => $request->stock_minimo,

            'categoria_id' => $request->categoria_id,

            'imagen_url' => $rutaImagen,

            'activo' => true
        ]);

        return redirect()
            ->route('admin.productos.crear')
            ->with('success', 'Producto creado correctamente');
    }


    





}

