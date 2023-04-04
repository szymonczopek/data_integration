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

Route::get('/importFile', [App\Http\Controllers\readFileController::class,'readFile']);
Route::post('/exportFile', [App\Http\Controllers\readFileController::class,'exportFile']);
Route::get('/exportFile', [App\Http\Controllers\readFileController::class,'exportFile']);
Route::get('/', [App\Http\Controllers\readFileController::class,'displayMain']);


