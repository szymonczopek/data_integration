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
Route::get('/', [App\Http\Controllers\readFileController::class,'displayTxtMain']);



Route::get('/importTxtFile', [App\Http\Controllers\readFileController::class,'importTxtFile']);
Route::post('/exportFile', [App\Http\Controllers\readFileController::class,'exportTxtFile']);
Route::get('/exportFile', [App\Http\Controllers\readFileController::class,'exportTxtFile']);

Route::get('/importXmlFile', [App\Http\Controllers\readXmlController::class,'importXmlFile']);

Route::get('/xml', [App\Http\Controllers\readXmlController::class,'displayXmlMain']);






