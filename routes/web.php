<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClientePedidoController;
use App\Http\Controllers\AdminPedidoController;
use App\Http\Controllers\CatalogoController;

// Debug route to inspect APP_URL and config('app.url') in production
Route::get('/__debug/app-url', function () {
    return response()->json([
        'env_APP_URL' => env('APP_URL'),
        "config_app_url" => config('app.url'),
        'forced_root' => \Illuminate\Support\Facades\URL::getRootUrl(),
        'request_full_url' => request()->fullUrl(),
        'request_host' => request()->getHost(),
    ]);
});

Route::get('/', [InicioController::class, 'index'])->name('inicio');

Route::get('/login', [AuthController::class, 'formularioLogin'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/login', [AuthController::class, 'autenticar'])->name('login.post');


Route::get('/register', [AuthController::class, 'formularioRegistro'])->name('register');

Route::post('/register', [AuthController::class, 'registrar'])->name('register.post');

// Devuelve el catalogo con todos los productos y categorias
Route::get('/catalogo', [CatalogoController::class, 'index'])->name('catalogo');

Route::get('/categorias/{id}', [CatalogoController::class, 'categoria'])->name('catalogo.categoria');

Route::get('/producto/{id}', [CatalogoController::class, 'mostrarEspecifico'])->name('producto.mostrar');


/* ================== MIDDLEWARE DEL ADMIN ================== */
Route::middleware(['auth', 'admin'])->group(function () {

// Muestra todos los clientes registrados
Route::get('/clientes', [AdminController::class, 'clientes'])->name('admin.clientes');

// Hacer administrador a un cliente
Route::patch('/admin/clientes/{id}/hacer-admin', [AdminController::class, 'hacerAdmin'])->name('admin.clientes.hacer-admin');

// Quitar administrador (volver a hacer cliente)
Route::patch('/admin/clientes/{id}/hacer-cliente', [AdminController::class, 'hacerCliente'])->name('admin.clientes.hacer-cliente');

// Muestra todos los pedidos
Route::get('/admin/pedidos', [AdminPedidoController::class, 'pedidos'])->name('admin.pedidos');

// Muestra el detalle de todos los pedidos
Route::get('/admin/pedidos/{id}', [AdminPedidoController::class, 'detalle'])->name('admin.pedidos.detalle');

// Confirma un pedido
Route::put('/admin/pedidos/{id}/confirmar', [AdminPedidoController::class, 'confirmar'])->name('admin.pedidos.confirmar');



// Mostrar la lista de productos para el Admin
Route::get('/admin/productos', [ProductoController::class, 'index'])->name('admin.productos.index');

// Mostrar el formulario para editar un producto 
Route::get('/admin/productos/{id}/editar', [ProductoController::class, 'edit'])->name('admin.productos.edit');

// Recibir los datos y actualizar el producto
Route::put('/admin/productos/{id}', [ProductoController::class, 'actualizar'])->name('admin.productos.update');

// Eliminar un producto
Route::delete('/admin/productos/{id}', [ProductoController::class, 'destroy'])->name('admin.productos.destroy');

// Devuelve la vista para crear un nuevo producto
Route::get('/admin/productos/crear', [ProductoController::class, 'crear'])->name('admin.productos.crear');

// Guarda los campos del nuevo producto creado
Route::post('/admin/productos/guardar', [ProductoController::class, 'guardar'])->name('admin.productos.guardar');

// Devuelve la vista con las categorias
Route::get('/admin/categorias', [CategoriaController::class, 'index'])->name('admin.categorias.index');

// Guardar una nueva categoría (Viene del Modal)
Route::post('/categorias', [CategoriaController::class, 'store'])->name('admin.categorias.store');

// Eliminar una categoría
Route::delete('/categorias/{id}', [CategoriaController::class, 'destroy'])->name('admin.categorias.destroy');

// Ruta para procesar la edición desde el modal
Route::put('/admin/categorias/{id}', [CategoriaController::class, 'actualizar'])->name('admin.categorias.actualizar');

});


/* ================== MIDDLEWARE DEL CLIENTE ================== */
Route::middleware(['auth', 'cliente'])->group(function () {

// Muestra vista con datos del cliente
Route::get('/cuentaCliente', [ClienteController::class, 'index'])->name('cliente.cuenta');

// Actualiza los datos del cliente
Route::put('/cuentaCliente', [ClienteController::class, 'actualizar'])->name('cliente.actualizar');

// Mostrar el carrito con sus datos
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.mostrar');

// Agrega un producto al carrito
Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');

// Elimina un producto del carrito
Route::delete('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');

// Vacia el carrito (elimina detalles del pedido)
Route::delete('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');

// Procesa la compra y se confirma (estado= confirmado)
Route::post('/carrito/procesar', [CarritoController::class, 'procesar'])->name('carrito.procesar');

// Muestra la vista de compra confirmada
Route::get('/compraConfirmada', function () {
    return view('cliente.compraConfirmada');
})->name('compra.confirmada');

// Actualiza la cantidad de unidades de los productos del carrito
Route::put('/carrito/actualizar/{id}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');

Route::get('/pedidosCliente', [ClientePedidoController::class, 'pedidos'])->name('cliente.pedidos');

// Dentro de tu grupo de rutas para CLIENTE:
Route::get('/mis-pedidos/{id}', [ClientePedidoController::class, 'detalle'])->name('cliente.pedidos.detalle');



});
