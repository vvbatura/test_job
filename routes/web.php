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

    Route::group(['prefix' => '/orders', 'controller' => \App\Http\Controllers\OrderController::class], function() {
        Route::get('', function () {
            return view('orders');
        })->name('orders');
        Route::get('/new', 'create')->name('orders.new');
        Route::get('/{order}', 'edit')->name('orders.edit');
    });

});
