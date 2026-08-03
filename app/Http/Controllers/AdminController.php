<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use App\Models\Rol;

class AdminController extends Controller
{

    // Muestra clientes en el panel del admin
    public function clientes(Request $request)
    {
        // Iniciamos la consulta de usuarios/clientes
        $query = Usuario::query(); 

        // BUSCADOR: Filtramos por nombre, apellido o email
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->search . '%')
                  ->orWhere('apellido', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // FILTRO POR ROL: Filtramos usando la relación 'rol'
        if ($request->filled('rol')) {
            $query->whereHas('rol', function($q) use ($request) {
                $q->where('nombre', $request->rol); // Busca exactamente "admin" o "cliente"
            });
        }

        // Ejecutamos la consulta ordenando por los más recientes
        $clientes = $query->orderBy('created_at', 'desc')->paginate(10); 

        // Mantenemos los parámetros de búsqueda en la URL de paginación
        $clientes->appends($request->all());

        return view('admin.adminClientes', compact('clientes')); // Ajusta el nombre de la vista
    }

    
    // Cambia el rol del usuario a rol ADMIN
    public function hacerAdmin($id)
    {
        try {
            $cliente = Usuario::findOrFail($id);
            
            // Buscamos el ID del rol que tiene por nombre 'admin'
            $rolAdmin = Rol::where('nombre', 'admin')->first(); 

            if (!$rolAdmin) {
                return redirect()->back()->with('error', 'El rol de administrador no existe en la base de datos.');
            }

            // Asignamos el ID encontrado a la llave foránea
            $cliente->rol_id = $rolAdmin->id;
            $cliente->save();

            return redirect()->back()->with('success', 'El usuario ' . $cliente->nombre . ' ahora es administrador.');

        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Ocurrió un error al intentar actualizar el rol del usuario.');
        }
    }
    
    // Cambia el rol del usuario a rol CLIENTE
    public function hacerCliente($id)
    {
        try {
            $cliente = Usuario::findOrFail($id);
            
            // Buscamos el ID del rol que tiene por nombre 'cliente'
            $rolCliente = Rol::where('nombre', 'cliente')->first(); 

            if (!$rolCliente) {
                return redirect()->back()->with('error', 'El rol de cliente no existe en la base de datos.');
            }

            $cliente->rol_id = $rolCliente->id;
            $cliente->save();

            return redirect()->back()->with('success', 'Al usuario ' . $cliente->nombre . ' se le han revocado los permisos.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar quitar el rol del usuario.');
        }
    }

    
}
