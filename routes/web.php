<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WatchlistController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', [HomeController::class, 'index'])->name('homepage');

Route::get('/car/search', [CarController::class, 'search'])->name('car.search');

// AUTHENTICATED and VERIFIED users
Route::middleware(['auth'])->group(callback: function () {
    Route::middleware(['verified'])->group(function () {
        Route::get('/watchlist', [WatchlistController::class, 'index'])
            ->name('watchlist.index');
        Route::post('/watchlist/{car}', [WatchlistController::class, 'storeDestroy'])
            ->name('watchlist.storeDestroy');

        Route::resource('car', CarController::class)->except(['show']);
        Route::get('/car/{car}/images', [CarController::class, 'carImages'])
            ->name('car.images');
        Route::put('/car/{car}/images', [CarController::class, 'updateImages'])
            ->name('car.updateImages');
        Route::post('/car/{car}/images', [CarController::class, 'addImages'])
            ->name('car.addImages');
    });

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.updatePassword');
});

Route::get('/car/{car}', [CarController::class, 'show'])->name('car.show');
Route::post('/car/phone/{car}', [CarController::class, 'showPhone'])->name('car.showPhone');

// to download files
Route::get('/download-cv', function () {
    return Storage::download('VAFAPOUR.pdf');
})->name('download.cv');

    //documentation
    Route::get('/docs', function () {
        return view('components.documentation');
    })->name('docs');


require __DIR__ . '/auth.php';
