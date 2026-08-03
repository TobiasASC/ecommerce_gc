<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function formularioRegistro(){
        return view('register');
    }

    public function formularioLogin(){
        return view('login');
    }

    public function registrar(Request $request){
        $request->validate([
            'nombre'   =>  'required|string|max:255',
            'apellido'   =>  'required|string|max:255',
            'email'    =>  'required|email|unique:usuarios',
            'password' =>  'required|min:6|confirmed'
        ]);

            Usuario::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($request->password),

            // cliente por defecto
            'rol_id' => 2
        ]);

        return redirect('/login');
    }

    public function autenticar(Request $request){

        $credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credenciales)) {

            $request->session()->regenerate();

            $user = Auth::user();


            if ($user->rol->nombre === 'admin') {
                return redirect('/');
            }

            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'Email o contraseña incorrectos'
        ]);
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
