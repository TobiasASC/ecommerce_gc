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
    ['nombre' => 'Bolsos'],
    ['nombre' => 'Llaveros'],
    ['nombre' => 'Decoraciones'],
    ];
    foreach ($categorias as $categoria) {
    Categoria::firstOrCreate(['nombre' => $categoria['nombre']], $categoria);
    }
    }
}
