<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/productos', [ProductoController::class, 'index']);
Route::post('/productos', [ProductoController::class, 'guardar']);

Route::get('/productos/{id}/editar', [ProductoController::class, 'editar']);
Route::put('/productos/{id}', [ProductoController::class, 'actualizar']);
Route::delete('/productos/{id}', [ProductoController::class, 'eliminar']);


use App\Http\Controllers\ClienteController;

Route::get('/clientes', [ClienteController::class, 'index']);
Route::post('/clientes', [ClienteController::class, 'guardar']);
Route::get('/clientes/{id}/editar', [ClienteController::class, 'editar']);
Route::put('/clientes/{id}', [ClienteController::class, 'actualizar']);
Route::delete('/clientes/{id}', [ClienteController::class, 'eliminar']);


use App\Http\Controllers\VentaController;

Route::get('/ventas', [VentaController::class, 'index']);
Route::post('/ventas', [VentaController::class, 'guardar']);
Route::put('/ventas/{id}/estado', [VentaController::class, 'cambiarEstado']);
Route::delete('/ventas/{id}', [VentaController::class, 'eliminar']);
