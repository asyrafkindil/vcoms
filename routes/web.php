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
    return redirect()->route('dashboard');
    // return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('/dashboard', App\Http\Livewire\Dashboard\Index::class)->name('dashboard');
});

Route::middleware(['auth:sanctum', 'verified', 'role:Admin'])->group(function(){

    Route::get('/branch', App\Http\Livewire\Branch\Index::class)->name('branch.index');

    Route::get('/category', App\Http\Livewire\Category\Index::class)->name('category.index');

    Route::get('/product', App\Http\Livewire\Product\Index::class)->name('product.index');

    Route::get('/order', App\Http\Livewire\Order\Index::class)->name('order.index');

    Route::get('/user', App\Http\Livewire\User\Index::class)->name('user.index');

    Route::get('/customer', App\Http\Livewire\Customer\Index::class)->name('customer.index');
});
