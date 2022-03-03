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

Route::middleware(['auth'])->group(function() {
    Route::get('/', [\App\Http\Controllers\Controller::class, 'index'])->name('dashboard');

    Route::controller(\App\Http\Controllers\Data\OrderController::class)->group(function() {
        Route::get('/orders/{order}', 'show')->name('orders.show');
    });

    Route::controller(\App\Http\Controllers\Generic\BlockController::class)->group(function() {
        Route::get('/orders/{order}/blocks/{block}', 'show')->name('blocks.show');
    });
});

require __DIR__.'/auth.php';

