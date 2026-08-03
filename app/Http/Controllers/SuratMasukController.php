<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Instansi;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_agenda', 'like', "%{$search}%")
                  ->orWhere('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('asal_surat', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%")
                  // Mencari berdasarkan nama instansi di relasi
                  ->orWhereHas('instansi', function ($qInstansi) use ($search) {
                      $qInstansi->where('nama_instansi', 'like', "%{$search}%");
                  });
            });
        }

        $surat = $query
            ->with('instansi') // Eager load relasi instansi
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

        if ($last && $last->nomor_agenda) {
            // Ambil angka dari format AGD-XXXX
            $angka = (int) substr($last->nomor_agenda, 4) + 1;
        } else {
            $angka = 1;
        }

        $nomorAgenda = 'AGD-' . str_pad($angka, 4, '0', STR_PAD_LEFT);
        
        // Ambil data instansi untuk dropdown
        $instansis = Instansi::orderBy('nama_instansi', 'asc')->get();

        return view('surat_masuk.create', compact('nomorAgenda', 'instansis'));
    }

    /**
     * Simpan surat masuk
     */
    public function store(Request $request)
    {
        $request->validate([
            'instansi_id'    => 'required|exists:instansis,id',
            'nomor_agenda'   => 'required|unique:surat_masuks,nomor_agenda',
            'nomor_surat'    => 'required|string|max:255',
            'tanggal_surat'  => 'required|date',
            'tanggal_terima' => 'required|date',
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
            $namaFile = time() . '_' . $request->file('file_surat')->getClientOriginalName();
            $request->file('file_surat')->storeAs('surat_masuk', $namaFile, 'public');
        }

        $instansi = Instansi::findOrFail($request->instansi_id);

        // Menggunakan Database Transaction demi keamanan data
        DB::transaction(function () use ($request, $instansi, $namaFile) {
            
            // 1. Simpan Surat Masuk
            $surat = SuratMasuk::create([
                'instansi_id'    => $request->instansi_id,
                'nomor_agenda'   => $request->nomor_agenda,
                'nomor_surat'    => $request->nomor_surat,
                'tanggal_surat'  => $request->tanggal_surat,
                'tanggal_terima' => $request->tanggal_terima,
                'asal_surat'     => $instansi->nama_instansi,
                'jenis_surat'    => $request->jenis_surat,
                'perihal'        => $request->perihal,
                'isi_ringkas'    => $request->isi_ringkas,
                'lampiran'       => $request->lampiran,
                'keterangan'     => $request->keterangan,
                'status'         => $request->status,
                'file_surat'     => $namaFile,
                'user_id'        => Auth::id(),
            ]);

            // 2. Simpan Otomatis ke Arsip
            Arsip::create([
                'surat_masuk_id'    => $surat->id,
                'surat_keluar_id'   => null,
                'nomor_surat'       => $surat->nomor_surat,
                'jenis'             => 'Surat Masuk',
                'jenis_surat'       => $surat->jenis_surat,
                'perihal'           => $surat->perihal,
                'pengirim_penerima' => $surat->asal_surat,
                'tanggal_surat'     => $surat->tanggal_surat,
                'lampiran'          => $surat->lampiran,
                'file_surat'        => $surat->file_surat,
                'status'            => $surat->status,
                'user_id'           => $surat->user_id,
            ]);
        });

        return redirect()
            ->route('surat_masuk.index')
            ->with('success', 'Surat masuk berhasil ditambahkan.');
    }

    /**
     * Detail surat
     */
    public function show(SuratMasuk $surat_masuk)
    {
        // Menggunakan Route Model Binding
        $surat = $surat_masuk->load('instansi');

        return view('surat_masuk.show', compact('surat'));
    }

    /**
     * Form edit surat
     */
    public function edit(SuratMasuk $surat_masuk)
    {
        $surat = $surat_masuk;
        $instansis = Instansi::orderBy('nama_instansi', 'asc')->get();

        return view('surat_masuk.edit', compact('surat', 'instansis'));
    }

    /**
     * Update surat masuk
     */
    public function update(Request $request, SuratMasuk $surat_masuk)
    {
        $surat = $surat_masuk;

        $request->validate([
            'instansi_id'    => 'required|exists:instansis,id',
            'nomor_agenda'   => 'required|unique:surat_masuks,nomor_agenda,' . $surat->id,
            'nomor_surat'    => 'required|string|max:255',
            'tanggal_surat'  => 'required|date',
            'tanggal_terima' => 'required|date',
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
            // Hapus file lama jika ada
            if ($surat->file_surat && Storage::disk('public')->exists('surat_masuk/' . $surat->file_surat)) {
                Storage::disk('public')->delete('surat_masuk/' . $surat->file_surat);
            }

            $namaFile = time() . '_' . $request->file('file_surat')->getClientOriginalName();
            $request->file('file_surat')->storeAs('surat_masuk', $namaFile, 'public');
        }

        $instansi = Instansi::findOrFail($request->instansi_id);

        DB::transaction(function () use ($surat, $request, $instansi, $namaFile) {
            // 1. Update Surat Masuk
            $surat->update([
                'instansi_id'    => $request->instansi_id,
                'nomor_agenda'   => $request->nomor_agenda,
                'nomor_surat'    => $request->nomor_surat,
                'tanggal_surat'  => $request->tanggal_surat,
                'tanggal_terima' => $request->tanggal_terima,
                'asal_surat'     => $instansi->nama_instansi,
                'jenis_surat'    => $request->jenis_surat,
                'perihal'        => $request->perihal,
                'isi_ringkas'    => $request->isi_ringkas,
                'lampiran'       => $request->lampiran,
                'keterangan'     => $request->keterangan,
                'status'         => $request->status,
                'file_surat'     => $namaFile,
            ]);

            // 2. Update Arsip Otomatis (Menggunakan updateOrCreate agar lebih aman jika arsip sempat terhapus)
            Arsip::updateOrCreate(
                ['surat_masuk_id' => $surat->id],
                [
                    'nomor_surat'       => $surat->nomor_surat,
                    'jenis'             => 'Surat Masuk',
                    'jenis_surat'       => $surat->jenis_surat,
                    'perihal'           => $surat->perihal,
                    'pengirim_penerima' => $surat->asal_surat,
                    'tanggal_surat'     => $surat->tanggal_surat,
                    'lampiran'          => $surat->lampiran,
                    'file_surat'        => $surat->file_surat,
                    'status'            => $surat->status,
                    'user_id'           => $surat->user_id,
                ]
            );
        });

        return redirect()
            ->route('surat_masuk.index')
            ->with('success', 'Surat masuk berhasil diperbarui.');
    }

    /**
     * Hapus surat masuk
     */
    public function destroy(SuratMasuk $surat_masuk)
    {
        $surat = $surat_masuk;

        DB::transaction(function () use ($surat) {
            // Hapus file PDF fisik jika ada
            if ($surat->file_surat && Storage::disk('public')->exists('surat_masuk/' . $surat->file_surat)) {
                Storage::disk('public')->delete('surat_masuk/' . $surat->file_surat);
            }

            // Hapus record Arsip
            Arsip::where('surat_masuk_id', $surat->id)->delete();

            // Hapus record Surat Masuk
            $surat->delete();
        });

        return redirect()
            ->route('surat_masuk.index')
            ->with('success', 'Surat masuk berhasil dihapus.');
    }
}