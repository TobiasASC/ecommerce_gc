<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use App\Models\Rol;

class AdminController extends Controller
{
    public function index(){
        return view('admin/adminEstadisticas');
    }


        public function clientes(Request $request)
    {
        $query = Usuario::where('rol_id', 2);

        if ($request->filled('buscar')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->buscar . '%')
                ->orWhere('apellido', 'like', '%' . $request->buscar . '%');
            });
        }

        $clientes = $query->latest()->get();

        $totalClientes = Usuario::where('rol_id', 2)->count();

        $clientesNuevos = Usuario::where('rol_id', 2)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();


        $clientes = Usuario::where('rol_id', 2)
            ->withCount('pedidos')
            ->when($request->filled('buscar'), function ($q) use ($request) {
                $q->where(function ($q2) use ($request) {
                    $q2->where('nombre', 'like', '%' . $request->buscar . '%')
                    ->orWhere('apellido', 'like', '%' . $request->buscar . '%');
                });
            })
            ->latest()
            ->get();
        
            $topCompradorId = $clientes->sortByDesc('pedidos_count')->first()?->id;

        return view('admin.adminClientes', compact(
            'clientes',
            'totalClientes',
            'clientesNuevos',
            'topCompradorId'
        ));
    }


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
            // Quita el comentario de la siguiente línea si quieres ver el error exacto en pantalla para debugear:
            // dd($e->getMessage()); 
            return redirect()->back()->with('error', 'Ocurrió un error al intentar actualizar el rol del usuario.');
        }
    }

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
