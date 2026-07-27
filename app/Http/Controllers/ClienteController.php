<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use App\Models\Usuario;

class ClienteController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        return view('cliente.clienteCuenta', compact('usuario'));
    }

    public function actualizar(Request $request)
    {
        // Agregamos required_with para obligar a poner la actual si escriben una nueva
        $request->validate([
            'contraseña_actual' => 'required_with:contraseña',
            'contraseña' => 'nullable|min:8|confirmed',
        ]);

        $usuario = Usuario::find(Auth::id());

        // Actualizar los datos personales
        $usuario->nombre = $request->nombre;
        $usuario->apellido = $request->apellido;
        $usuario->email = $request->email;

        // Si el usuario intentó cambiar la contraseña
        if ($request->filled('contraseña')) {
            
            // ATENCIÓN AQUÍ: Asegúrate de usar $usuario->password 
            // (a menos que tu columna en BD se llame textualmente "contraseña")
            if (!Hash::check($request->contraseña_actual, $usuario->password)) {
                return back()
                    ->withErrors([
                        'contraseña_actual' => 'La contraseña actual es incorrecta.'
                    ])
                    ->withInput();
            }

            $usuario->password = Hash::make($request->contraseña);
        }

        // Guardamos los cambios
        $usuario->save();

        return redirect()
            ->route('cliente.cuenta')
            ->with('success', 'Datos actualizados correctamente');
    }
}