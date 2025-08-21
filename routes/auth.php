<?php


use App\Http\Controllers\EmailVerifyController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\SocialiteController;
use Illuminate\Support\Facades\Route;

// GUEST users
Route::middleware(['guest'])->group(function () {
    Route::get('/signup', [SignupController::class, 'create'])->name('signup');
    Route::post('/signup', [SignupController::class, 'store'])->name('signup.store');
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPassword'])
        ->name('password.forgot');
    Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword'])
        ->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetPassword'])
        ->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])
        ->name('password.update');

    Route::get('/login/oauth/{provider}', [SocialiteController::class, 'redirectToProvider'])
        ->name('login.oauth');
    Route::get('/callback/oauth/{provider}', [SocialiteController::class, 'handleCallback']);
});

// AUTHENTICATED users
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/email/verify/{id}/{hash}', [EmailVerifyController::class, 'verify'])
        ->middleware(['auth', 'signed'])
        ->name('verification.verify');

    Route::get('/email/verify', [EmailVerifyController::class, 'notice'])
        ->middleware('auth')
        ->name('verification.notice');

    Route::post('/email/verification-notification', [EmailVerifyController::class, 'send'])
        ->middleware(['auth', 'throttle:6,1'])
        ->name('verification.send');
});
