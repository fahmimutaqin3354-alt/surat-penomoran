<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;

// Halaman Utama / Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Group Route yang Membutuhkan Login (Auth)
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Resource Routes untuk Surat Masuk & Surat Keluar
    Route::resource('surat_masuk', SuratMasukController::class);
    Route::resource('surat_keluar', SuratKeluarController::class);

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';