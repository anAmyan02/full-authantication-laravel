<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

// User routes
Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');

    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');

    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

});

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'loginAction'])->name('admin.login.action');
    Route::get('register', [AdminAuthController::class, 'register'])->name('admin.register');
    Route::post('register', [AdminAuthController::class, 'registerSave'])->name('admin.register.save');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });
});

// User authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [UserController::class, 'userprofile'])->name('profile');
});

// password

// Password Reset Routes
Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');


// Admin Password Reset Routes
Route::get('admin/forgot-password', [AdminAuthController::class, 'showForgotPasswordForm'])->name('admin.password.request');
Route::post('admin/forgot-password', [AdminAuthController::class, 'sendResetLinkEmail'])->name('admin.password.email');
Route::get('admin/reset-password/{token}', [AdminAuthController::class, 'showResetPasswordForm'])->name('admin.password.reset');
Route::post('admin/reset-password', [AdminAuthController::class, 'resetPassword'])->name('admin.password.update');
