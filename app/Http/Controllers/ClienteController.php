<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

class ClienteController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();

        return view('cliente.clienteCuenta', compact('usuario'));
    }

    public function actualizar(Request $request){
        $request->validate(['contraseña' => 'nullable|min:8|confirmed',]);
        $usuario = Usuario::find(Auth::id());

        // Actualizar los datos personales
        $usuario->nombre = $request->nombre;
        $usuario->apellido = $request->apellido;
        $usuario->email = $request->email;

        if ($request->filled('contraseña')) {

        if (!Hash::check(
            $request->contraseña_actual,
            $usuario->contraseña
        )) {

            return back()
                ->withErrors([
                    'contraseña_actual' => 'La contraseña actual es incorrecta.'
                ])
                ->withInput();
        }

        $usuario->contraseña = Hash::make(
        $request->contraseña
        );
    }
    // Guardamos los cambios
        $usuario->save();

        return redirect()
            ->route('cliente.cuenta')
            ->with('success', 'Datos actualizados correctamente');
    }

}

