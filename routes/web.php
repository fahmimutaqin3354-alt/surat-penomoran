<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArsipController;


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



Route::middleware(['auth'])->prefix('pengaturan')->name('pengaturan.')->group(function () {

    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Aktifkan / nonaktifkan user (tombol toggle status di dropdown aksi)
    Route::patch('/users/{id}/toggle', [UserController::class, 'toggle'])->name('users.toggle');
});





});

require __DIR__.'/auth.php';
