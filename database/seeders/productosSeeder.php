<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Producto;

class productosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $productos =[
    ['nombre' => 'Bolso de arpillera', 'descripcion' => 'Bolso de arpillera con detalles de tela cuadriculada ideal para cualquier tipo de uso', 'precio_venta' => 5000, 'stock_actual' => 10, 'stock_minimo' => 5, 'imagen_url' => 'img/productos/bolsoArpilleraDetallesCuadriculados.jpeg', 'activo' => 1, 'categoria_id' => 1],
    ['nombre' => 'Bolso de tela cuadriculado', 'descripcion' => 'Bolso de tela ideal para cualquier tipo de uso', 'precio_venta' => 5000, 'stock_actual' => 10, 'stock_minimo' => 5, 'imagen_url' => 'img/productos/bolso-tela-estilo-cuadriculas.jpeg', 'activo' => 1, 'categoria_id' => 1],
    ['nombre' => 'Bolso de lienzo y tela', 'descripcion' => 'Bolso de lienzo y tela ideal para cualquier tipo de uso', 'precio_venta' => 5000, 'stock_actual' => 10, 'stock_minimo' => 5, 'imagen_url' => 'img/productos/bolso-lienzo-tela.jpeg', 'activo' => 1, 'categoria_id' => 1],
    ['nombre' => 'Bolsita de cumpleaños de lienzo', 'descripcion' => 'Bolsita de cumpleaños de lienzo', 'precio_venta' => 2000, 'stock_actual' => 10, 'stock_minimo' => 5, 'imagen_url' => 'img/productos/bolsita-cumpleaños.jpeg', 'activo' => 1, 'categoria_id' => 1],
    ['nombre' => 'Bolso de lienzo y arpillera', 'descripcion' => 'Bolso para llevar de lienzo y arpillera', 'precio_venta' => 5000, 'stock_actual' => 10, 'stock_minimo' => 5, 'imagen_url' => 'img/productos/bolso-lienzo-arpillera.jpeg', 'activo' => 1, 'categoria_id' => 1],
    ['nombre' => 'Bolso grande de arpillera y tela', 'descripcion' => 'Super bolso para guardar cosas en el hogar', 'precio_venta' => 5000, 'stock_actual' => 10, 'stock_minimo' => 5, 'imagen_url' => 'img/productos/super-bolso-arpillera-tela.jpeg', 'activo' => 1, 'categoria_id' => 1],
    ['nombre' => 'Payasito almohadones', 'descripcion' => 'Almohadones de payasito decorativo', 'precio_venta' => 5000, 'stock_actual' => 10, 'stock_minimo' => 5, 'imagen_url' => 'img/productos/payasito-almohadon-decorativo.jpeg', 'activo' => 1, 'categoria_id' => 3],
    ['nombre' => 'Lapicero decorativo', 'descripcion' => 'Lapicero decorativo', 'precio_venta' => 5000, 'stock_actual' => 10, 'stock_minimo' => 5, 'imagen_url' => 'img/productos/lapicero-decorativo.jpeg', 'activo' => 1, 'categoria_id' => 3],
    ['nombre' => 'Llaveros con diseños', 'descripcion' => 'Llaveros con diseños a elección', 'precio_venta' => 1500, 'stock_actual' => 10, 'stock_minimo' => 5, 'imagen_url' => 'img/productos/llaveros-diseños.jpeg', 'activo' => 1, 'categoria_id' => 2],
    ];
        foreach ($productos as $producto) {
    Producto::firstOrCreate(['nombre' => $producto['nombre']], $producto);
    }
    }
}
