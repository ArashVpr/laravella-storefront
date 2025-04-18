<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CarController;


Route::get('/', function () {
    return view('index');
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

Route::fallback(function () {
    // return view('welcome');
    return 'Nadarim AMUUUUUUUUU';
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/signup', [SignupController::class, 'create'])->name('signup');
Route::get('/login', [SignupController::class, 'login'])->name('login');

Route::get('/car/search', [CarController::class, 'search'])->name('car.search');
Route::resource('car', CarController::class);

// sequence of auth event
// validate
// authorize
// update 
// persist
// redirect