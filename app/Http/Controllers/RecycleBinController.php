<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\Arsip;
use Illuminate\Support\Facades\Storage;
class RecycleBinController extends Controller
{
    public function index()
    {
        $suratKeluar = SuratKeluar::onlyTrashed()->latest('deleted_at')->get();
        $suratMasuk = SuratMasuk::onlyTrashed()->latest('deleted_at')->get();
        $arsip = Arsip::onlyTrashed()->latest('deleted_at')->get();

        return view('recyclebin.index', compact('suratKeluar', 'suratMasuk', 'arsip'));
    }

  public function restoreSuratKeluar($id)
{
    SuratKeluar::onlyTrashed()->findOrFail($id)->restore();

    Arsip::onlyTrashed()->where('surat_keluar_id', $id)->restore();

    return back()->with('success', 'Surat keluar berhasil dipulihkan.');
}

public function restoreSuratMasuk($id)
{
    SuratMasuk::onlyTrashed()->findOrFail($id)->restore();

    Arsip::onlyTrashed()->where('surat_masuk_id', $id)->restore();

    return back()->with('success', 'Surat masuk berhasil dipulihkan.');
}

    public function restoreArsip($id)
{
    $arsip = Arsip::onlyTrashed()->findOrFail($id);

    if ($arsip->surat_keluar_id) {
        SuratKeluar::onlyTrashed()->where('id', $arsip->surat_keluar_id)->restore();
    }

    if ($arsip->surat_masuk_id) {
        SuratMasuk::onlyTrashed()->where('id', $arsip->surat_masuk_id)->restore();
    }

    $arsip->restore();

    return back()->with('success', 'Arsip berhasil dipulihkan.');
}

  public function forceDeleteSuratKeluar($id)
{
    $surat = SuratKeluar::onlyTrashed()->findOrFail($id);

    if ($surat->file_surat && Storage::disk('public')->exists('surat_keluar/' . $surat->file_surat)) {
        Storage::disk('public')->delete('surat_keluar/' . $surat->file_surat);
    }

    // Hapus arsip terkait secara permanen juga
    Arsip::where('surat_keluar_id', $surat->id)->withTrashed()->forceDelete();

    $surat->forceDelete();

    return back()->with('success', 'Surat keluar dihapus permanen.');
}

public function forceDeleteSuratMasuk($id)
{
    $surat = SuratMasuk::onlyTrashed()->findOrFail($id);

    if ($surat->file_surat && Storage::disk('public')->exists('surat_masuk/' . $surat->file_surat)) {
        Storage::disk('public')->delete('surat_masuk/' . $surat->file_surat);
    }

    // Hapus arsip terkait secara permanen juga
    Arsip::where('surat_masuk_id', $surat->id)->withTrashed()->forceDelete();

    $surat->forceDelete();

    return back()->with('success', 'Surat masuk dihapus permanen.');
}

public function forceDeleteArsip($id)
{
    $arsip = Arsip::onlyTrashed()->findOrFail($id);

    if ($arsip->file_surat) {
        Storage::disk('public')->delete($arsip->file_surat);
    }

    $arsip->forceDelete();

    return back()->with('success', 'Arsip dihapus permanen.');
}
}