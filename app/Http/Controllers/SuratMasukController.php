<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{
    /**
     * Menampilkan daftar surat masuk
     */
    public function index(Request $request)
    {
        $query = SuratMasuk::query();

        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('nomor_agenda', 'like', '%' . $request->search . '%')
                    ->orWhere('nomor_surat', 'like', '%' . $request->search . '%')
                    ->orWhere('asal_surat', 'like', '%' . $request->search . '%')
                    ->orWhere('perihal', 'like', '%' . $request->search . '%');

            });

        }

        $surat = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('surat_masuk.index', compact('surat'));
    }

    /**
     * Form tambah surat masuk
     */
    public function create()
    {
        $last = SuratMasuk::latest()->first();

        if ($last) {

            $angka = (int) substr($last->nomor_agenda, 4) + 1;

        } else {

            $angka = 1;

        }

        $nomorAgenda = 'AGD-' . str_pad($angka, 4, '0', STR_PAD_LEFT);

        return view('surat_masuk.create', compact('nomorAgenda'));
    }
/**
 * Simpan surat masuk
 */
public function store(Request $request)
{
    $request->validate([
        'nomor_agenda'   => 'required|unique:surat_masuks',
        'nomor_surat'    => 'required|string|max:255',
        'tanggal_surat'  => 'required|date',
        'tanggal_terima' => 'required|date',
        'asal_surat'     => 'required|string|max:255',
        'jenis_surat'    => 'required|string|max:255',
        'perihal'        => 'required|string|max:255',
        'isi_ringkas'    => 'nullable|string',
        'lampiran'       => 'nullable|string|max:255',
        'keterangan'     => 'nullable|string',
        'status'         => 'required|in:Baru,Diproses,Selesai',
        'file_surat'     => 'nullable|mimes:pdf|max:2048',
    ]);

    $namaFile = null;

    if ($request->hasFile('file_surat')) {

        $namaFile = time() . '_' .
            $request->file('file_surat')->getClientOriginalName();

        $request->file('file_surat')->storeAs(
            'surat_masuk',
            $namaFile,
            'public'
        );
    }

    // ==========================
    // Simpan Surat Masuk
    // ==========================

    $surat = SuratMasuk::create([

        'nomor_agenda'   => $request->nomor_agenda,

        'nomor_surat'    => $request->nomor_surat,

        'tanggal_surat'  => $request->tanggal_surat,

        'tanggal_terima' => $request->tanggal_terima,

        'asal_surat'     => $request->asal_surat,

        'jenis_surat'    => $request->jenis_surat,

        'perihal'        => $request->perihal,

        'isi_ringkas'    => $request->isi_ringkas,

        'lampiran'       => $request->lampiran,

        'keterangan'     => $request->keterangan,

        'status'         => $request->status,

        'file_surat'     => $namaFile,

        'user_id'        => Auth::id(),

    ]);

    // ==========================
    // Simpan Otomatis ke Arsip
    // ==========================

    Arsip::create([

        'surat_masuk_id' => $surat->id,

        'surat_keluar_id' => null,

        'nomor_surat' => $surat->nomor_surat,

        'jenis' => 'Surat Masuk',

        'jenis_surat' => $surat->jenis_surat,

        'perihal' => $surat->perihal,

        'pengirim_penerima' => $surat->asal_surat,

        'tanggal_surat' => $surat->tanggal_surat,

        'lampiran' => $surat->lampiran,

        'file_surat' => $surat->file_surat,

        'status' => $surat->status,

        'user_id' => $surat->user_id,

    ]);

    return redirect()
        ->route('surat_masuk.index')
        ->with('success', 'Surat masuk berhasil ditambahkan.');
}
/**
 * Detail surat
 */
public function show(string $id)
{
    $surat = SuratMasuk::findOrFail($id);

    return view('surat_masuk.show', compact('surat'));
}

/**
 * Form edit surat
 */
public function edit(string $id)
{
    $surat = SuratMasuk::findOrFail($id);

    return view('surat_masuk.edit', compact('surat'));
}

/**
 * Update surat masuk
 */
public function update(Request $request, string $id)
{
    $surat = SuratMasuk::findOrFail($id);

    $request->validate([
        'nomor_agenda'   => 'required|unique:surat_masuks,nomor_agenda,' . $surat->id,
        'nomor_surat'    => 'required|string|max:255',
        'tanggal_surat'  => 'required|date',
        'tanggal_terima' => 'required|date',
        'asal_surat'     => 'required|string|max:255',
        'jenis_surat'    => 'required|string|max:255',
        'perihal'        => 'required|string|max:255',
        'isi_ringkas'    => 'nullable|string',
        'lampiran'       => 'nullable|string|max:255',
        'keterangan'     => 'nullable|string',
        'status'         => 'required|in:Baru,Diproses,Selesai',
        'file_surat'     => 'nullable|mimes:pdf|max:2048',
    ]);

    $namaFile = $surat->file_surat;

    if ($request->hasFile('file_surat')) {

        if (
            $surat->file_surat &&
            Storage::disk('public')->exists('surat_masuk/' . $surat->file_surat)
        ) {
            Storage::disk('public')->delete('surat_masuk/' . $surat->file_surat);
        }

        $namaFile = time() . '_' .
            $request->file('file_surat')->getClientOriginalName();

        $request->file('file_surat')->storeAs(
            'surat_masuk',
            $namaFile,
            'public'
        );
    }

    // Update Surat Masuk
    $surat->update([

        'nomor_agenda'   => $request->nomor_agenda,

        'nomor_surat'    => $request->nomor_surat,

        'tanggal_surat'  => $request->tanggal_surat,

        'tanggal_terima' => $request->tanggal_terima,

        'asal_surat'     => $request->asal_surat,

        'jenis_surat'    => $request->jenis_surat,

        'perihal'        => $request->perihal,

        'isi_ringkas'    => $request->isi_ringkas,

        'lampiran'       => $request->lampiran,

        'keterangan'     => $request->keterangan,

        'status'         => $request->status,

        'file_surat'     => $namaFile,

    ]);

    // ===============================
    // Update Arsip Otomatis
    // ===============================

    Arsip::where('surat_masuk_id', $surat->id)
        ->update([

            'nomor_surat' => $surat->nomor_surat,

            'jenis' => 'Surat Masuk',

            'jenis_surat' => $surat->jenis_surat,

            'perihal' => $surat->perihal,

            'pengirim_penerima' => $surat->asal_surat,

            'tanggal_surat' => $surat->tanggal_surat,

            'lampiran' => $surat->lampiran,

            'file_surat' => $surat->file_surat,

            'status' => $surat->status,

            'user_id' => $surat->user_id,

        ]);

    return redirect()
        ->route('surat_masuk.index')
        ->with('success', 'Surat masuk berhasil diperbarui.');
}
/**
 * Hapus surat masuk
 */
public function destroy(string $id)
{
    $surat = SuratMasuk::findOrFail($id);

    // Hapus file PDF jika ada
    if (
        $surat->file_surat &&
        Storage::disk('public')->exists('surat_masuk/' . $surat->file_surat)
    ) {
        Storage::disk('public')->delete('surat_masuk/' . $surat->file_surat);
    }

    // ==================================
    // Hapus Arsip Otomatis
    // ==================================

    Arsip::where('surat_masuk_id', $surat->id)->delete();

    // ==================================
    // Hapus Surat Masuk
    // ==================================

    $surat->delete();

    return redirect()
        ->route('surat_masuk.index')
        ->with('success', 'Surat masuk berhasil dihapus.');
}
}
