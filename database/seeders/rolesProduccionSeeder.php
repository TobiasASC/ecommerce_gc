<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class rolesProduccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = base_path('json-produccion/roles_202608040019.json');

        if (!File::exists($path)) {
            $this->command->warn('No se encontró el archivo JSON de roles.');
            return;
        }

        $payload = json_decode(File::get($path), true, 512, JSON_THROW_ON_ERROR);

        foreach ($payload['roles'] ?? [] as $rol) {
            Rol::updateOrCreate(
                ['id' => $rol['id']],
                [
                    'id' => $rol['id'],
                    'nombre' => $rol['nombre'],
                    'descripcion' => $rol['descripcion'] ?? null,
                    'created_at' => $rol['created_at'] ?? null,
                    'updated_at' => $rol['updated_at'] ?? null,
                    'deleted_at' => $rol['deleted_at'] ?? null,
                ]
            );
        }
    }
}
