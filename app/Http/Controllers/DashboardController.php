<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar; // Hapus/sesuaikan jika belum ada modelnya
use App\Models\User;        // Hapus/sesuaikan jika belum ada modelnya
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung total statistik
        $totalSuratMasuk  = SuratMasuk::count();
        
        // Menggunakan class_exists untuk mencegah error jika model lain belum dibuat
        $totalSuratKeluar = class_exists('App\Models\SuratKeluar') ? SuratKeluar::count() : 0;
        $totalArsip       = $totalSuratMasuk + $totalSuratKeluar;
        $totalPengguna    = class_exists('App\Models\User') ? User::count() : 0;

        // 2. Ambil 5 surat masuk terbaru
        $suratTerbaru = SuratMasuk::latest()->take(5)->get();

        // 3. Olah data statistik 6 bulan terakhir untuk grafik Chart.js
        $chartLabels = [];
        $chartData   = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $chartLabels[] = $date->translatedFormat('M Y'); // Contoh: Feb 2026

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
    }
}