<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\ArsipController;

Route::middleware(['auth'])->group(function () {

    Route::get('/arsip', [ArsipController::class, 'index'])->name('arsip.index');
    Route::get('/arsip/create', [ArsipController::class, 'create'])->name('arsip.create');
    Route::post('/arsip', [ArsipController::class, 'store'])->name('arsip.store');
    Route::get('/arsip/{id}', [ArsipController::class, 'show'])->name('arsip.show');
    Route::get('/arsip/{id}/edit', [ArsipController::class, 'edit'])->name('arsip.edit');
    Route::put('/arsip/{id}', [ArsipController::class, 'update'])->name('arsip.update');
    Route::delete('/arsip/{id}', [ArsipController::class, 'destroy'])->name('arsip.destroy');

    // Ekspor arsip surat (dipakai tombol "Ekspor" di halaman)
    Route::get('/arsip/ekspor', [ArsipController::class, 'ekspor'])->name('arsip.ekspor');
});

require __DIR__.'/auth.php';
