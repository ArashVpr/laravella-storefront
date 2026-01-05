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
    return Storage::download('CA-f.pdf');
})->name('download.cv');

// Legal & Compliance pages
Route::view('/privacy', 'components.legal.privacy')->name('privacy');
Route::view('/mentions-legales', 'components.legal.mentions-legales')->name('mentions-legales');
Route::view('/cookies', 'components.legal.cookies')->name('cookies');

Route::get('/docs', function () {
    $viewName = 'components.documentation';
    /** @var view-string $viewName */
    return view($viewName);
})->name('docs');

Route::get('/docs-fr', function () {
    $viewName = 'components.documentation-fr';
    /** @var view-string $viewName */
    return view($viewName);
})->name('docs.fr');

Route::get('erd', function () {
    $viewName = 'components.db-schema';
    /** @var view-string $viewName */
    return view($viewName);
})->name('erd');

// Monitoring dashboards (local environment only for now)
if (app()->environment('local')) {
    Route::get('/pulse', function () {
        $viewName = 'pulse::dashboard';
        /** @var view-string $viewName */
        return view($viewName);
    })->name('pulse');
}

require __DIR__.'/auth.php';
