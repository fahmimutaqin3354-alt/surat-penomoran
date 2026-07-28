<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\SuratKeluar;
use App\Exports\LaporanExport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        [$dari, $sampai] = $this->rentangTanggal($request);
        $ringkasan        = $this->hitungRingkasan($dari, $sampai);

        // ===================== TREN SURAT (LINE CHART) =====================
        $trenKeluar = SuratKeluar::whereBetween('tanggal_surat', [$dari, $sampai])
            ->selectRaw('DATE(tanggal_surat) as tanggal, COUNT(*) as jumlah')
            ->groupBy('tanggal')
            ->pluck('jumlah', 'tanggal');

        $trenMasuk = collect();
        if (file_exists(app_path('Models/SuratMasuk.php'))) {
            $trenMasuk = \App\Models\SuratMasuk::whereBetween('tanggal_surat', [$dari, $sampai])
                ->selectRaw('DATE(tanggal_surat) as tanggal, COUNT(*) as jumlah')
                ->groupBy('tanggal')
                ->pluck('jumlah', 'tanggal');
        }

        $labelTanggal = collect();
        $tanggalBerjalan = $dari->copy();
        while ($tanggalBerjalan->lte($sampai)) {
            $labelTanggal->push($tanggalBerjalan->format('Y-m-d'));
            $tanggalBerjalan->addDay();
        }

        $dataTrenMasuk  = $labelTanggal->map(fn ($tgl) => $trenMasuk->get($tgl, 0))->values();
        $dataTrenKeluar = $labelTanggal->map(fn ($tgl) => $trenKeluar->get($tgl, 0))->values();
        $labelTrenChart = $labelTanggal->map(fn ($tgl) => Carbon::parse($tgl)->translatedFormat('d M'))->values();

        return view('laporan.index', array_merge($ringkasan, [
            'labelTrenChart' => $labelTrenChart,
            'dataTrenMasuk'  => $dataTrenMasuk,
            'dataTrenKeluar' => $dataTrenKeluar,
            'updatedAt'      => now()->translatedFormat('d M Y H:i'),
        ]));
    }

    public function exportPdf(Request $request)
    {
        [$dari, $sampai] = $this->rentangTanggal($request);
        $ringkasan        = $this->hitungRingkasan($dari, $sampai);
        $daftarSurat       = $this->daftarSuratGabungan($dari, $sampai);

        $pdf = Pdf::loadView('laporan.pdf', [
            'ringkasan' => $ringkasan,
            'data'      => $daftarSurat,
            'periode'   => ['mulai' => $dari, 'akhir' => $sampai],
        ])->setPaper('a4', 'portrait');

        return $pdf->download('laporan-surat-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        [$dari, $sampai] = $this->rentangTanggal($request);
        $daftarSurat       = $this->daftarSuratGabungan($dari, $sampai);

        return Excel::download(
            new LaporanExport($daftarSurat),
            'laporan-surat-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    // ===================== HELPER: FILTER TANGGAL =====================
    // Sama seperti logic aslimu di index(), dipakai ulang oleh export.
    private function rentangTanggal(Request $request): array
    {
        $dari = $request->filled('dari')
            ? Carbon::parse($request->input('dari'))->startOfDay()
            : now()->startOfMonth();

        $sampai = $request->filled('sampai')
            ? Carbon::parse($request->input('sampai'))->endOfDay()
            : now()->endOfMonth();

        return [$dari, $sampai];
    }

    // ===================== HELPER: RINGKASAN ANGKA =====================
    // Persis logic aslimu di index(), dipisah supaya dipakai ulang oleh exportPdf().
    private function hitungRingkasan(Carbon $dari, Carbon $sampai): array
    {
        $suratKeluarQuery = SuratKeluar::whereBetween('tanggal_surat', [$dari, $sampai]);
        $suratKeluar = (clone $suratKeluarQuery)->count();

        $selesai     = (clone $suratKeluarQuery)->where('status', 'Selesai')->count();
        $dalamProses = (clone $suratKeluarQuery)->where('status', 'Dikirim')->count();
        $menunggu    = (clone $suratKeluarQuery)->where('status', 'Draft')->count();

        $suratMasuk = 0;
        if (file_exists(app_path('Models/SuratMasuk.php'))) {
            $suratMasuk = \App\Models\SuratMasuk::whereBetween('tanggal_surat', [$dari, $sampai])->count();
        }

        $arsip = Arsip::whereBetween('tanggal_surat', [$dari, $sampai])->count();

        $disposisi = 0;

        $totalSurat = $suratMasuk + $suratKeluar;

        return [
            'totalSurat'  => $totalSurat,
            'suratMasuk'  => $suratMasuk,
            'suratKeluar' => $suratKeluar,
            'arsip'       => $arsip,
            'disposisi'   => $disposisi,
            'selesai'     => $selesai,
            'dalamProses' => $dalamProses,
            'menunggu'    => $menunggu,
        ];
    }

    // ===================== HELPER: DAFTAR SURAT UNTUK EXPORT =====================
    // Gabungkan surat keluar (+ surat masuk kalau modelnya sudah ada) jadi
    // satu koleksi dengan struktur kolom yang sama, siap dipakai PDF & Excel.
    private function daftarSuratGabungan(Carbon $dari, Carbon $sampai)
    {
        $keluar = SuratKeluar::whereBetween('tanggal_surat', [$dari, $sampai])
            ->get()
            ->map(fn ($s) => [
                'nomor_surat' => $s->nomor_surat,
                'jenis'       => 'Surat Keluar',
                'keterangan'  => $s->perihal ?? $s->tujuan,
                'tanggal'     => $s->tanggal_surat,
                'status'      => $s->status,
            ]);

        $masuk = collect();
        if (file_exists(app_path('Models/SuratMasuk.php'))) {
            $masuk = \App\Models\SuratMasuk::whereBetween('tanggal_surat', [$dari, $sampai])
                ->get()
                ->map(fn ($s) => [
                    'nomor_surat' => $s->nomor_surat ?? '-',
                    'jenis'       => 'Surat Masuk',
                    'keterangan'  => $s->perihal ?? ($s->pengirim ?? '-'),
                    'tanggal'     => $s->tanggal_surat,
                    'status'      => $s->status ?? '-',
                ]);
        }

        return $keluar->concat($masuk)->sortBy('tanggal')->values();
    }
}