<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\Arsip;
use App\Models\JenisSurat;
use App\Mail\SuratKeluarMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;

       
class SuratKeluarController extends Controller
{
    /**
     * Menampilkan daftar surat keluar
     */
    public function index()
    {
        $surat = SuratKeluar::latest()->paginate(10);
        $jumlahDihapus = SuratKeluar::onlyTrashed()->count();

        return view('surat_keluar.index', compact('surat','jumlahDihapus'));
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

        $jenisSuratList = JenisSurat::orderBy('nama')->get();

        return view('surat_keluar.create', compact('suratMasuk', 'jenisSuratList'));
    }

    /**
     * Bangun payload untuk jenis surat khusus (misal Surat Kuasa).
     * Untuk Surat Kuasa, perihal & isi_surat dibangun otomatis dari data_khusus.
     */
    private function buildKuasaData(Request $request)
    {
        $isKuasa = JenisSurat::where('nama', $request->jenis_surat)
            ->where('form_type', 'kuasa')
            ->exists();

        if (!$isKuasa) {
            return [
                'perihal' => $request->perihal,
                'tujuan' => $request->tujuan,
                'isi_surat' => $request->isi_surat,
                'data_khusus' => $request->input('data_khusus'),
            ];
        }

        $dk = $request->input('data_khusus', []);
        $pemberi = $dk['pemberi'] ?? [];
        $penerima = $dk['penerima'] ?? [];

        $isiSurat = "Yang bertanda tangan di bawah ini:\n\n";
        $isiSurat .= "Nama\t\t: " . ($pemberi['nama'] ?? '-') . "\n";
        $isiSurat .= "Alamat\t\t: " . ($pemberi['alamat'] ?? '-') . "\n";
        $isiSurat .= "No. KTP\t\t: " . ($pemberi['ktp'] ?? '-') . "\n\n";
        $isiSurat .= "Dengan ini memberikan kuasa kepada:\n\n";
        $isiSurat .= "Nama\t\t: " . ($penerima['nama'] ?? '-') . "\n";
        $isiSurat .= "Alamat\t\t: " . ($penerima['alamat'] ?? '-') . "\n";
        $isiSurat .= "No. KTP\t\t: " . ($penerima['ktp'] ?? '-') . "\n\n";
        $isiSurat .= "Untuk\t\t: " . ($dk['hal'] ?? '-') . "\n\n";
        $isiSurat .= "Demikian surat kuasa ini dibuat untuk dipergunakan sebagaimana mestinya.";

        return [
            'perihal' => 'Pemberian Kuasa',
            'tujuan' => $penerima['nama'] ?? $request->tujuan,
            'isi_surat' => $isiSurat,
            'data_khusus' => $dk,
        ];
    }

    /**
     * Generate Nomor Surat Otomatis
     * Format:
     * 001/SK/DIR-I/PT-MDI/VIII/2026
     */
    private function generateNomorSurat($kodeSurat, $kodeDivisi)
    {
        $bulan = now()->month;
        $tahun = now()->year;

        $romawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV',
            5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII',
            9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII',
        ];

        $kodeSurat = strtoupper($kodeSurat);

        do {
            $lastNomor = SuratKeluar::withTrashed()
                ->whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun)
                ->get()
                ->map(function ($surat) {
                    return (int) explode('/', $surat->nomor_surat)[0];
                })
                ->max();

            $jumlah = ($lastNomor ?? 0) + 1;

            $nomorFormatted = $jumlah < 100
                ? str_pad($jumlah, 2, '0', STR_PAD_LEFT)
                : $jumlah;

            $nomorSurat = $nomorFormatted . '/' . $kodeSurat . '/' . $kodeDivisi . '/PT-MDI/' . $romawi[$bulan] . '/' . $tahun;

            $exists = SuratKeluar::where('nomor_surat', $nomorSurat)->exists();

            $jumlah++;
        } while ($exists);

        return $nomorSurat;
    }
