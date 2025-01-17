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

/*******************************************  Rutas de la administracion *************************************************** */
Route::get('/dashboard',[\App\Http\Controllers\AdminController::class,'dashboard'])->middleware(['auth'])->name('dashboard');
/****************Aqui cargamos todos los privilegios *****************/
Route::get('/dashboard/{any}',[\App\Http\Controllers\AdminController::class,'page'])->where('any','.*')->middleware('auth')->name('priv_admin');
Route::post('/dashboard/save-admin',[\App\Http\Controllers\AdminController::class,'post'])->middleware('auth')->name('post_admin');
/*********************************************************************************************/
require __DIR__.'/auth.php';
