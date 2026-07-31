<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArsipController extends Controller
{
    /**
     * Daftar Arsip
     */
    public function index(Request $request)
    {
        $query = Arsip::query();

        // Pencarian
        if ($request->filled('q')) {

            $keyword = $request->q;

            $query->where(function ($q) use ($keyword) {

                $q->where('nomor_surat', 'like', "%{$keyword}%")
                    ->orWhere('perihal', 'like', "%{$keyword}%")
                    ->orWhere('pengirim_penerima', 'like', "%{$keyword}%");

            });

        }

        // Filter Jenis
        if ($request->filled('jenis')) {

            $query->where('jenis', $request->jenis);

        }

        // Filter Status
        if ($request->filled('status')) {

            $query->where('status', $request->status);

        }

        $arsipSurat = $query
            ->latest('tanggal_surat')
            ->paginate(10)
            ->withQueryString();

        return view('arsip.index', compact('arsipSurat'));
    }
    /**
     * Detail Arsip
     */
    public function show($id)
    {
        $surat = Arsip::findOrFail($id);

        return view('arsip.show', compact('surat'));
    }

    /**
     * Hapus Arsip
     */
    public function destroy($id)
    {
        $surat = Arsip::findOrFail($id);

        // Hapus file jika ada
        if ($surat->file_surat) {

            Storage::disk('public')->delete($surat->file_surat);

        }

        $surat->delete();

        return redirect()
            ->route('arsip.index')
            ->with('success', 'Arsip berhasil dihapus.');
    }
    /**
     * Ekspor Arsip ke CSV
     */
    public function ekspor(Request $request)
    {
        $query = Arsip::query();

        // Filter Jenis
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $data = $query->latest('tanggal_surat')->get();

        $filename = 'arsip-surat-' . now()->format('Ymd-His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($data) {

            $file = fopen('php://output', 'w');

            // Header CSV
            fputcsv($file, [
                'Nomor Surat',
                'Jenis',
                'Jenis Surat',
                'Perihal',
                'Pengirim / Penerima',
                'Tanggal Surat',
                'Status'
            ]);

            // Isi Data
            foreach ($data as $row) {

                fputcsv($file, [
                    $row->nomor_surat,
                    $row->jenis,
                    $row->jenis_surat,
                    $row->perihal,
                    $row->pengirim_penerima,
                    optional($row->tanggal_surat)->format('Y-m-d'),
                    $row->status,
                ]);

            }

            fclose($file);

        };

        return response()->stream($callback, 200, $headers);
    }
}
