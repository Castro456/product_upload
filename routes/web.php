<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
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

Route::get('/', [HomeController::class, 'home_page']);

Route::group(['prefix' => 'products'], function() {
  Route::get('/upload', [HomeController::class, 'home_page']);
  Route::get('/', [ProductController::class, 'index']);
  Route::get('/export', [ProductController::class, 'export']);
  Route::post('/import', [ProductController::class, 'import']);
});

