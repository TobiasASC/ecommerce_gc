<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class productosProduccionSeeder extends Seeder
{
    private const CLOUDINARY_BASE_URL = 'https://res.cloudinary.com/itqrze8h/image/upload/v1785812234/home/productos/';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = base_path('json-produccion/productos_202608040016.json');

        if (!File::exists($path)) {
            $this->command->warn('No se encontró el archivo JSON de productos.');
            return;
        }

        $payload = json_decode(File::get($path), true, 512, JSON_THROW_ON_ERROR);

        foreach ($payload['productos'] ?? [] as $producto) {
            Producto::updateOrCreate(
                ['id' => $producto['id']],
                [
                    'id' => $producto['id'],
                    'nombre' => $producto['nombre'],
                    'descripcion' => $producto['descripcion'],
                    'precio_venta' => (float) ($producto['precio_venta'] ?? 0),
                    'stock_actual' => (int) ($producto['stock_actual'] ?? 0),
                    'stock_minimo' => (int) ($producto['stock_minimo'] ?? 0),
                    'activo' => (bool) ($producto['activo'] ?? 1),
                    'categoria_id' => $producto['categoria_id'],
                    'imagen_url' => $this->normalizeImageUrl($producto['imagen_url'] ?? null),
                    'created_at' => $producto['created_at'] ?? null,
                    'updated_at' => $producto['updated_at'] ?? null,
                    'deleted_at' => $producto['deleted_at'] ?? null,
                ]
            );
        }
    }

    private function normalizeImageUrl(?string $value): ?string
    {
        if (empty($value)) {
            return null;
        }

        // 1. Extrae el nombre del archivo de la ruta local
        $filename = basename(str_replace('\\', '/', $value));

        // 2. MÁGIA: Cambia .jpeg a .jpg para que coincida con Cloudinary
        $filename = str_ireplace('.jpeg', '.jpg', $filename);

        // 3. Arma la URL final
        return self::CLOUDINARY_BASE_URL . $filename;
    }
}
