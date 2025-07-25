<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\ListaController;
use App\Http\Controllers\PreciosController;
use App\Jobs\ActualizarProductoJob;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/excel-prueba',[ExcelController::class,'POST_excel'])->name('POST_cargarexcel');
Route::get('/excel-descarga',[ExcelController::class,'GET_exportarExcel'])->name('GET_exportarexcel');
Route::get('/buscar-url',[PreciosController::class,'buscaEnWurth'])->name('GET_wurth');
Route::get('/GET_productos',[ListaController::class,'GET_productos'])->name('GET_productos');
Route::get('/GET_datatable',[ListaController::class,'GET_datatable'])->name('GET_datatable');

Route::get('/buscar-sinurl',[PreciosController::class,'buscaEnWurthSinUrl'])->name('GET_wurth_sinurl');
Route::post('/actualizar-precios',[PreciosController::class,'updatePrecios'])->name('GET_actualizaprecio');
Route::post('/actualizar-all-precios',[PreciosController::class,'updateAllPrecios'])->name('GET_AllPrecios');

Route::post('/actualizarJob',[PreciosController::class,'updateAllJob'])->name('GET_actualizar_job');

