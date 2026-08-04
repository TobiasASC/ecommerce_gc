<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class usuariosProduccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = base_path('json-produccion/usuarios_202608040016.json');

        if (!File::exists($path)) {
            $this->command->warn('No se encontró el archivo JSON de usuarios.');
            return;
        }

        $payload = json_decode(File::get($path), true, 512, JSON_THROW_ON_ERROR);

        foreach ($payload['usuarios'] ?? [] as $usuario) {
            Usuario::updateOrCreate(
                ['id' => $usuario['id']],
                [
                    'id' => $usuario['id'],
                    'nombre' => $usuario['nombre'],
                    'apellido' => $usuario['apellido'],
                    'email' => $usuario['email'],
                    'password' => $usuario['password'],
                    'rol_id' => $usuario['rol_id'],
                    'remember_token' => $usuario['remember_token'] ?? null,
                    'created_at' => $usuario['created_at'] ?? null,
                    'updated_at' => $usuario['updated_at'] ?? null,
                    'deleted_at' => $usuario['deleted_at'] ?? null,
                ]
            );
        }
    }
}
