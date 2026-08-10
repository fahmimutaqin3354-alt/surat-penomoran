<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use Illuminate\Http\Request;

class JenisSuratController extends Controller
{
    /**
     * Simpan jenis surat baru (dari modal di form surat keluar).
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:jenis_surats,nama',
            'kode_surat' => 'required|string|max:10|unique:jenis_surats,kode_surat',
            'form_type' => 'required|in:umum,kuasa',
            'template' => 'nullable|string',
        ]);

        $jenis = JenisSurat::create([
            'nama' => $request->nama,
            'kode_surat' => strtoupper($request->kode_surat),
            'form_type' => $request->form_type,
            'template' => $request->template,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jenis surat berhasil ditambahkan.',
            'data' => $jenis,
        ]);
    }
}

