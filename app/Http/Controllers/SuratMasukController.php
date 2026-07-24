<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{
    /**
     * Menampilkan daftar surat masuk
     */
    public function index()
    {
        $surat = SuratMasuk::latest()->paginate(10);

        return view('surat_masuk.index', compact('surat'));
    }

    /**
     * Form tambah surat
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
     * Simpan surat baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_agenda'   => 'required|unique:surat_masuks',
            'nomor_surat'    => 'required',
            'tanggal_surat'  => 'required|date',
            'tanggal_terima' => 'required|date',
            'pengirim'       => 'required',
            'perihal'        => 'required',
            'isi_ringkas'    => 'nullable',
            'status'         => 'required',
            'file_surat'     => 'nullable|mimes:pdf|max:2048',
        ]);

        $namaFile = null;

        if ($request->hasFile('file_surat')) {

            $namaFile = time().'_'.$request->file('file_surat')->getClientOriginalName();

            $request->file('file_surat')->storeAs(
                'surat_masuk',
                $namaFile,
                'public'
            );
        }

        SuratMasuk::create([
            'nomor_agenda'   => $request->nomor_agenda,
            'nomor_surat'    => $request->nomor_surat,
            'tanggal_surat'  => $request->tanggal_surat,
            'tanggal_terima' => $request->tanggal_terima,
            'pengirim'       => $request->pengirim,
            'perihal'        => $request->perihal,
            'isi_ringkas'    => $request->isi_ringkas,
            'status'         => $request->status,
            'file_surat'     => $namaFile,
            'user_id'        => Auth::id(),
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
     * Form edit
     */
    public function edit(string $id)
    {
        $surat = SuratMasuk::findOrFail($id);

        return view('surat_masuk.edit', compact('surat'));
    }

    /**
     * Update surat
     */
    public function update(Request $request, string $id)
    {
        $surat = SuratMasuk::findOrFail($id);

        $request->validate([
            'nomor_agenda'   => 'required|unique:surat_masuks,nomor_agenda,'.$surat->id,
            'nomor_surat'    => 'required',
            'tanggal_surat'  => 'required|date',
            'tanggal_terima' => 'required|date',
            'pengirim'       => 'required',
            'perihal'        => 'required',
            'isi_ringkas'    => 'nullable',
            'status'         => 'required',
            'file_surat'     => 'nullable|mimes:pdf|max:2048',
        ]);

        $namaFile = $surat->file_surat;

        if ($request->hasFile('file_surat')) {

            if ($surat->file_surat &&
                Storage::disk('public')->exists('surat_masuk/'.$surat->file_surat)) {

                Storage::disk('public')->delete('surat_masuk/'.$surat->file_surat);

            }

            $namaFile = time().'_'.$request->file('file_surat')->getClientOriginalName();

            $request->file('file_surat')->storeAs(
                'surat_masuk',
                $namaFile,
                'public'
            );
        }

        $surat->update([
            'nomor_agenda'   => $request->nomor_agenda,
            'nomor_surat'    => $request->nomor_surat,
            'tanggal_surat'  => $request->tanggal_surat,
            'tanggal_terima' => $request->tanggal_terima,
            'pengirim'       => $request->pengirim,
            'perihal'        => $request->perihal,
            'isi_ringkas'    => $request->isi_ringkas,
            'status'         => $request->status,
            'file_surat'     => $namaFile,
        ]);

        return redirect()
            ->route('surat_masuk.index')
            ->with('success', 'Surat masuk berhasil diperbarui.');
    }

    /**
     * Hapus surat
     */
    public function destroy(string $id)
    {
        $surat = SuratMasuk::findOrFail($id);

        if ($surat->file_surat &&
            Storage::disk('public')->exists('surat_masuk/'.$surat->file_surat)) {

            Storage::disk('public')->delete('surat_masuk/'.$surat->file_surat);

        }

        $surat->delete();

        return redirect()
            ->route('surat_masuk.index')
            ->with('success', 'Surat masuk berhasil dihapus.');
    }
}
