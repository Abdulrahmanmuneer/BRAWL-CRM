<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TextileController;
use Illuminate\Support\Facades\Route;

// Routes for Customer CRUD operations
Route::post('/register-customer', [CustomerController::class, 'store']);   // Register a new customer
Route::get('/customers', [CustomerController::class, 'index']);            // Get all customers
Route::get('/customer/{id}', [CustomerController::class, 'show']);         // Get a specific customer
Route::put('/update-customer/{id}', [CustomerController::class, 'update']); // Update a specific customer
Route::delete('/delete-customer/{id}', [CustomerController::class, 'destroy']); // Delete a customer

// Routes for Textile CRUD operations
Route::post('/add-textile', [TextileController::class, 'store']);           // Add a new textile
Route::get('/textiles', [TextileController::class, 'index']);               // Get all textiles
Route::get('/textile/{id}', [TextileController::class, 'show']);            // Get a specific textile
Route::put('/update-textile/{id}', [TextileController::class, 'update']);   // Update a specific textile
Route::delete('/delete-textile/{id}', [TextileController::class, 'destroy']); // Delete a textile

// routes/api.php


// Customer routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('customers', [CustomerController::class, 'index']);            // Get all customers
    Route::post('customers', [CustomerController::class, 'store']);           // Create a new customer
    Route::get('customers/{id}', [CustomerController::class, 'show']);        // Get a specific customer
    Route::put('customers/{id}', [CustomerController::class, 'update']);      // Update a specific customer
    Route::delete('customers/{id}', [CustomerController::class, 'destroy']);  // Delete a customer
});

// Textile routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('textiles', [TextileController::class, 'index']);            // Get all textiles
    Route::post('textiles', [TextileController::class, 'store']);           // Add a new textile
    Route::get('textiles/{id}', [TextileController::class, 'show']);        // Get a specific textile
    Route::put('textiles/{id}', [TextileController::class, 'update']);      // Update a specific textile
    Route::delete('textiles/{id}', [TextileController::class, 'destroy']);  // Delete a textile
});
