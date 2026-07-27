<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SuratMasukController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Surat Masuk
    Route::resource('surat_masuk', SuratMasukController::class);

    // Surat Keluar
    Route::resource('surat_keluar', SuratKeluarController::class);

    // Preview Surat Keluar
    Route::get('/surat_keluar/{id}/preview', [SuratKeluarController::class, 'preview'])
        ->name('surat_keluar.preview');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
