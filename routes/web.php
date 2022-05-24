<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RemisionController;
use App\Http\Controllers\IndexController;
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

//REMISION
Route::resource('/remision', RemisionController::class);
Route::get('/get-all-remisiones/{id}',[IndexController::class,'getAllRemisiones']);
Route::get('/download-pdf/{id}',[IndexController::class,'downloadPDF']);
Route::get('get/remision/number',[RemisionController::class,'getLastRemision']);
Route::get('remision-list',[RemisionController::class,'RemisionList']);
Route::post('remision/update/{id}',[RemisionController::class,'update']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
