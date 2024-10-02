<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TextileController;

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
});

// Customer Routes
Route::resource('customers', CustomerController::class);

// Textile Routes
Route::resource('textiles', TextileController::class);


Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');


// web.php
Route::get('textiles/create', [TextileController::class, 'create'])->name('textiles.create');
Route::post('textiles', [TextileController::class, 'store'])->name('textiles.store');
