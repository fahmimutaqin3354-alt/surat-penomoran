@extends('layouts.app')

@section('title', 'Edit Arsip Surat')

@section('content')

<div class="px-4 py-6">

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h4 class="text-2xl font-bold text-white">Edit Arsip Surat</h4>
            <p class="text-sm text-slate-400 mt-1">Perbarui data arsip surat</p>
        </div>
        <a href="{{ route('arsip.show', $surat->id) }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-800 bg-slate-900 text-slate-300 text-sm font-medium hover:bg-slate-800 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 rounded-lg px-4 py-3 mb-5">
            <ul class="list-disc list-inside space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-slate-900 border border-slate-800 rounded-xl p-6">

        <form action="{{ route('arsip.update', $surat->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">

                <div class="md:col-span-4">
                    <label class="block text-sm font-medium text-slate-300 mb-1">Jenis Surat</label>
                    <select name="jenis"
                            class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="masuk" @selected(old('jenis', $surat->jenis) == 'masuk')>Surat Masuk</option>
                        <option value="keluar" @selected(old('jenis', $surat->jenis) == 'keluar')>Surat Keluar</option>
                    </select>
                </div>

                <div class="md:col-span-4">
                    <label class="block text-sm font-medium text-slate-300 mb-1">Nomor Surat</label>
                    <input type="text"
                           name="no_surat"
                           value="{{ old('no_surat', $surat->no_surat) }}"
                           class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           required>
                </div>

                <div class="md:col-span-4">
                    <label class="block text-sm font-medium text-slate-300 mb-1">Kategori</label>
                    <select name="kategori"
                            class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoriList ?? [] as $kategori)
                            <option value="{{ $kategori }}" @selected(old('kategori', $surat->kategori ?? null) == $kategori)>{{ $kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-12">
                    <label class="block text-sm font-medium text-slate-300 mb-1">Judul Surat</label>
                    <input type="text"
                           name="judul"
                           value="{{ old('judul', $surat->judul) }}"
                           class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           required>
                </div>

                <div class="md:col-span-6">
                    <label class="block text-sm font-medium text-slate-300 mb-1">Pengirim / Penerima</label>
                    <input type="text"
                           name="pengirim_penerima"
                           value="{{ old('pengirim_penerima', $surat->pengirim_penerima) }}"
                           class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           required>
                </div>

                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-slate-300 mb-1">Tanggal Surat</label>
                    <input type="date"
                           name="tanggal_surat"
                           value="{{ old('tanggal_surat', \Carbon\Carbon::parse($surat->tanggal_surat)->format('Y-m-d')) }}"
                           class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           required>
                </div>

                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-slate-300 mb-1">Tahun</label>
                    <input type="number"
                           name="tahun"
                           value="{{ old('tahun', $surat->tahun) }}"
                           class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           required>
                </div>

                <div class="md:col-span-6">
                    <label class="block text-sm font-medium text-slate-300 mb-1">Status</label>
                    <select name="status"
                            class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required>
                        <option value="">-- Pilih Status --</option>
                        <option value="Draft" @selected(old('status', $surat->status) == 'Draft')>Draft</option>
                        <option value="Diproses" @selected(old('status', $surat->status) == 'Diproses')>Diproses</option>
                        <option value="Selesai" @selected(old('status', $surat->status) == 'Selesai')>Selesai</option>
                    </select>
                </div>

                <div class="md:col-span-6">
                    <label class="block text-sm font-medium text-slate-300 mb-1">Arsip Oleh</label>
                    <input type="text"
                           value="{{ $surat->arsip_oleh }}"
                           class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-sm text-slate-500 cursor-not-allowed"
                           readonly>
                </div>

                <div class="md:col-span-12">
                    <label class="block text-sm font-medium text-slate-300 mb-1">Upload File Baru (PDF)</label>
                    @if($surat->file_surat ?? null)
                        <p class="text-xs text-slate-500 mb-2">
                            File saat ini:
                            <a href="{{ asset('storage/arsip/' . $surat->file_surat) }}" target="_blank" class="text-indigo-400 hover:underline">
                                {{ $surat->file_surat }}
                            </a>
                            — biarkan kosong kalau tidak ingin mengganti file.
                        </p>
                    @endif
                    <input type="file"
                           name="file_surat"
                           accept=".pdf"
                           class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-sm text-slate-100 file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-indigo-500/10 file:text-indigo-400 hover:file:bg-indigo-500/20 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="md:col-span-12">
                    <label class="block text-sm font-medium text-slate-300 mb-1">Keterangan</label>
                    <textarea name="keterangan"
                              rows="4"
                              class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('keterangan', $surat->keterangan ?? '') }}</textarea>
                </div>

            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-white text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-slate-900 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('arsip.show', $surat->id) }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-slate-800 px-4 py-2 text-slate-300 text-sm font-medium hover:bg-slate-700 transition-colors">
                    Batal
                </a>
            </div>

        </form>

    </div>

</div>

@endsection