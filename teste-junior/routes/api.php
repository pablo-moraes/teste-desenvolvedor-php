<?php

use App\Http\Controllers\ProductController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('get_products');
    Route::get('/{id}', [ProductController::class, 'show'])->name('show_product');
    Route::put('/{id}', [ProductController::class, 'update'])->name('update_product');
    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('delete_product');
    Route::post('/', [ProductController::class, 'store'])->name('create_product');
});
