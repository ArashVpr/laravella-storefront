<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CarController;

Route::get('/', [HomeController::class, 'index'])->name('homepage');

Route::fallback(function () {
    return 'Nadarim AMUUUUUUUUU';
});

Route::get('/car/search', [CarController::class, 'search'])->name('car.search');
Route::get('/car/{car}', [CarController::class, 'show'])->name('car.show');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


require_once __DIR__ . '/auth.php';