/**
 * Menyimpan surat keluar
 */
public function store(Request $request)
{
    $isKuasa = JenisSurat::where('nama', $request->jenis_surat)
        ->where('form_type', 'kuasa')
        ->exists();

    $request->validate([
        'tanggal_surat' => 'required|date',
        'jenis_surat' => 'required|string|max:100',
        'kode_surat' => 'nullable|string|max:10',
        'kode_divisi' => 'required|string|max:20',
        'tujuan' => $isKuasa ? 'nullable|string|max:255' : 'required|string|max:255',
        'perihal' => $isKuasa ? 'nullable|string|max:255' : 'required|string|max:255',
        'isi_surat' => $isKuasa ? 'nullable|string' : 'required|string',
        'data_khusus' => $isKuasa ? 'required|array' : 'nullable|array',
        'lampiran' => 'nullable|string|max:255',
        'penandatangan' => $isKuasa ? 'nullable|string|max:255' : 'required|string|max:255',
        'jabatan_penandatangan' => $isKuasa ? 'nullable|string|max:255' : 'required|string|max:255',
        'status' => 'required|in:Draft,Dikirim,Selesai',
        'file_surat' => 'nullable|mimes:pdf|max:2048',
    ]);

    // Kumpulkan data khusus (misal data Surat Kuasa)
    $kuasaData = $this->buildKuasaData($request);
    $dataKhusus = $kuasaData['data_khusus'];


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

        'nomor_surat' => $this->generateNomorSurat($request->kode_surat ?? 'SK', $request->kode_divisi),

        'tanggal_surat' => $request->tanggal_surat,

        'jenis_surat' => $request->jenis_surat,

        'kode_surat' => strtoupper($request->kode_surat),

        'kode_divisi' => $request->kode_divisi,

        'tujuan' => $kuasaData['tujuan'],

        'perihal' => $kuasaData['perihal'],

        'isi_surat' => $kuasaData['isi_surat'],

        'data_khusus' => $dataKhusus,

        'lampiran' => $request->lampiran,

        'penandatangan' => $request->penandatangan ?? ($dataKhusus['pemberi']['nama'] ?? 'Pemberi Kuasa'),

        'jabatan_penandatangan' => $request->jabatan_penandatangan ?? 'Pemberi Kuasa',

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
        ->route('surat_keluar.create', $surat->id)
        ->with('success', 'Surat keluar berhasil dibuat.')
        ->with('surat_tersimpan', $surat);
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

    $jenisSuratList = JenisSurat::orderBy('nama')->get();

    return view('surat_keluar.edit', compact('surat', 'jenisSuratList'));
}

/**
 * Mengupdate data surat keluar
 */
