<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FileJsonController;


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
    return view('dashboard');
});


Route::resource('products', ProductController::class);
Route::resource('orders', OrderController::class);
Route::get('/orders/invoice/{id}', [OrderController::class, 'invoice'])->name('orders.invoice');
Route::resource('file-json', FileJsonController::class);
