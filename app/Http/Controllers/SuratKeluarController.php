<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SuratKeluarController extends Controller
{
    // Menampilkan semua data
    public function index()
    {
        $suratKeluar = SuratKeluar::latest()->get();
        return view('surat_keluar.index', compact('suratKeluar'));
    }

    // Form tambah
    public function create()
    {
        return view('surat_keluar.create');
    }


    private function generateNomorSurat()
{
   $suratTerakhir = SuratKeluar::latest('created_at')->first();

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

    return $nomorUrut . '/SK/PT-MDI/' . $bulan . '/' . $tahun;
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

        $lampiran = time().'_'.$request->lampiran->getClientOriginalName();

        $request->lampiran->move(public_path('uploads'), $lampiran);

    }

    SuratKeluar::create([
        'nomor_surat'   => $this->generateNomorSurat(),
        'asal_surat'    => $request->asal_surat,
        'perihal'       => $request->perihal,
        'tanggal_surat' => $request->tanggal_surat,
        'lampiran'      => $lampiran,
    ]);

    return redirect()->route('surat-keluar.index')
        ->with('success','Data berhasil disimpan.');
}

    // Detail
    public function show(SuratKeluar $suratKeluar)
    {
        return view('surat_keluar.show', compact('suratKeluar'));
    }

    // Form edit
    public function edit(SuratKeluar $suratKeluar)
    {
        return view('surat_keluar.edit', compact('suratKeluar'));
    }

    // Update data
    public function update(Request $request, SuratKeluar $suratKeluar)
    {
        $request->validate([
    'asal_surat'    => 'required',
    'perihal'       => 'required',
    'tanggal_surat' => 'required|date',
    'lampiran'      => 'nullable|mimes:pdf|max:2048',
]);

        $lampiran = $suratKeluar->lampiran;

        if ($request->hasFile('lampiran')) {

            if ($lampiran && file_exists(public_path('uploads/'.$lampiran))) {
                unlink(public_path('uploads/'.$lampiran));
            }

            $lampiran = time().'_'.$request->lampiran->getClientOriginalName();
            $request->lampiran->move(public_path('uploads'), $lampiran);
        }

        $suratKeluar->update([
            'asal_surat'    => $request->asal_surat,
            'perihal'       => $request->perihal,
            'tanggal_surat' => $request->tanggal_surat,
            'lampiran'      => $lampiran,
        ]);

        return redirect()->route('surat-keluar.index')
            ->with('success','Data berhasil diupdate.');
    }

    // Hapus data
    public function destroy(SuratKeluar $suratKeluar)
{
    if ($suratKeluar->lampiran && file_exists(public_path('uploads/'.$suratKeluar->lampiran))) {
        unlink(public_path('uploads/'.$suratKeluar->lampiran));
    }

    $suratKeluar->delete();

    return redirect()->route('surat-keluar.index')
        ->with('success', 'Data berhasil dihapus.');
}
}
