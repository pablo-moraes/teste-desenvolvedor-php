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
    return redirect('home');
});

Route::get('/home', function () {
    return view('layouts.app');
})->name('home');

// Product
Route::prefix('product')->group(function () {
    Route::view('/', 'pages.product')->name('view_products');
    Route::view('/{id}/edit', 'pages.product')->name('update_product_form');
    Route::view('/create', 'pages.product')->name('create_product_form');
});

Route::fallback(function () {
    return view('pages.not-found');
});
