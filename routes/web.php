<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\RecycleBinController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstansiController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {



    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/laporan/kirim-email', [LaporanController::class, 'sendEmail'])
    ->name('laporan.send.email');

   Route::resource('instansi', InstansiController::class);

    // Surat Masuk
    Route::resource('surat_masuk', SuratMasukController::class);

    // Surat Keluar
    Route::resource('surat_keluar', SuratKeluarController::class);
     Route::post('/surat_keluar/{id}/kirim-email', [SuratKeluarController::class, 'sendEmail'])
    ->name('surat_keluar.send.email');
    Route::post('/surat_keluar/{id}/send-whatsapp', [SuratKeluarController::class, 'sendWhatsapp'])
    ->name('surat_keluar.send.whatsapp');

    // Preview Surat Keluar
    Route::get('/surat_keluar/{id}/preview', [SuratKeluarController::class, 'preview'])
        ->name('surat_keluar.preview');
    Route::get( '/surat_keluar/{id}/pdf', [SuratKeluarController::class, 'downloadPublic']
)->name('surat_keluar.pdf');

Route::get('/surat_keluar/{id}/unduh-publik', [SuratKeluarController::class, 'downloadPublic'])
    ->name('surat_keluar.download.public')
    ->middleware('signed');
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

  // Arsip Surat
Route::get('/arsip', [ArsipController::class, 'index'])->name('arsip.index');
Route::get('/arsip/{id}', [ArsipController::class, 'show'])->name('arsip.show');
Route::delete('/arsip/{id}', [ArsipController::class, 'destroy'])->name('arsip.destroy');
Route::get('/arsip/export', [ArsipController::class, 'ekspor'])->name('arsip.export');

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

     // RecycleBin
    Route::get('/recycle-bin', [RecycleBinController::class, 'index'])->name('recycle-bin.index');

    Route::post('/recycle-bin/surat-keluar/{id}/restore', [RecycleBinController::class, 'restoreSuratKeluar'])->name('recycle-bin.restore.keluar');
    Route::post('/recycle-bin/surat-masuk/{id}/restore', [RecycleBinController::class, 'restoreSuratMasuk'])->name('recycle-bin.restore.masuk');
    Route::post('/recycle-bin/arsip/{id}/restore', [RecycleBinController::class, 'restoreArsip'])->name('recycle-bin.restore.arsip');

    Route::delete('/recycle-bin/surat-keluar/{id}/force', [RecycleBinController::class, 'forceDeleteSuratKeluar'])->name('recycle-bin.force.keluar');
    Route::delete('/recycle-bin/surat-masuk/{id}/force', [RecycleBinController::class, 'forceDeleteSuratMasuk'])->name('recycle-bin.force.masuk');
    Route::delete('/recycle-bin/arsip/{id}/force', [RecycleBinController::class, 'forceDeleteArsip'])->name('recycle-bin.force.arsip');





});

require __DIR__.'/auth.php';
