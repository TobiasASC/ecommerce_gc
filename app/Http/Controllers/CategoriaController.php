<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    // Devuelve la vista con todas las categorias
    public function index(){
        $categorias = Categoria::all();

        // Retornas a la vista de edición que crearás luego
        return view('admin/adminCategorias', compact('categorias'));
    }

    
    // Guarda una nueva categoría en la base de datos.
    public function store(Request $request)
    {
        // 1. Validamos que el nombre no venga vacío y no exista otra categoría igual
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
        ], [
            'nombre.unique' => 'Ya existe una categoría con este nombre.'
        ]);

        // 2. Creamos la categoría
        Categoria::create([
            'nombre' => $request->nombre,
            // Los checkboxes envían valor solo si están marcados. Si está marcado, es true (1), si no, es false (0).
            'activo' => $request->has('activo') ? true : false, 
        ]);

        // 3. Redireccionamos con mensaje de éxito
        return redirect()->back()->with('success', 'Categoría creada correctamente.');
    }


    // Elimina una categoria
    public function destroy($id)
    {
        try {
            $categoria = Categoria::findOrFail($id);

            // PROTECCIÓN: Verificamos si la categoría tiene productos antes de borrarla
            // (Para que esto funcione, debes tener la relación productos() definida en tu modelo Categoria)
            if ($categoria->productos()->count() > 0) {
                return redirect()->back()->with('error', 'No puedes eliminar esta categoría porque tiene productos asignados. Mueve los productos a otra categoría primero.');
            }

            $categoria->delete();

            return redirect()->back()->with('success', 'La categoría fue eliminada correctamente.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar la categoría.');
        }
    }


    // Actualiza una categoría existente en la base de datos.
    public function actualizar(Request $request, $id)
    {
        // Validamos que el nombre no venga vacío
        $request->validate([
            'nombre' => 'required|max:255',
            'activo' => 'required|boolean'
        ]);

        // Buscamos la categoría y la actualizamos
        $categoria = Categoria::findOrFail($id);
        
        $categoria->update([
            'nombre' => $request->nombre,
            'activo' => $request->activo
        ]);

        // Redirigimos a la misma vista con un mensaje de éxito
        return redirect()
            ->route('admin.categorias.index')
            ->with('success', 'Categoría actualizada correctamente');
    }
}
