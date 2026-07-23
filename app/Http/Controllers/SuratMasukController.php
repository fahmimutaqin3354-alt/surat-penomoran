<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Illuminate\Http\Request;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $surat = SuratMasuk::all();

    return view('surat_masuk.index', compact('surat'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    return view('surat_masuk.create');
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    SuratMasuk::create($request->all());

    return redirect()->route('surat-masuk.index');
}

    /**
     * Display the specified resource.
     */
    public function show(SuratMasuk $suratMasuk)
{
    return view('surat_masuk.show', compact('suratMasuk'));
}
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratMasuk $suratMasuk)
{
    return view('surat_masuk.edit', compact('suratMasuk'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratMasuk $suratMasuk)
{
    $suratMasuk->update($request->all());

    return redirect()->route('surat-masuk.index');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratMasuk $suratMasuk)
{
    $suratMasuk->delete();

    return redirect()->route('surat-masuk.index');
}
}
