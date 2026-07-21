<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class categoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $categorias =[
    ['nombre' => 'Bolsos', 'descripcion' => 'Bolsos de tela utiles para todo tipo de uso'],
    ['nombre' => 'Llaveros', 'descripcion' => 'Llaveros para darle vida a lo que te importa'],
    ['nombre' => 'Decoraciones', 'descripcion' => 'Decora cada rincon de tu hogar'],
    ];
    foreach ($categorias as $categoria) {
    Categoria::firstOrCreate(['nombre' => $categoria['nombre']], $categoria);
    }
    }
}
