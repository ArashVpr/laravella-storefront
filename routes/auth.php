<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\EmailVerifyController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialiteController;
use Laravel\Socialite\Facades\Socialite;


Route::fallback(function () {
    return 'Nadarim AMUUUUUUUUU';
});

// GUEST USER
Route::middleware(['guest'])->group(function () {

    Route::get('/signup', [SignupController::class, 'create'])->name('signup');
    Route::post('/signup', [SignupController::class, 'store'])->name('signup.store');
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/car/{car}', [CarController::class, 'show'])->name('car.show');
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPassword'])->name('password.forgot');
    Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword'])->name('password.email');
    Route::get('/reset-password', [PasswordResetController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');

    Route::get('/login/oauth/{provider}', [SocialiteController::class, 'redirectToProvider'])->name('login.oauth');
    Route::get('/callback/oauth/{provider}', [SocialiteController::class, 'handleCallback']);
});

// AUTHENTICATED USER
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // This route is used to show the notice to the user that he/she needs to verify his/her email
    Route::get('/email/verify', [EmailVerifyController::class, 'notice'])
        ->middleware('auth')
        ->name('verification.notice');
    // This route is used to verify the email of the user
    Route::get('/email/verify/{id}/{hash}', [EmailVerifyController::class, 'verify'])
        ->middleware(['auth', 'signed'])
        ->name('verification.verify');
    // This route is used to send the verification email to the user
    Route::post('/email/verification-notification', [EmailVerifyController::class, 'send'])
        ->middleware(['auth', 'throttle:6,1'])
        ->name('verification.send');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// AUTHENTICATED and VERIFIED USER
Route::middleware(['auth'])->group(function () {

    Route::middleware(['verified'])->group(function () {

        Route::get('/car/watchlist', [CarController::class, 'watchlist'])->name('car.watchlist');
        Route::resource('car', CarController::class)->except(['show']);
    });

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});
