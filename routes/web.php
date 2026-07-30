<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\LaporanController;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    // Route Dashboard yang sudah diperbaiki (Menghitung data secara dinamis)
    Route::get('/dashboard', function () {
        // 1. Hitung total data
        $totalSuratMasuk  = SuratMasuk::count();
        $totalSuratKeluar = class_exists(SuratKeluar::class) ? SuratKeluar::count() : 0;
        $totalArsip       = $totalSuratMasuk + $totalSuratKeluar;
        $totalPengguna    = class_exists(User::class) ? User::count() : 0;

        // 2. Ambil 5 data surat masuk terbaru untuk tabel dashboard
        $suratTerbaru = SuratMasuk::latest()->take(5)->get();

        // 3. Olah data grafik 6 bulan terakhir
        $chartLabels = [];
        $chartData   = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $chartLabels[] = $date->translatedFormat('M Y');

            $count = SuratMasuk::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $chartData[] = $count;
        }

        // 4. Kirim data ke view dashboard
        return view('dashboard', compact(
            'totalSuratMasuk',
            'totalSuratKeluar',
            'totalArsip',
            'totalPengguna',
            'suratTerbaru',
            'chartLabels',
            'chartData'
        ));
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

});

require __DIR__.'/auth.php';