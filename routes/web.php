<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductoController;

Route::get('/', [InicioController::class, 'index']);

Route::get('/login', [AuthController::class, 'formularioLogin']);

Route::post('/logout', [AuthController::class, 'logout']);

Route::post('/login', [AuthController::class, 'autenticar']);


Route::get('/register', [AuthController::class, 'formularioRegistro']);

Route::post('/register', [AuthController::class, 'registrar']);

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

Route::get('/pedidos', function () {
    return view('cliente.clientePedidos');
})->name('cliente.pedidos');


Route::get('/carrito', function () {
    return view('cliente.clienteCarrito');
})->name('cliente.carrito');


Route::put('/cuentaCliente', [ClienteController::class, 'actualizar'])->name('cliente.actualizar');

});
