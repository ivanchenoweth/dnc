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

Auth::routes([
    'register'=>false,
    'reset'=>false,
    'verify'=>false,
    'confirm'=>false
    ]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->group(function () {   

    Route::post('Dncsrepos/repo', 'App\Http\Controllers\admin\DncsController@dncsrepo');

    Route::get('/repo/{action}', 'App\Http\Controllers\admin\DncsController@repo');
    Route::get('/exp/{action}', 'App\Http\Controllers\admin\DncsController@exp');

    Route::get('/importUsuarios', 'App\Http\Controllers\admin\UsuariosController@indeximport');
    Route::post('/importUsuarios/import', 'App\Http\Controllers\admin\UsuariosController@import');

    Route::get('/importDncs', 'App\Http\Controllers\admin\DncsController@indeximport');
    Route::post('/importDncs/import', 'App\Http\Controllers\admin\DncsController@import');

    Route::get('/importPlantillas', 'App\Http\Controllers\admin\PlantillasController@indeximport');
    Route::post('/importPlantillas/import', 'App\Http\Controllers\admin\PlantillasController@import');

    Route::resource('/Periodos', App\Http\Controllers\admin\PeriodosController::class);
    Route::resource('/Perfilusers', App\Http\Controllers\admin\PerfilusersController::class);
    Route::resource('/Usuarios', App\Http\Controllers\admin\UsuariosController::class);
    Route::resource('/Dncs', App\Http\Controllers\admin\DncsController::class);
    Route::resource('/Plantillas', App\Http\Controllers\admin\PlantillasController::class);
});