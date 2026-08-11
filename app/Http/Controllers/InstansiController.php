<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use Illuminate\Http\Request;

class InstansiController extends Controller
{
    public function index(Request $request)
    {
        $query = Instansi::query();

        // Fitur pencarian instansi (bisa cari berdasarkan kode, nama, telepon, atau alamat)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_instansi', 'like', "%{$search}%")
                  ->orWhere('nama_instansi', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        $instansi = $query->latest()->paginate(10)->withQueryString();

        return view('instansi.index', compact('instansi'));
    }

    public function create()
    {
        return view('instansi.create');
    }

    public function store(Request $request)
    {
        // Validasi input (termasuk telepon & alamat)
        $validated = $request->validate([
            'kode_instansi' => 'required|string|max:100|unique:instansis,kode_instansi',
            'nama_instansi' => 'required|string|max:255',
            'telepon'       => 'nullable|string|max:20', // <--- DITAMBAHKAN
            'alamat'        => 'nullable|string',        // <--- DITAMBAHKAN
        ]);

        // Simpan langsung ke database
        Instansi::create($validated);

        return redirect()
            ->route('instansi.index')
            ->with('success', 'Data instansi berhasil ditambahkan.');
    }

    public function edit(Instansi $instansi)
    {
        return view('instansi.edit', compact('instansi'));
    }

    public function update(Request $request, Instansi $instansi)
    {
        // Validasi input (termasuk telepon & alamat)
        $validated = $request->validate([
            'kode_instansi' => 'required|string|max:100|unique:instansis,kode_instansi,' . $instansi->id,
            'nama_instansi' => 'required|string|max:255',
            'telepon'       => 'nullable|string|max:20', // <--- DITAMBAHKAN
            'alamat'        => 'nullable|string',        // <--- DITAMBAHKAN
        ]);

        // Update data di database
        $instansi->update($validated);

        return redirect()
            ->route('instansi.index')
            ->with('success', 'Data instansi berhasil diperbarui.');
    }

    public function destroy(Instansi $instansi)
    {
        $instansi->delete();

        return redirect()
            ->route('instansi.index')
            ->with('success', 'Data instansi berhasil dihapus.');
    }
}