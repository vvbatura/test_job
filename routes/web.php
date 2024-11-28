<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::group(['prefix' => '/orders'], function() {
        Route::get('', function () {
            return view('orders');
        })->name('orders');
        Route::get('/new', [\App\Http\Controllers\OrderController::class, 'create'])->name('orders.new');
    });

});
