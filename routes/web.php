<?php

use App\Http\Controllers\RecallController;
use App\Http\Controllers\InsertController;
use App\Http\Controllers\AuthController; // Tambahkan ini
use Illuminate\Support\Facades\Route;

// 1. Rute Authentication (Guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// 2. Rute Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 3. Rute Aplikasi (Harus Login & Role Keuangan/Admin)
// Kita bungkus dengan middleware 'auth'
Route::middleware(['auth'])->group(function () {
    
    Route::get('/', [RecallController::class, 'index'])->name('serasi.index');

    // Group Insert
    Route::prefix('insert')->name('serasi.insert.')->group(function () {
        Route::get('/manual', [InsertController::class, 'manual'])->name('manual');
        Route::get('/excel', [InsertController::class, 'excel'])->name('excel');
        Route::post('/store', [InsertController::class, 'store'])->name('store');
    });
});