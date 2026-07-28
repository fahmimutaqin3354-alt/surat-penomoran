<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArsipController extends Controller
{
    /**
     * Tampilkan daftar arsip surat (dengan search, filter, pagination).
     */
    public function index(Request $request)
    {
        $query = Arsip::query();

        // Pencarian nomor surat / judul / pengirim-penerima
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('no_surat', 'like', "%{$keyword}%")
                  ->orWhere('judul', 'like', "%{$keyword}%")
                  ->orWhere('pengirim_penerima', 'like', "%{$keyword}%");
            });
        }

        // Filter jenis surat (masuk / keluar)
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter tahun
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $arsipSurat = $query->latest('tanggal_surat')->paginate(5)->withQueryString();

        // Untuk dropdown filter
        $kategoriList = Arsip::select('kategori')->distinct()->pluck('kategori');
        $tahunList = Arsip::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');

        return view('arsip.index', compact('arsipSurat', 'kategoriList', 'tahunList'));
    }

    /**
     * Tampilkan form tambah arsip.
     */
    public function create()
    {
        return view('arsip.create');
    }

    /**
     * Simpan arsip baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_surat'          => 'required|string|unique:arsips,no_surat',
            'jenis'             => 'required|in:masuk,keluar',
            'judul'             => 'required|string|max:255',
            'pengirim_penerima' => 'required|string|max:255',
            'tanggal_surat'     => 'required|date',
            'kategori'          => 'nullable|string',
            'status'            => 'nullable|string',
            'lampiran'          => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $validated['tahun']     = date('Y', strtotime($validated['tanggal_surat']));
        $validated['status']    = $validated['status'] ?? 'Arsip';
        $validated['arsip_oleh'] = Auth::user()->name ?? 'Admin';

        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = $request->file('lampiran')->store('arsip', 'public');
        }

        Arsip::create($validated);

        return redirect()->route('arsip.index')->with('success', 'Arsip surat berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail satu arsip.
     */
    public function show($id)
    {
        $surat = Arsip::findOrFail($id);

        return view('arsip.show', compact('surat'));
    }

    /**
     * Tampilkan form edit arsip.
     */
    public function edit($id)
    {
        $surat = Arsip::findOrFail($id);

        return view('arsip.edit', compact('surat'));
    }

    /**
     * Perbarui data arsip.
     */
    public function update(Request $request, $id)
    {
        $surat = Arsip::findOrFail($id);

        $validated = $request->validate([
            'no_surat'          => 'required|string|unique:arsips,no_surat,' . $surat->id,
            'jenis'             => 'required|in:masuk,keluar',
            'judul'             => 'required|string|max:255',
            'pengirim_penerima' => 'required|string|max:255',
            'tanggal_surat'     => 'required|date',
            'kategori'          => 'nullable|string',
            'status'            => 'nullable|string',
            'lampiran'          => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $validated['tahun'] = date('Y', strtotime($validated['tanggal_surat']));

        if ($request->hasFile('lampiran')) {
            if ($surat->lampiran) {
                Storage::disk('public')->delete($surat->lampiran);
            }
            $validated['lampiran'] = $request->file('lampiran')->store('arsip', 'public');
        }

        $surat->update($validated);

        return redirect()->route('arsip.index')->with('success', 'Arsip surat berhasil diperbarui.');
    }

    /**
     * Hapus arsip.
     */
    public function destroy($id)
    {
        $surat = Arsip::findOrFail($id);

        if ($surat->lampiran) {
            Storage::disk('public')->delete($surat->lampiran);
        }

        $surat->delete();

        return redirect()->route('arsip.index')->with('success', 'Arsip surat berhasil dihapus.');
    }

    /**
     * Ekspor arsip surat ke Excel/CSV sesuai filter yang aktif.
     */
    public function ekspor(Request $request)
    {
        $query = Arsip::query();

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $data = $query->latest('tanggal_surat')->get();

        $filename = 'arsip-surat-' . now()->format('Ymd-His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No Surat', 'Jenis', 'Judul', 'Pengirim/Penerima', 'Tanggal Surat', 'Tahun', 'Status', 'Arsip Oleh']);

            foreach ($data as $row) {
                fputcsv($file, [
                    $row->no_surat,
                    $row->jenis,
                    $row->judul,
                    $row->pengirim_penerima,
                    $row->tanggal_surat,
                    $row->tahun,
                    $row->status,
                    $row->arsip_oleh,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}