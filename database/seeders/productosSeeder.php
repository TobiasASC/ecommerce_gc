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
    ['nombre' => 'Bolso de arpillera', 'descripcion' => 'Bolso de arpillera con detalles de tela cuadriculada, ideal para llevar tus compras o pertenencias de forma práctica y con estilo. Su diseño resistente combina utilidad y un toque rústico.', 'precio_venta' => 5000, 'stock_actual' => 10, 'stock_minimo' => 5, 'imagen_url' => 'img/productos/bolsoArpilleraDetallesCuadriculados.jpeg', 'activo' => 1, 'categoria_id' => 1],
    ['nombre' => 'Bolso de tela cuadriculado', 'descripcion' => 'Bolso de tela cuadriculado, perfecto para uso diario o para organizar objetos pequeños. Su forma sencilla y funcional lo convierte en una opción versátil para cualquier ocasión.', 'precio_venta' => 5000, 'stock_actual' => 10, 'stock_minimo' => 5, 'imagen_url' => 'img/productos/bolso-tela-estilo-cuadriculas.jpeg', 'activo' => 1, 'categoria_id' => 1],
    ['nombre' => 'Bolso de lienzo y tela', 'descripcion' => 'Bolso de lienzo y tela con un diseño cómodo y elegante, pensado para quienes buscan un accesorio práctico para el día a día. Combina resistencia, estilo y buena capacidad de carga.', 'precio_venta' => 5000, 'stock_actual' => 10, 'stock_minimo' => 5, 'imagen_url' => 'img/productos/bolso-lienzo-tela.jpeg', 'activo' => 1, 'categoria_id' => 1],
    ['nombre' => 'Bolsita de cumpleaños de lienzo', 'descripcion' => 'Bolsita de cumpleaños de lienzo, ideal para regalar detalles y sorpresas en celebraciones especiales. Su diseño delicado y funcional la hace perfecta para eventos memorables.', 'precio_venta' => 2000, 'stock_actual' => 10, 'stock_minimo' => 5, 'imagen_url' => 'img/productos/bolsita-cumpleaños.jpeg', 'activo' => 1, 'categoria_id' => 1],
    ['nombre' => 'Bolso de lienzo y arpillera', 'descripcion' => 'Bolso de lienzo y arpillera, diseñado para quienes desean un accesorio práctico con un estilo artesanal. Es ideal para llevar objetos esenciales de forma cómoda y organizada.', 'precio_venta' => 5000, 'stock_actual' => 10, 'stock_minimo' => 5, 'imagen_url' => 'img/productos/bolso-lienzo-arpillera.jpeg', 'activo' => 1, 'categoria_id' => 1],
    ['nombre' => 'Bolso grande de arpillera y tela', 'descripcion' => 'Bolso grande de arpillera y tela, perfecto para guardar prendas, artículos del hogar o elementos de uso cotidiano. Ofrece amplio espacio y una apariencia natural muy atractiva.', 'precio_venta' => 5000, 'stock_actual' => 10, 'stock_minimo' => 5, 'imagen_url' => 'img/productos/super-bolso-arpillera-tela.jpeg', 'activo' => 1, 'categoria_id' => 1],
    ['nombre' => 'Payasito almohadones', 'descripcion' => 'Almohadones de payasito decorativo, ideales para dar un toque divertido y creativo a cualquier espacio. Su diseño llamativo aporta color y personalidad a la decoración.', 'precio_venta' => 5000, 'stock_actual' => 10, 'stock_minimo' => 5, 'imagen_url' => 'img/productos/payasito-almohadon-decorativo.jpeg', 'activo' => 1, 'categoria_id' => 3],
    ['nombre' => 'Lapicero decorativo', 'descripcion' => 'Lapicero decorativo con un diseño especial que combina estética y funcionalidad. Perfecto como detalle personal, regalo o elemento de escritorio con carácter.', 'precio_venta' => 5000, 'stock_actual' => 10, 'stock_minimo' => 5, 'imagen_url' => 'img/productos/lapicero-decorativo.jpeg', 'activo' => 1, 'categoria_id' => 3],
    ['nombre' => 'Llaveros con diseños', 'descripcion' => 'Llaveros con diseños a elección, ideales para regalar o personalizar con un toque único. Son prácticos, ligeros y perfectos para llevar siempre contigo.', 'precio_venta' => 1500, 'stock_actual' => 10, 'stock_minimo' => 5, 'imagen_url' => 'img/productos/llaveros-diseños.jpeg', 'activo' => 1, 'categoria_id' => 2],
    ];
        foreach ($productos as $producto) {
    Producto::updateOrCreate(['nombre' => $producto['nombre']], $producto);
    }
    }
}
