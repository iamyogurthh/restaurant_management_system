<?php

use App\Http\Controllers\DishesController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
    'confirm' => false
]);

Route::get('/', [OrderController::class, 'index'])->name("order.form");
Route::post('/order_submit', [OrderController::class, 'submit'])->name("order.submit");

Route::get('/order/{order}/approve', [DishesController::class, 'approve'])->name("order.approve");
Route::get('/order/{order}/cancel', [DishesController::class, 'cancel'])->name("order.cancel");
Route::get('/order/{order}/ready', [DishesController::class, 'ready'])->name("order.ready");
Route::get('/order/{order}/serve', [OrderController::class, 'serve'])->name("order.serve");

Route::resource('dish', DishesController::class);
Route::get('order', [DishesController::class, 'order'])->name('kitchen.order');
