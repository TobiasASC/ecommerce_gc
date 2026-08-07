<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioLocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear el usuario Administrador
        Usuario::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'nombre' => 'Admin',
                'apellido' => 'Principal',
                'password' => Hash::make('12345678'),
                'rol_id' => 1, 
            ]
        );

        // 2. Crear el usuario Cliente
        Usuario::updateOrCreate(
            ['email' => 'cliente@example.com'],
            [
                'nombre' => 'Cliente',
                'apellido' => 'Ejemplo',
                'password' => Hash::make('12345678'),
                'rol_id' => 2, 
            ]
        );
    }
}