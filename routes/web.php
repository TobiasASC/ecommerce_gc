<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdminController;

Route::get('/', [InicioController::class, 'index']);

Route::get('/login', [AuthController::class, 'formularioLogin']);

Route::post('/logout', [AuthController::class, 'logout']);

Route::post('/login', [AuthController::class, 'autenticar']);


Route::get('/register', [AuthController::class, 'formularioRegistro']);

Route::post('/register', [AuthController::class, 'registrar']);


/* MIDDLEWARE DEL ADMIN */
Route::middleware(['auth', 'admin'])->group(function () {

Route::get('/admin', [AdminController::class, 'admin'])->name('admin.cuenta');

});


/* MIDDLEWARE DEL CLIENTE */
Route::middleware(['auth', 'cliente'])->group(function () {

Route::get('/cuentaCliente', [ClienteController::class, 'index'])->name('cliente.cuenta');

});
