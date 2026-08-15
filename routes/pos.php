<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pos\ProductController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PosController;

Route::middleware(['auth:pos'])->group(function () {
    Route::controller(PosController::class)->name('pos.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/order', 'order')->name('order');
        Route::get('/order/search', 'search')->name('search');
        Route::get('/order/create', 'save')->name('save');
        Route::get('/order/view/{id}', 'orderView')->name('order.view');
        Route::post('/order/payment/{id}', 'payment')->name('order.payment');
    });
});