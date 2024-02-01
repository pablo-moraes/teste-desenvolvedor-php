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

Route::middleware('auth:sanctum')->group(function () {

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

// Customer
    Route::prefix('customer')->group(function () {
        Route::view('/', 'pages.customer')->name('view_customers');
        Route::view('/{id}/edit', 'pages.customer')->name('update_customer_form');
        Route::view('/create', 'pages.customer')->name('create_customer_form');
    });

// Order
    Route::prefix('order')->group(function () {
        Route::view('/', 'pages.order')->name('view_orders');
        Route::view('/{id}/edit', 'pages.order')->name('update_order_form');
        Route::view('/create', 'pages.order')->name('create_order_form');
    });
});

Route::view('/login', 'pages.user.login')->name('login');
Route::view('/register', 'pages.user.register')->name('register');

Route::fallback(function () {
    return view('pages.not-found');
});
