<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SuratMasukController extends Controller
{
    // Menampilkan semua data
    public function index()
    {
        $suratMasuk = SuratMasuk::latest()->get();
        return view('surat_masuk.index', compact('suratMasuk'));
    }

    // Form tambah
    public function create()
    {
        return view('surat_masuk.create');
    }

    /**
     * Generate Nomor Surat Masuk Otomatis
     * Contoh:
     * 001/SM/PT-MDI/VII/2026
     */
    private function generateNomorSurat()
    {
        $suratTerakhir = SuratMasuk::latest('created_at')->first();

        if ($suratTerakhir) {
            $nomorTerakhir = (int) substr($suratTerakhir->nomor_surat, 0, 3);
            $nomorBaru = $nomorTerakhir + 1;
        } else {
            $nomorBaru = 1;
        }

        $nomorUrut = str_pad($nomorBaru, 3, '0', STR_PAD_LEFT);

        $bulanRomawi = [
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

        $bulan = $bulanRomawi[Carbon::now()->month];
        $tahun = Carbon::now()->year;

        return $nomorUrut . '/SM/PT-MDI/' . $bulan . '/' . $tahun;
    }

    // Simpan data
    public function store(Request $request)
    {
        $request->validate([
            'asal_surat'    => 'required',
            'perihal'       => 'required',
            'tanggal_surat' => 'required|date',
            'lampiran'      => 'nullable|mimes:pdf|max:2048',
        ]);

        $lampiran = null;

        if ($request->hasFile('lampiran')) {

            $folder = public_path('uploads');

            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }

            $lampiran = time().'_'.$request->lampiran->getClientOriginalName();

            $request->lampiran->move($folder, $lampiran);
        }

        SuratMasuk::create([
            'nomor_surat'   => $this->generateNomorSurat(),
            'asal_surat'    => $request->asal_surat,
            'perihal'       => $request->perihal,
            'tanggal_surat' => $request->tanggal_surat,
            'lampiran'      => $lampiran,
        ]);

        return redirect()->route('surat-masuk.index')
            ->with('success', 'Data berhasil disimpan.');
    }

    // Detail
    public function show(SuratMasuk $suratMasuk)
    {
        return view('surat_masuk.show', compact('suratMasuk'));
    }

    // Form edit
    public function edit(SuratMasuk $suratMasuk)
    {
        return view('surat_masuk.edit', compact('suratMasuk'));
    }

    // Update data
    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $request->validate([
            'asal_surat'    => 'required',
            'perihal'       => 'required',
            'tanggal_surat' => 'required|date',
            'lampiran'      => 'nullable|mimes:pdf|max:2048',
        ]);

        $lampiran = $suratMasuk->lampiran;

        if ($request->hasFile('lampiran')) {

            $folder = public_path('uploads');

            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }

            if ($lampiran && file_exists($folder.'/'.$lampiran)) {
                unlink($folder.'/'.$lampiran);
            }

            $lampiran = time().'_'.$request->lampiran->getClientOriginalName();

            $request->lampiran->move($folder, $lampiran);
        }

        $suratMasuk->update([
            'asal_surat'    => $request->asal_surat,
            'perihal'       => $request->perihal,
            'tanggal_surat' => $request->tanggal_surat,
            'lampiran'      => $lampiran,
        ]);

        return redirect()->route('surat-masuk.index')
            ->with('success', 'Data berhasil diupdate.');
    }

    // Hapus data
    public function destroy(SuratMasuk $suratMasuk)
    {
        $folder = public_path('uploads');

        if ($suratMasuk->lampiran && file_exists($folder.'/'.$suratMasuk->lampiran)) {
            unlink($folder.'/'.$suratMasuk->lampiran);
        }

        $suratMasuk->delete();

        return redirect()->route('surat-masuk.index')
            ->with('success', 'Data berhasil dihapus.');
    }
}
