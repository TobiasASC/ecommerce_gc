<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;

Route::get('/', [InicioController::class, 'index'])->name('inicio');

Route::get('/login', [AuthController::class, 'formularioLogin'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/login', [AuthController::class, 'autenticar'])->name('login.post');


Route::get('/register', [AuthController::class, 'formularioRegistro'])->name('register');

Route::post('/register', [AuthController::class, 'registrar'])->name('register.post');

Route::get('/catalogo', [ProductoController::class, 'index'])->name('catalogo');

Route::get('/categorias/{id}', [ProductoController::class, 'categoria'])->name('catalogo.categoria');

Route::get('/producto/{id}', [ProductoController::class, 'mostrarEspecifico'])
->name('producto.mostrar');


/* ================== MIDDLEWARE DEL ADMIN ================== */
Route::middleware(['auth', 'admin'])->group(function () {

Route::get('/admin', [AdminController::class, 'index'])->name('admin.cuenta');

Route::get('/estadisticas', function () {
    return view('admin.adminEstadisticas');
})->name('admin.estadisticas');

Route::get('/clientes', function () {
    return view('admin.adminClientes');
})->name('admin.clientes');

Route::get('/pedidosAdmin', function () {
    return view('admin.adminPedidos');
})->name('admin.pedidos');

Route::get('/productos', function () {
    return view('admin.adminProductos');
})->name('admin.productos');

Route::get('/categorias', function () {
    return view('admin.adminCategorias');
})->name('admin.categorias');

});


/* ================== MIDDLEWARE DEL CLIENTE ================== */
Route::middleware(['auth', 'cliente'])->group(function () {

Route::get('/cuentaCliente', [ClienteController::class, 'index'])->name('cliente.cuenta');

Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.mostrar');

Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');

Route::delete('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');

Route::put('/cuentaCliente', [ClienteController::class, 'actualizar'])->name('cliente.actualizar');

Route::delete('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');




Route::get('/pedidosCliente', [PedidoController::class, 'pedidosCliente'])->name('cliente.pedidos');


});
