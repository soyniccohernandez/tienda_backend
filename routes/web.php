<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//Controladores

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProductosBackendController;
use App\Http\Controllers\ResenaController;
use App\Http\Controllers\UserController;

Route::get('/', [ProductoController::class, 'index'])->name('productos.index');
Route::get('/productos/{producto}', [ProductoController::class, 'show'])->name('productos.show');
Route::post('/productos/{producto}/resenas', [ResenaController::class, 'store'])->name('resenas.store');


// Usuarios
Route::resource('users', UserController::class);

// Categorias
Route::resource('categorias', CategoriaController::class);

// Productos Backend
Route::resource('productosback', ProductosBackendController::class)->parameters([
    'productosback' => 'producto'
]);

//Ruta para la documentación de la API
Route::get('/api-documentation', function () {
    return view('api.index');
})->name('api.documentation');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
