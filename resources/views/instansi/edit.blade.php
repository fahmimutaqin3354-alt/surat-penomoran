@extends('layouts.app')

@section('title', 'Edit Instansi')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex items-center justify-between p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-xl shadow-xl">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Edit Instansi</h1>
            <p class="text-slate-400 text-sm mt-1">Ubah informasi data instansi.</p>
        </div>
        <a href="{{ route('instansi.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-semibold border border-slate-700 transition duration-200">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Form Section -->
    <div class="p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-xl shadow-xl">
        <form action="{{ route('instansi.update', $instansi->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kode Instansi -->
                <div>
                    <label for="kode_instansi" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                        Kode Instansi <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="kode_instansi" id="kode_instansi" value="{{ old('kode_instansi', $instansi->kode_instansi) }}" required
                           class="w-full px-4 py-3 rounded-xl bg-slate-950/80 border @error('kode_instansi') border-rose-500 @else border-slate-800 @enderror text-slate-200 focus:outline-none focus:border-indigo-500 text-sm transition">
                    @error('kode_instansi')
                        <p class="text-rose-400 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Instansi -->
                <div>
                    <label for="nama_instansi" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                        Nama Instansi <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama_instansi" id="nama_instansi" value="{{ old('nama_instansi', $instansi->nama_instansi) }}" required
                           class="w-full px-4 py-3 rounded-xl bg-slate-950/80 border @error('nama_instansi') border-rose-500 @else border-slate-800 @enderror text-slate-200 focus:outline-none focus:border-indigo-500 text-sm transition">
                    @error('nama_instansi')
                        <p class="text-rose-400 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telepon -->
                <div class="md:col-span-2">
                    <label for="telepon" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Telepon / WhatsApp</label>
                    <input type="text" name="telepon" id="telepon" value="{{ old('telepon', $instansi->telepon) }}"
                           class="w-full px-4 py-3 rounded-xl bg-slate-950/80 border border-slate-800 text-slate-200 focus:outline-none focus:border-indigo-500 text-sm transition">
                </div>

                <!-- Alamat -->
                <div class="md:col-span-2">
                    <label for="alamat" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Alamat Lengkap</label>
                    <textarea name="alamat" id="alamat" rows="3"
                              class="w-full px-4 py-3 rounded-xl bg-slate-950/80 border border-slate-800 text-slate-200 focus:outline-none focus:border-indigo-500 text-sm transition">{{ old('alamat', $instansi->alamat) }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-500 text-white text-sm font-semibold shadow-lg shadow-amber-500/20 transition duration-200">
                    Perbarui Instansi
                </button>
            </div>
        </form>
    </div>

</div>
@endsection