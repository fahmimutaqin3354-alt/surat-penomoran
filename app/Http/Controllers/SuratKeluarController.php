<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    /**
     * Menampilkan semua data surat keluar.
     */
    public function index()
    {
        $surat = SuratKeluar::latest()->paginate(10);

        return view('surat_keluar.index', compact('surat'));
    }

    /**
     * Menampilkan form tambah surat.
     */
    public function create()
    {
        return view('surat_keluar.create');
    }

    /**
     * Menyimpan data surat baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat'   => 'required|unique:surat_keluars,nomor_surat',
            'tanggal_surat' => 'required|date',
            'tujuan'        => 'required|string|max:255',
            'perihal'       => 'required|string|max:255',
            'isi_surat'     => 'nullable|string',
            'status'        => 'required',
            'file_surat'    => 'nullable|mimes:pdf|max:2048',
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
            'nomor_surat'   => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'tujuan'        => $request->tujuan,
            'perihal'       => $request->perihal,
            'isi_surat'     => $request->isi_surat,
            'status'        => $request->status,
            'file_surat'    => $namaFile,
            'user_id'       => Auth::id(),
        ]);

        return redirect()
            ->route('surat_keluar.index')
            ->with('success', 'Surat keluar berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail surat.
     */
    public function show(string $id)
    {
        $surat = SuratKeluar::findOrFail($id);

        return view('surat_keluar.show', compact('surat'));
    }

    /**
     * Menampilkan form edit.
     */
    public function edit(string $id)
    {
        $surat = SuratKeluar::findOrFail($id);

        return view('surat_keluar.edit', compact('surat'));
    }

    /**
     * Mengupdate data surat.
     */
    public function update(Request $request, string $id)
    {
        $surat = SuratKeluar::findOrFail($id);

        $request->validate([
            'nomor_surat'   => 'required|unique:surat_keluars,nomor_surat,' . $surat->id,
            'tanggal_surat' => 'required|date',
            'tujuan'        => 'required|string|max:255',
            'perihal'       => 'required|string|max:255',
            'isi_surat'     => 'nullable|string',
            'status'        => 'required',
            'file_surat'    => 'nullable|mimes:pdf|max:2048',
        ]);

        $namaFile = $surat->file_surat;

        if ($request->hasFile('file_surat')) {

            if ($surat->file_surat && Storage::disk('public')->exists('surat_keluar/' . $surat->file_surat)) {

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
            'nomor_surat'   => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'tujuan'        => $request->tujuan,
            'perihal'       => $request->perihal,
            'isi_surat'     => $request->isi_surat,
            'status'        => $request->status,
            'file_surat'    => $namaFile,
        ]);

        return redirect()
            ->route('surat_keluar.index')
            ->with('success', 'Surat keluar berhasil diperbarui.');
    }

    /**
     * Menghapus data surat.
     */
    public function destroy(string $id)
    {
        $surat = SuratKeluar::findOrFail($id);

        if ($surat->file_surat && Storage::disk('public')->exists('surat_keluar/' . $surat->file_surat)) {

            Storage::disk('public')->delete('surat_keluar/' . $surat->file_surat);

        }

        $surat->delete();

        return redirect()
            ->route('surat_keluar.index')
            ->with('success', 'Surat keluar berhasil dihapus.');
    }
}
