<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\PreciosController;

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

Route::get('/ejercicioprueba1',[InicioController::class,'ejercicio1'])->name('ejerciciophp');
Route::get('/ejercicioprueba2',[InicioController::class,'ejercicio2'])->name('ejercicio2php');
Route::get('/ejercicioprueba3',[InicioController::class,'ejercicio3'])->name('ejercicio3php');

Route::post('/excel-prueba',[ExcelController::class,'POST_excel'])->name('POST_cargarexcel');
Route::get('/excel-descarga',[ExcelController::class,'GET_exportarExcel'])->name('GET_exportarexcel');
Route::get('/buscar-url',[PreciosController::class,'buscaEnWurth'])->name('GET_wurth');
Route::get('/buscar-sinurl',[PreciosController::class,'buscaEnWurthSinUrl'])->name('GET_wurth_sinurl');
Route::post('/actualizar-precios',[PreciosController::class,'updatePrecioFinal'])->name('POST_actualizaprecio');