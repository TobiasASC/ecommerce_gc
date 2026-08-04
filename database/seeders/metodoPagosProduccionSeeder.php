<?php

namespace Database\Seeders;

use App\Models\MetodoPago;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class metodoPagosProduccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = base_path('json-produccion/metodo_pagos_202608040018.json');

        if (!File::exists($path)) {
            $this->command->warn('No se encontró el archivo JSON de métodos de pago.');
            return;
        }

        $payload = json_decode(File::get($path), true, 512, JSON_THROW_ON_ERROR);

        foreach ($payload['metodo_pagos'] ?? [] as $metodoPago) {
            MetodoPago::updateOrCreate(
                ['id' => $metodoPago['id']],
                [
                    'id' => $metodoPago['id'],
                    'nombre' => $metodoPago['nombre'],
                    'created_at' => $metodoPago['created_at'] ?? null,
                    'updated_at' => $metodoPago['updated_at'] ?? null,
                    'deleted_at' => $metodoPago['deleted_at'] ?? null,
                ]
            );
        }
    }
}
