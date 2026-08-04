<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class categoriasProduccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = base_path('json-produccion/categorias_202608040016.json');

        if (!File::exists($path)) {
            $this->command->warn('No se encontró el archivo JSON de categorías.');
            return;
        }

        $payload = json_decode(File::get($path), true, 512, JSON_THROW_ON_ERROR);

        foreach ($payload['categorias'] ?? [] as $categoria) {
            Categoria::updateOrCreate(
                ['id' => $categoria['id']],
                [
                    'id' => $categoria['id'],
                    'nombre' => $categoria['nombre'],
                    'activo' => (bool) ($categoria['activo'] ?? 1),
                    'created_at' => $categoria['created_at'] ?? null,
                    'updated_at' => $categoria['updated_at'] ?? null,
                    'deleted_at' => $categoria['deleted_at'] ?? null,
                ]
            );
        }
    }
}
