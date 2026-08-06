<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Instansi;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    /**
     * Menampilkan daftar surat keluar
     */
    public function index(Request $request)
    {
        $query = SuratKeluar::with('instansi')->latest();

        // Fitur Pencarian berdasarkan nomor surat, perihal, tujuan, atau nama instansi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%")
                  ->orWhere('tujuan', 'like', "%{$search}%")
                  ->orWhereHas('instansi', function ($i) use ($search) {
                      $i->where('nama_instansi', 'like', "%{$search}%");
                  });
            });
        }

        $surat = $query->get();

        return view('surat_keluar.index', compact('surat'));
    }

    /**
     * Menampilkan form tambah surat keluar
     */
    public function create(Request $request)
    {
        $suratMasuk = null;

        if ($request->filled('surat_masuk')) {
            $suratMasuk = SuratMasuk::find($request->surat_masuk);
        }

        $instansi = Instansi::all();

        return view('surat_keluar.create', compact('suratMasuk', 'instansi'));
    }

    /**
     * Menyimpan surat keluar
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'instansi_id'           => 'required|exists:instansis,id',
            'tanggal_surat'         => 'required|date',
            'jenis_surat'           => 'required|string|max:100',
            'tujuan'                => 'nullable|string|max:255',
            'perihal'               => 'required|string|max:255',
            'isi_surat'             => 'required|string',
            'lampiran'              => 'nullable|string|max:255',
            'penandatangan'         => 'required|string|max:255',
            'jabatan_penandatangan' => 'required|string|max:255',
            'status'                => 'required|in:Draft,Dikirim,Selesai',
            'file_surat'            => 'nullable|mimes:pdf|max:2048',
            'surat_masuk_id'        => 'nullable|exists:surat_masuks,id',
        ]);

        $namaFile = null;

        if ($request->hasFile('file_surat')) {
            $namaFile = time() . '_' . $request->file('file_surat')->getClientOriginalName();
            $request->file('file_surat')->storeAs('surat_keluar', $namaFile, 'public');
        }

        DB::transaction(function () use ($validated, $namaFile) {
            $surat = SuratKeluar::create(array_merge($validated, [
                'nomor_surat' => $this->generateNomorSurat(),
                'file_surat'  => $namaFile,
                'user_id'     => Auth::id(),
            ]));

            // Ambil nama instansi untuk arsip
            $namaInstansi = $surat->instansi ? $surat->instansi->nama_instansi : $surat->tujuan;

            // Simpan Otomatis ke Arsip
            Arsip::create([
                'surat_keluar_id'   => $surat->id,
                'surat_masuk_id'    => $surat->surat_masuk_id,
                'nomor_surat'       => $surat->nomor_surat,
                'jenis'             => 'Surat Keluar',
                'jenis_surat'       => $surat->jenis_surat,
                'perihal'           => $surat->perihal,
                'pengirim_penerima' => $namaInstansi,
                'tanggal_surat'     => $surat->tanggal_surat,
                'lampiran'          => $surat->lampiran,
                'file_surat'        => $surat->file_surat,
                'status'            => $surat->status,
                'user_id'           => $surat->user_id,
            ]);
        });

        return redirect()
            ->route('surat_keluar.index')
            ->with('success', 'Surat keluar berhasil dibuat.');
    }

    /**
     * Menampilkan detail surat
     */
    public function show(SuratKeluar $suratKeluar)
    {
        $suratKeluar->load('instansi');

        return view('surat_keluar.show', ['surat' => $suratKeluar]);
    }

    /**
     * Menampilkan form edit surat
     */
    public function edit(SuratKeluar $suratKeluar)
    {
        $instansi = Instansi::all();

        return view('surat_keluar.edit', ['surat' => $suratKeluar, 'instansi' => $instansi]);
    }

    /**
     * Mengupdate data surat keluar
     */
    public function update(Request $request, SuratKeluar $suratKeluar)
    {
        $validated = $request->validate([
            'instansi_id'           => 'required|exists:instansis,id',
            'tanggal_surat'         => 'required|date',
            'jenis_surat'           => 'required|string|max:100',
            'tujuan'                => 'nullable|string|max:255',
            'perihal'               => 'required|string|max:255',
            'isi_surat'             => 'required|string',
            'lampiran'              => 'nullable|string|max:255',
            'penandatangan'         => 'required|string|max:255',
            'jabatan_penandatangan' => 'required|string|max:255',
            'status'                => 'required|in:Draft,Dikirim,Selesai',
            'file_surat'            => 'nullable|mimes:pdf|max:2048',
        ]);

        $namaFile = $suratKeluar->file_surat;

        if ($request->hasFile('file_surat')) {
            if ($suratKeluar->file_surat && Storage::disk('public')->exists('surat_keluar/' . $suratKeluar->file_surat)) {
                Storage::disk('public')->delete('surat_keluar/' . $suratKeluar->file_surat);
            }

            $namaFile = time() . '_' . $request->file('file_surat')->getClientOriginalName();
            $request->file('file_surat')->storeAs('surat_keluar', $namaFile, 'public');
        }

        DB::transaction(function () use ($validated, $suratKeluar, $namaFile) {
            $suratKeluar->update(array_merge($validated, [
                'file_surat' => $namaFile,
            ]));

            $namaInstansi = $suratKeluar->instansi ? $suratKeluar->instansi->nama_instansi : $suratKeluar->tujuan;

            Arsip::where('surat_keluar_id', $suratKeluar->id)->update([
                'nomor_surat'       => $suratKeluar->nomor_surat,
                'jenis'             => 'Surat Keluar',
                'jenis_surat'       => $suratKeluar->jenis_surat,
                'perihal'           => $suratKeluar->perihal,
                'pengirim_penerima' => $namaInstansi,
                'tanggal_surat'     => $suratKeluar->tanggal_surat,
                'lampiran'          => $suratKeluar->lampiran,
                'file_surat'        => $suratKeluar->file_surat,
                'status'            => $suratKeluar->status,
                'user_id'           => $suratKeluar->user_id,
            ]);
        });

        return redirect()
            ->route('surat_keluar.index')
            ->with('success', 'Surat keluar berhasil diperbarui.');
    }

    /**
     * Menghapus surat keluar beserta arsipnya
     */
    public function destroy(SuratKeluar $suratKeluar)
    {
        DB::transaction(function () use ($suratKeluar) {
            if ($suratKeluar->file_surat && Storage::disk('public')->exists('surat_keluar/' . $suratKeluar->file_surat)) {
                Storage::disk('public')->delete('surat_keluar/' . $suratKeluar->file_surat);
            }

            Arsip::where('surat_keluar_id', $suratKeluar->id)->delete();
            $suratKeluar->delete();
        });

        return redirect()
            ->route('surat_keluar.index')
            ->with('success', 'Surat keluar berhasil dihapus.');
    }

    /**
     * Preview Surat
     */
    public function preview(SuratKeluar $suratKeluar)
    {
        $suratKeluar->load('instansi');

        return view('surat_keluar.preview', ['surat' => $suratKeluar]);
    }

    /**
     * Download PDF
     */
    public function downloadPdf(SuratKeluar $suratKeluar)
    {
        // Jika PDF sudah pernah dibuat dan tersimpan
        if ($suratKeluar->file_surat && Storage::disk('public')->exists($suratKeluar->file_surat)) {
            return response()->download(
                storage_path('app/public/' . $suratKeluar->file_surat),
                basename($suratKeluar->file_surat)
            );
        }

        // Generate PDF baru jika belum ada
        $pdf = Pdf::loadView('surat_keluar.pdf', ['surat' => $suratKeluar]);

        if (!Storage::disk('public')->exists('pdf')) {
            Storage::disk('public')->makeDirectory('pdf');
        }

        $namaFile = str_replace('/', '-', $suratKeluar->nomor_surat) . '.pdf';
        $path = 'pdf/' . $namaFile;

        Storage::disk('public')->put($path, $pdf->output());

        $suratKeluar->update([
            'file_surat' => $path,
        ]);

        return response()->download(
            storage_path('app/public/' . $path),
            $namaFile
        );
    }

    /**
     * Generate Nomor Surat Otomatis
     * Format: 001/PT-MDI/VIII/2026
     */
    private function generateNomorSurat()
    {
        $bulan = (int) now()->month;
        $tahun = now()->year;

        $jumlah = SuratKeluar::whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->count() + 1;

        $nomor = sprintf('%03d', $jumlah);

        $romawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV',
            5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII',
            9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII',
        ];

        return $nomor . '/PT-MDI/' . ($romawi[$bulan] ?? 'I') . '/' . $tahun;
    }
}