<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\Arsip;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    /**
     * Menampilkan daftar surat keluar
     */
    public function index()
    {
        $surat = SuratKeluar::latest()->paginate(10);

        return view('surat_keluar.index', compact('surat'));
    }

    /**
     * Menampilkan form tambah surat keluar
     */
    public function create(Request $request)
    {
        $suratMasuk = null;

        if ($request->filled('surat_masuk')) {
            $suratMasuk = SuratMasuk::findOrFail($request->surat_masuk);
        }

        return view('surat_keluar.create', compact('suratMasuk'));
    }

    /**
     * Generate Nomor Surat Otomatis
     * Format:
     * 001/PT-MDI/VII/2026
     */
    private function generateNomorSurat()
{
    $bulan = now()->month;
    $tahun = now()->year;

    // Hitung jumlah surat pada bulan dan tahun yang sama
    $jumlah = SuratKeluar::whereMonth('created_at', $bulan)
        ->whereYear('created_at', $tahun)
        ->count() + 1;

    // Jika masih di bawah 100 gunakan 2 digit,
    // jika sudah 100 atau lebih gunakan angka biasa (3 digit atau lebih)
    if ($jumlah < 100) {
        $nomor = str_pad($jumlah, 2, '0', STR_PAD_LEFT);
    } else {
        $nomor = $jumlah;
    }

    $romawi = [
        1 => 'I',
        2 => 'II',
        3 => 'III',
        4 => 'IV',
        5 => 'V',
        6 => 'VI',
        7 => 'VII',
        8 => 'VIII',
        9 => 'IX',
        10 => 'X',
        11 => 'XI',
        12 => 'XII',
    ];

    return $nomor . '/PT-MDI/' . $romawi[$bulan] . '/' . $tahun;
}
/**
 * Menyimpan surat keluar
 */
public function store(Request $request)
{
    $request->validate([
        'tanggal_surat' => 'required|date',
        'jenis_surat' => 'required|string|max:100',
        'tujuan' => 'required|string|max:255',
        'perihal' => 'required|string|max:255',
        'isi_surat' => 'required|string',
        'lampiran' => 'nullable|string|max:255',
        'penandatangan' => 'required|string|max:255',
        'jabatan_penandatangan' => 'required|string|max:255',
        'status' => 'required|in:Draft,Dikirim,Selesai',
        'file_surat' => 'nullable|mimes:pdf|max:2048',
    ]);

    $namaFile = null;

    if ($request->hasFile('file_surat')) {

        $namaFile = time() . '_' . $request->file('file_surat')->getClientOriginalName();

        $request->file('file_surat')->storeAs(
            'surat_keluar',
            $namaFile,
            'public'
        );
    }

    // Simpan Surat Keluar
    $surat = SuratKeluar::create([

        'nomor_surat' => $this->generateNomorSurat(),

        'tanggal_surat' => $request->tanggal_surat,

        'jenis_surat' => $request->jenis_surat,

        'tujuan' => $request->tujuan,

        'perihal' => $request->perihal,

        'isi_surat' => $request->isi_surat,

        'lampiran' => $request->lampiran,

        'penandatangan' => $request->penandatangan,

        'jabatan_penandatangan' => $request->jabatan_penandatangan,

        'status' => $request->status,

        'file_surat' => $namaFile,

        'surat_masuk_id' => $request->surat_masuk_id,

        'user_id' => Auth::id(),

    ]);

    // ============================
    // Simpan Otomatis ke Arsip
    // ============================

    Arsip::create([

        'surat_keluar_id' => $surat->id,

        'surat_masuk_id' => $surat->surat_masuk_id,

        'nomor_surat' => $surat->nomor_surat,

        'jenis' => 'Surat Keluar',

        'jenis_surat' => $surat->jenis_surat,

        'perihal' => $surat->perihal,

        'pengirim_penerima' => $surat->tujuan,

        'tanggal_surat' => $surat->tanggal_surat,

        'lampiran' => $surat->lampiran,

        'file_surat' => $surat->file_surat,

        'status' => $surat->status,

        'user_id' => $surat->user_id,

    ]);

    return redirect()
        ->route('surat_keluar.index')
        ->with('success', 'Surat keluar berhasil dibuat.');
}
/**
 * Menampilkan detail surat
 */
