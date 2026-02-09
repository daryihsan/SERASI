<?php

use App\Http\Controllers\RecallController;
use App\Http\Controllers\InsertController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RecallController::class, 'index'])->name('serasi.index');

// Rute Insert Data
Route::prefix('insert')->name('serasi.insert.')->group(function () {
    Route::get('/manual', [InsertController::class, 'manual'])->name('manual');
    Route::get('/excel', [InsertController::class, 'excel'])->name('excel');

    Route::post('/store', [InsertController::class, 'store'])->name('store');
});