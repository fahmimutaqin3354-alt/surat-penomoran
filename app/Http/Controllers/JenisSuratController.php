<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use Illuminate\Http\Request;

class JenisSuratController extends Controller
{
    /**
     * Tampilkan daftar jenis surat.
     */
    public function index()
    {
        $jenisSurat = JenisSurat::latest()->get();

        return view('jenis_surat.index', compact('jenisSurat'));
    }

    /**
     * Simpan jenis surat baru (dari modal di form surat keluar).
     */
    public function store(Request $request)
    {
        if ($request->has('kode_surat')) {
            $request->merge(['kode_surat' => strtoupper($request->kode_surat)]);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:jenis_surats,nama',
            'kode_surat' => 'required|string|max:10|unique:jenis_surats,kode_surat',
            'form_type' => 'required|in:umum,kuasa',
            'template' => 'nullable|string',
        ], [
            'kode_surat.unique' => 'Kode surat sudah pernah terpakai.',
            'nama.unique' => 'Nama jenis surat sudah pernah terpakai.',
            'kode_surat.required' => 'Kode surat wajib diisi.',
            'nama.required' => 'Nama jenis surat wajib diisi.',
        ]);

        $jenis = JenisSurat::create([
            'nama' => $validated['nama'],
            'kode_surat' => $validated['kode_surat'],
            'form_type' => $validated['form_type'],
            'template' => $validated['template'] ?? null,
        ]);

        return response()->json([
            'success'    => true,
            'message'    => 'Jenis surat berhasil ditambahkan.',
            'id'         => $jenis->id,
            'nama'       => $jenis->nama,
            'kode_surat' => $jenis->kode_surat,
            'form_type'  => $jenis->form_type,
        ]);
    }

    /**
     * Tampilkan form edit jenis surat.
     */
    public function edit(JenisSurat $jenisSurat)
    {
        return view('jenis_surat.edit', compact('jenisSurat'));
    }

    /**
     * Update jenis surat.
     */
    public function update(Request $request, JenisSurat $jenisSurat)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:jenis_surats,nama,' . $jenisSurat->id,
            'kode_surat' => 'required|string|max:10|unique:jenis_surats,kode_surat,' . $jenisSurat->id,
            'form_type' => 'required|in:umum,kuasa',
            'template' => 'nullable|string',
        ]);

        $validated['kode_surat'] = strtoupper($validated['kode_surat']);

        $jenisSurat->update($validated);

        return redirect()
            ->route('jenis_surat.index')
            ->with('success', 'Data jenis surat berhasil diperbarui.');
    }

    /**
     * Soft delete jenis surat.
     */
    public function destroy(JenisSurat $jenisSurat)
    {
        $jenisSurat->delete();

        return redirect()
            ->route('jenis_surat.index')
            ->with('success', 'Data jenis surat berhasil dipindahkan ke tempat sampah.');
    }
}


