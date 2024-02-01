<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MultiDeleteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group( function () {
    // Product
    Route::prefix('product')->controller(ProductController::class)->group(function () {
        Route::get('/', 'index')->name('get_products');
        Route::get('/{id}', 'show')->name('show_product');
        Route::put('/{id}', 'update')->name('update_product');
        Route::delete('/{id}', 'destroy')->name('delete_product');
        Route::post('/', 'store')->name('create_product');
        Route::post('/search', 'search')->name('search_product');
    });

// Customer
    Route::prefix('customer')->controller(CustomerController::class)->group(function () {
        Route::get('/', 'index')->name('get_customers');
        Route::get('/{id}', 'show')->name('show_customer');
        Route::put('/{id}', 'update')->name('update_customer');
        Route::delete('/{id}', 'destroy')->name('delete_customer');
        Route::post('/', 'store')->name('create_customer');
        Route::post('/search', 'search')->name('search_customer');
    });

// Order
    Route::prefix('order')->controller(OrderController::class)->group(function () {
        Route::get('/', 'index')->name('get_orders');
        Route::get('/{id}', 'show')->name('show_order');
        Route::put('/{id}', 'update')->name('update_order');
        Route::delete('/{id}', 'destroy')->name('delete_order');
        Route::post('/', 'store')->name('create_order');
    });

    Route::delete('/multi-delete/{entity}', [MultiDeleteController::class, 'destroy'])->name('multi_delete_entities');
});

Route::prefix('user')->group(function () {
   Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('/register', [RegisterController::class, 'store'])->name('register');
});
