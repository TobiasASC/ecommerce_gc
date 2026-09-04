<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\CatalogoController;

Route::get('/', [InicioController::class, 'index'])->name('inicio');
Route::get('/catalogo', [CatalogoController::class, 'index'])->name('catalogo');
Route::get('/productos/buscar', [CatalogoController::class, 'buscar'])->name('productos.buscar');
Route::get('/productos/sugerencias', [CatalogoController::class, 'sugerencias'])->name('productos.sugerencias');
Route::get('/categorias/{id}', [CatalogoController::class, 'categoria'])->name('catalogo.categoria');
Route::get('/producto/{id}', [CatalogoController::class, 'mostrarEspecifico'])->name('producto.mostrar');
