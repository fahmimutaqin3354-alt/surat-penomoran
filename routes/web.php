<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SuratMasukController;
use Illuminate\Support\Facades\Route;

// BENAR (Menampilkan halaman welcome/landing page)
Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Surat Masuk & Keluar
    Route::resource('surat_masuk', SuratMasukController::class);
    Route::resource('surat_keluar', SuratKeluarController::class);
    Route::get('/surat_keluar/{id}/preview', [SuratKeluarController::class, 'preview'])->name('surat_keluar.preview');
    Route::get('/surat_keluar/{id}/pdf', [SuratKeluarController::class, 'downloadPdf'])->name('surat_keluar.pdf');

    // CRUD Instansi
    Route::resource('instansi', InstansiController::class);

    // Arsip Surat
    Route::get('/arsip', [ArsipController::class, 'index'])->name('arsip.index');
    Route::get('/arsip/export', [ArsipController::class, 'ekspor'])->name('arsip.export');
    Route::get('/arsip/{id}', [ArsipController::class, 'show'])->name('arsip.show');
    Route::delete('/arsip/{id}', [ArsipController::class, 'destroy'])->name('arsip.destroy');

    // Laporan & Email
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/kirim-email', [LaporanController::class, 'sendEmail'])->name('laporan.send.email');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.export.excel');
    Route::get('/laporan/unduh-publik', [LaporanController::class, 'exportPdfPublic'])
        ->name('laporan.export.pdf.public')
        ->middleware('signed');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pengaturan Akun
    Route::get('/akun', [AccountController::class, 'edit'])->name('akun.index');
    Route::put('/akun', [AccountController::class, 'update'])->name('akun.update');
    Route::put('/akun/password', [AccountController::class, 'updatePassword'])->name('akun.password');

}); // Tutup grup middleware auth

require __DIR__.'/auth.php';