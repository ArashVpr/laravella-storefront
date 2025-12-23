<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CarController;
use App\Http\Controllers\Api\V1\WatchlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Version 1
|--------------------------------------------------------------------------
|
| RESTful API endpoints for the car marketplace.
| All v1 routes are prefixed with /api/v1
|
*/

// API v1 Routes
Route::prefix('v1')->name('api.v1.')->group(function () {

    // Public endpoints
    Route::get('cars', [CarController::class, 'index'])->name('cars.index');
    Route::get('cars/search', [CarController::class, 'search'])->name('cars.search');
    Route::get('cars/{car}', [CarController::class, 'show'])->name('cars.show');

    // Authentication endpoints
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');

    // Protected endpoints (require authentication)
    Route::middleware('auth:sanctum')->group(function () {
        // User
        Route::get('user', [AuthController::class, 'user'])->name('user');

        // Cars (CRUD)
        Route::post('cars', [CarController::class, 'store'])->name('cars.store');
        Route::put('cars/{car}', [CarController::class, 'update'])->name('cars.update');
        Route::delete('cars/{car}', [CarController::class, 'destroy'])->name('cars.destroy');

        // Watchlist
        Route::get('watchlist', [WatchlistController::class, 'index'])->name('watchlist.index');
        Route::post('watchlist/{car}', [WatchlistController::class, 'toggle'])->name('watchlist.toggle');
    });
});

// Rate limiting for API
Route::middleware('throttle:60,1')->group(function () {
    // Add rate-limited routes here if needed
});