public function show($id)
{
    $surat = SuratKeluar::findOrFail($id);

    return view('surat_keluar.show', compact('surat'));
}

/**
 * Menampilkan form edit surat
 */
public function edit($id)
{
    $surat = SuratKeluar::findOrFail($id);

    return view('surat_keluar.edit', compact('surat'));
}

/**
 * Mengupdate data surat keluar
 */
public function update(Request $request, $id)
{
    $surat = SuratKeluar::findOrFail($id);

    $request->validate([
        'tanggal_surat' => 'required|date',
        'jenis_surat' => 'required|string|max:100',
        'tujuan' => 'required|string|max:255',
        'perihal' => 'required|string|max:255',
        'isi_surat' => 'required|string',
        'lampiran' => 'nullable|string|max:255',
        'penandatangan' => 'required|string|max:255',
        'jabatan_penandatangan' => 'required|string|max:255',
        'status' => 'required|in:Draft,Dikirim,Selesai',
        'file_surat' => 'nullable|mimes:pdf|max:2048',
    ]);

    $namaFile = $surat->file_surat;

    if ($request->hasFile('file_surat')) {

        if (
            $surat->file_surat &&
            Storage::disk('public')->exists('surat_keluar/' . $surat->file_surat)
        ) {
            Storage::disk('public')->delete('surat_keluar/' . $surat->file_surat);
        }

        $namaFile = time() . '_' . $request->file('file_surat')->getClientOriginalName();

        $request->file('file_surat')->storeAs(
            'surat_keluar',
            $namaFile,
            'public'
        );
    }

    $surat->update([

        'tanggal_surat' => $request->tanggal_surat,

        'jenis_surat' => $request->jenis_surat,

        'tujuan' => $request->tujuan,

        'perihal' => $request->perihal,

        'isi_surat' => $request->isi_surat,

        'lampiran' => $request->lampiran,

        'penandatangan' => $request->penandatangan,

        'jabatan_penandatangan' => $request->jabatan_penandatangan,

        'status' => $request->status,

        'file_surat' => $namaFile,

    ]);

    // ===============================
    // Update data arsip otomatis
    // ===============================

    Arsip::where('surat_keluar_id', $surat->id)
        ->update([

            'nomor_surat' => $surat->nomor_surat,

            'jenis' => 'Surat Keluar',

            'jenis_surat' => $surat->jenis_surat,

            'perihal' => $surat->perihal,

            'pengirim_penerima' => $surat->tujuan,

            'tanggal_surat' => $surat->tanggal_surat,

            'lampiran' => $surat->lampiran,

            'file_surat' => $surat->file_surat,

            'status' => $surat->status,

            'user_id' => $surat->user_id,

        ]);

    return redirect()
        ->route('surat_keluar.index')
        ->with('success', 'Surat keluar berhasil diperbarui.');
}
/**
 * Menghapus surat keluar beserta arsipnya
 */
public function destroy($id)
{
    $surat = SuratKeluar::findOrFail($id);

    // Hapus file PDF jika ada
    if (
        $surat->file_surat &&
        Storage::disk('public')->exists('surat_keluar/' . $surat->file_surat)
    ) {
        Storage::disk('public')->delete('surat_keluar/' . $surat->file_surat);
    }

    // Hapus data arsip yang terkait
    Arsip::where('surat_keluar_id', $surat->id)->delete();

    // Hapus surat keluar
    $surat->delete();

    return redirect()
        ->route('surat_keluar.index')
        ->with('success', 'Surat keluar berhasil dihapus.');
}

/**
 * Preview Surat
 */
public function preview($id)
{
    $surat = SuratKeluar::findOrFail($id);

    return view('surat_keluar.preview', compact('surat'));
}

/**
 * Download PDF
 */
public function downloadPdf($id)
{
    $surat = SuratKeluar::findOrFail($id);

    $pdf = Pdf::loadView('surat_keluar.pdf', compact('surat'));

    // Hindari karakter "/" pada nama file
    $namaFile = 'Surat-' . str_replace(
        ['/', '\\'],
        '-',
        $surat->nomor_surat
    ) . '.pdf';

    return $pdf->download($namaFile);
}
}
