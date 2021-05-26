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
Route::middleware('auth:sanctum')->group(function(){
    Route::post('logout', [\App\Http\Controllers\API\LoginController::class, 'logout']);
    Route::get('user', [\App\Http\Controllers\API\LoginController::class, 'getUser']);
    Route::get('products', [\App\Http\Controllers\API\ProductController::class, 'getProducts']);
    Route::get('categories', [\App\Http\Controllers\API\ProductController::class, 'getCategories']);
    Route::get('branches', [\App\Http\Controllers\API\ProductController::class, 'getBranches']);
    Route::post('order-confirmed', [\App\Http\Controllers\API\ProductController::class, 'orderConfirmed']);
    Route::post('order/histories', [\App\Http\Controllers\API\ProductController::class, 'getOrderHistories']);
});

Route::post('/login', [\App\Http\Controllers\API\LoginController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\API\LoginController::class, 'register']);
