<?php

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

Route::middleware('web')->group(function () {
    Route::get('/products/search', [\App\Http\Controllers\ProductController::class, 'search']);
    Route::post('/cart/update', [\App\Http\Controllers\CartController::class, 'update']);
    Route::post('/cart/remove', [\App\Http\Controllers\CartController::class, 'remove']);
    Route::post('/cart/checkout', [\App\Http\Controllers\CartController::class, 'checkout']);
});