public function update(Request $request, $id)
{
    $surat = SuratKeluar::findOrFail($id);

    $isKuasa = JenisSurat::where('nama', $request->jenis_surat)
        ->where('form_type', 'kuasa')
        ->exists();

    $request->validate([
        'tanggal_surat' => 'required|date',
        'jenis_surat' => 'required|string|max:100',
        'kode_surat' => 'nullable|string|max:10',
        'kode_divisi' => 'required|string|max:20',
        'tujuan' => $isKuasa ? 'nullable|string|max:255' : 'required|string|max:255',
        'perihal' => $isKuasa ? 'nullable|string|max:255' : 'required|string|max:255',
        'isi_surat' => $isKuasa ? 'nullable|string' : 'required|string',
        'data_khusus' => $isKuasa ? 'required|array' : 'nullable|array',
        'lampiran' => 'nullable|string|max:255',
        'penandatangan' => $isKuasa ? 'nullable|string|max:255' : 'required|string|max:255',
        'jabatan_penandatangan' => $isKuasa ? 'nullable|string|max:255' : 'required|string|max:255',
        'status' => 'required|in:Draft,Dikirim,Selesai',
        'file_surat' => 'nullable|mimes:pdf|max:2048',
    ]);

    // Kumpulkan data khusus (misal data Surat Kuasa)
    $kuasaData = $this->buildKuasaData($request);
    $dataKhusus = $kuasaData['data_khusus'];


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

        'kode_surat' => strtoupper($request->kode_surat),

        'kode_divisi' => $request->kode_divisi,

        'tujuan' => $kuasaData['tujuan'],

        'perihal' => $kuasaData['perihal'],

        'isi_surat' => $kuasaData['isi_surat'],

        'data_khusus' => $dataKhusus,

        'lampiran' => $request->lampiran,

        'penandatangan' => $request->penandatangan ?? ($dataKhusus['pemberi']['nama'] ?? 'Pemberi Kuasa'),

        'jabatan_penandatangan' => $request->jabatan_penandatangan ?? 'Pemberi Kuasa',

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

    // Hapus data arsip yang terkait (soft delete otomatis)
    Arsip::where('surat_keluar_id', $surat->id)->delete();

    // Hapus surat keluar (soft delete otomatis)
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
 public function downloadPublic($id)
    {
        $surat = SuratKeluar::findOrFail($id);
 
        $pdf = Pdf::loadView('surat_keluar.pdf', compact('surat'));
 
        $namaFile = 'Surat-' . str_replace(['/', '\\'], '-', $surat->nomor_surat) . '.pdf';
 
        return $pdf->stream($namaFile);
    }

/**
 * Kirim Email
 */
    public function sendEmail(Request $request, $id)
{
    $surat = SuratKeluar::findOrFail($id);

    $request->validate([
        'email' => 'required|email',
    ]);

    if (!$surat->file_surat) {
        return back()->with('error', 'File surat belum tersedia. Silakan unduh/generate PDF terlebih dahulu.');
    }

    $path = 'surat_keluar/' . $surat->file_surat;

    if (!Storage::disk('public')->exists($path)) {
        return back()->with('error', 'File surat tidak ditemukan di server.');
    }

    $lampiran = [[
        'nama' => 'Surat-' . str_replace(['/', '\\'], '-', $surat->nomor_surat) . '.pdf',
        'mime' => 'application/pdf',
        'isi'  => Storage::disk('public')->get($path),
    ]];

    Mail::to($request->email)->send(new SuratKeluarMail($surat, $lampiran));

    return back()->with('success', 'Surat berhasil dikirim ke ' . $request->email);
}

/**
 * Kirim WA
 */

   public function sendWhatsapp(Request $request, $id)
{
    $surat = SuratKeluar::findOrFail($id);

    $request->validate([
        'nomor_wa' => 'required|string',
    ]);

    $nomor = preg_replace('/\D/', '', $request->nomor_wa);
    if (str_starts_with($nomor, '0')) {
        $nomor = '62' . substr($nomor, 1);
    } elseif (!str_starts_with($nomor, '62')) {
        $nomor = '62' . $nomor;
    }

    if (!$surat->file_surat) {
        return back()->with('error', 'File surat belum tersedia.');
    }

    $path = storage_path('app/public/surat_keluar/' . $surat->file_surat);

    if (!file_exists($path)) {
        return back()->with('error', 'File surat tidak ditemukan di server.');
    }

    $pesan = "Berikut surat keluar No. {$surat->nomor_surat}, perihal: {$surat->perihal}.";
    $namaFilePdf = 'Surat-' . str_replace(['/', '\\'], '-', $surat->nomor_surat) . '.pdf';

    $response = Http::post('http://localhost:3000/send-file', [
        'nomor'    => $nomor,
        'pesan'    => $pesan,
        'filePath' => $path,
        'fileName' => $namaFilePdf,
    ]);

    if ($response->successful() && $response->json('success') === true) {
        return back()->with('success', 'Surat berhasil dikirim ke WhatsApp.');
    }

    return back()->with('error', 'Gagal mengirim ke WhatsApp. Coba lagi.');
}

}

