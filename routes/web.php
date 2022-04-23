<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/gestion-de-productos',[\App\Http\Controllers\ProductoController::class,'index'], function ($id) {
});
Route::post('/guardar-producto-1000',[\App\Http\Controllers\ProductoController::class,'save'])->name('save_product');
Route::get('/ver-producto',[\App\Http\Controllers\ProductoController::class,'ver'])->name('ver_producto');
Route::get('/eliminar-producto',[\App\Http\Controllers\ProductoController::class,'delete'])->name('eliminar_producto');
Route::resource('/categorias', \App\Http\Controllers\CategoriaController::class)->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
