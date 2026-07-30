<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\SuratMasuk;


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
     * Menampilkan form tambah surat
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
        $bulanRomawi = [
            1 => 'I',
            'II',
            'III',
            'IV',
            'V',
            'VI',
            'VII',
            'VIII',
            'IX',
            'X',
            'XI',
            'XII'
        ];

        $bulan = date('n');
        $tahun = date('Y');

        $jumlahSurat = SuratKeluar::whereYear('tanggal_surat', $tahun)
                        ->whereMonth('tanggal_surat', $bulan)
                        ->count();

        $nomorUrut = str_pad($jumlahSurat + 1, 3, '0', STR_PAD_LEFT);

        return $nomorUrut . '/PT-MDI/' . $bulanRomawi[$bulan] . '/' . $tahun;
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

        SuratKeluar::create([

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
 * Menampilkan form edit
 */
public function edit($id)
{
    $surat = SuratKeluar::findOrFail($id);

    return view('surat_keluar.edit', compact('surat'));
}

   /**
 * Mengupdate data surat
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

    return redirect()
        ->route('surat_keluar.index')
        ->with('success', 'Surat keluar berhasil diperbarui.');
}

    /**
 * Menghapus surat
 */
public function destroy($id)
{
    $surat = SuratKeluar::findOrFail($id);

    if (
        $surat->file_surat &&
        Storage::disk('public')->exists('surat_keluar/' . $surat->file_surat)
    ) {
        Storage::disk('public')->delete('surat_keluar/' . $surat->file_surat);
    }

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

public function downloadPdf($id)
{
    $surat = SuratKeluar::findOrFail($id);

    $pdf = Pdf::loadView('surat_keluar.pdf', compact('surat'));

    $namaFile = 'Surat-' . str_replace(
        ['/', '\\'],
        '-',
        $surat->nomor_surat
    ) . '.pdf';

    return $pdf->download($namaFile);
}
}
