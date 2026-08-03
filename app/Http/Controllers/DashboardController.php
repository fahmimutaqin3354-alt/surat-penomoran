<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung total statistik
        $totalSuratMasuk  = SuratMasuk::count();
        
        // Pengecekan aman untuk model SuratKeluar & User
        $totalSuratKeluar = class_exists(SuratKeluar::class) ? SuratKeluar::count() : 0;
        $totalArsip       = $totalSuratMasuk + $totalSuratKeluar;
        $totalPengguna    = class_exists(User::class) ? User::count() : 0;

        // 2. Ambil 5 surat masuk terbaru (urutkan berdasarkan id/created_at)
        $suratTerbaru = SuratMasuk::latest('id')->take(5)->get();

        // 3. Olah data statistik 6 bulan terakhir untuk grafik Chart.js
        $chartLabels = [];
        $chartData   = [];

        for ($i = 5; $i >= 0; $i--) {
            // Menggunakan subMonthsNoOverflow agar aman dieksekusi di akhir bulan (misal tgl 31)
            $date = now()->subMonthsNoOverflow($i);
            $chartLabels[] = $date->translatedFormat('M Y');

            // Hitung data per bulan dengan toleransi jika created_at bernilai NULL (fallback ke tanggal_surat jika ada)
            $count = SuratMasuk::where(function ($query) use ($date) {
                $query->whereYear('created_at', $date->year)
                      ->whereMonth('created_at', $date->month);
            })->orWhere(function ($query) use ($date) {
                $query->whereYear('tanggal_surat', $date->year)
                      ->whereMonth('tanggal_surat', $date->month);
            })->count();

            $chartData[] = $count;
        }

        // 4. Kirim data ke view dashboard (Pastikan nama view 'dashboard' sesuai dengan file blade Anda)
        return view('dashboard', compact(
            'totalSuratMasuk',
            'totalSuratKeluar',
            'totalArsip',
            'totalPengguna',
            'suratTerbaru',
            'chartLabels',
            'chartData'
        ));
    }
}