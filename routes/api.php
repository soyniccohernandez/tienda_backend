<?php

use Illuminate\Support\Facades\Route;

// Controladores API (en App\Http\Controllers\Api)
use App\Http\Controllers\Api\ProductoApiController;
use App\Http\Controllers\Api\ResenaApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\CategoriaApiController;
use App\Http\Controllers\Api\ProductosBackendApiController;
use App\Http\Controllers\Api\ProfileApiController;

// Productos
Route::get('/productos', [ProductoApiController::class, 'index']);           // Listar productos
Route::get('/productos/{producto}', [ProductoApiController::class, 'show']); // Ver un producto
Route::post('/productos/{producto}/resenas', [ResenaApiController::class, 'store']); // Crear reseña

// Usuarios
Route::apiResource('users', UserApiController::class);

// Categorías
Route::apiResource('categorias', CategoriaApiController::class);

// Productos Backend
Route::apiResource('productosback', ProductosBackendApiController::class)
    ->parameters(['productosback' => 'producto']);

// Perfil (versión API JSON, sin autenticación)
Route::get('/profile', [ProfileApiController::class, 'show']);
Route::put('/profile', [ProfileApiController::class, 'update']);
Route::delete('/profile', [ProfileApiController::class, 'destroy']);
