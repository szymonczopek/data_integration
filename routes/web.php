<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', [App\Http\Controllers\readFileController::class,'displayMainView']);

Route::post('/laptop', [App\Http\Controllers\LaptopController::class,'newLaptop']);
Route::get('/laptops', [App\Http\Controllers\LaptopController::class,'displayAllLaptops']);
Route::get('/laptop/{id}', [App\Http\Controllers\LaptopController::class,'displayLaptop']);
Route::patch('/laptop/{id}', [App\Http\Controllers\LaptopController::class,'editLaptop']);
Route::delete('/laptop/{id}', [App\Http\Controllers\LaptopController::class,'deleteLaptop']);





Route::get('/importCsvFile', [App\Http\Controllers\readFileController::class,'importCsvFile']);

Route::post('/exportCsvFile', [App\Http\Controllers\readFileController::class,'exportCsvFile']);
Route::get('/exportCsvFile', [App\Http\Controllers\readFileController::class,'exportCsvFile']);



Route::get('/importXmlFile', [App\Http\Controllers\readXmlController::class,'importXmlFile']);

Route::post('/exportXmlFile', [App\Http\Controllers\readXmlController::class,'exportXmlFile']);
Route::get('/exportXmlFile', [App\Http\Controllers\readXmlController::class,'exportXmlFile']);








