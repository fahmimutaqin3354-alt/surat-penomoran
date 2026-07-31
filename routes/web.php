<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/laporan/kirim-email', [LaporanController::class, 'sendEmail'])
    ->name('laporan.send.email');

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

    // Arsip Surat
    Route::resource('arsip', ArsipController::class);

    // Pengaturan Akun
    Route::get('/akun', [AccountController::class, 'edit'])->name('akun.index');
    Route::put('/akun', [AccountController::class, 'update'])->name('akun.update');
    Route::put('/akun/password', [AccountController::class, 'updatePassword'])->name('akun.password');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.export.excel');
    Route::get('/laporan/unduh-publik', [LaporanController::class, 'exportPdfPublic'])
    ->name('laporan.export.pdf.public')
    ->middleware('signed');

});

require __DIR__.'/auth.php';