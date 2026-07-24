<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SuratMasukController;

Route::resource('surat_masuk', SuratMasukController::class);

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::resource('surat_keluar', SuratKeluarController::class);

});

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

require __DIR__.'/auth.php';
