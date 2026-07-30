@extends('layouts.app')

@section('title', 'Tambah Arsip Surat')

@section('content')

<div class="p-6 max-w-7xl mx-auto space-y-6">

    <!-- Header Section -->
    <div class="flex flex-wrap items-center justify-between gap-4 pt-2 pb-2">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-wide">Tambah Arsip Surat</h1>
            <p class="text-sm text-gray-400 mt-1">Tambahkan data arsip surat masuk atau surat keluar</p>
        </div>
        <a href="{{ route('arsip.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 border border-slate-700 bg-slate-800/80 hover:bg-slate-700 text-gray-200 rounded-lg text-sm font-medium transition-all shadow-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Kembali
        </a>
    </div>

    <!-- Alert Error Validation -->
    @if ($errors->any())
        <div class="bg-red-500/10 border border-red-500/50 text-red-400 rounded-xl p-4 shadow-lg">
            <ul class="list-disc list-inside space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Container (Full Dark Card) -->
    <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-6 md:p-8 shadow-2xl text-gray-100">

        <form action="{{ route('arsip.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-12 gap-5">

                <!-- Jenis Surat -->
                <div class="md:col-span-4">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Jenis Surat</label>
                    <select name="jenis"
                            class="w-full rounded-xl border border-slate-700 bg-slate-800/80 px-3.5 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            required>
                        <option value="" class="bg-slate-900 text-gray-400">-- Pilih Jenis --</option>
                        <option value="masuk" class="bg-slate-900 text-white" @selected(old('jenis')=='masuk')>Surat Masuk</option>
                        <option value="keluar" class="bg-slate-900 text-white" @selected(old('jenis')=='keluar')>Surat Keluar</option>
                    </select>
                </div>

                <!-- Nomor Surat -->
                <div class="md:col-span-4">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Nomor Surat</label>
                    <input type="text"
                           name="no_surat"
                           value="{{ old('no_surat') }}"
                           class="w-full rounded-xl border border-slate-700 bg-slate-800/80 px-3.5 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                           required>
                </div>

                <!-- Kategori -->
                <div class="md:col-span-4">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Kategori</label>
                    <select name="kategori"
                            class="w-full rounded-xl border border-slate-700 bg-slate-800/80 px-3.5 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <option value="" class="bg-slate-900 text-gray-400">-- Pilih Kategori --</option>
                        @foreach($kategoriList ?? [] as $kategori)
                            <option value="{{ $kategori }}" class="bg-slate-900 text-white" @selected(old('kategori')==$kategori)>{{ $kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Judul Surat -->
                <div class="md:col-span-12">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Judul Surat</label>
                    <input type="text"
                           name="judul"
                           value="{{ old('judul') }}"
                           class="w-full rounded-xl border border-slate-700 bg-slate-800/80 px-3.5 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                           required>
                </div>

                <!-- Pengirim / Penerima -->
                <div class="md:col-span-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Pengirim / Penerima</label>
                    <input type="text"
                           name="pengirim_penerima"
                           value="{{ old('pengirim_penerima') }}"
                           class="w-full rounded-xl border border-slate-700 bg-slate-800/80 px-3.5 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                           required>
                </div>

                <!-- Tanggal Surat -->
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Tanggal Surat</label>
                    <input type="date"
                           name="tanggal_surat"
                           value="{{ old('tanggal_surat') }}"
                           class="w-full rounded-xl border border-slate-700 bg-slate-800/80 px-3.5 py-2.5 text-sm text-white [color-scheme:dark] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                           required>
                </div>

                <!-- Tahun -->
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Tahun</label>
                    <input type="number"
                           name="tahun"
                           value="{{ old('tahun', date('Y')) }}"
                           class="w-full rounded-xl border border-slate-700 bg-slate-800/80 px-3.5 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                           required>
                </div>

                <!-- Status -->
                <div class="md:col-span-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                    <select name="status"
                            class="w-full rounded-xl border border-slate-700 bg-slate-800/80 px-3.5 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            required>
                        <option value="" class="bg-slate-900 text-gray-400">-- Pilih Status --</option>
                        <option value="Draft" class="bg-slate-900 text-white" @selected(old('status')=='Draft')>Draft</option>
                        <option value="Diproses" class="bg-slate-900 text-white" @selected(old('status')=='Diproses')>Diproses</option>
                        <option value="Selesai" class="bg-slate-900 text-white" @selected(old('status')=='Selesai')>Selesai</option>
                    </select>
                </div>

                <!-- Arsip Oleh -->
                <div class="md:col-span-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Arsip Oleh</label>
                    <input type="text"
                           name="arsip_oleh"
                           value="{{ old('arsip_oleh', auth()->user()->name ?? 'zulfakar anggara') }}"
                           class="w-full rounded-xl border border-slate-800 bg-slate-800/40 px-3.5 py-2.5 text-sm text-gray-400 cursor-not-allowed focus:outline-none"
                           readonly>
                </div>

                <!-- Upload File (PDF) -->
                <div class="md:col-span-12">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Upload File (PDF)</label>
                    <div class="border border-slate-700 rounded-xl p-2 bg-slate-800/80">
                        <input type="file"
                               name="file_surat"
                               accept=".pdf"
                               class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-600 file:text-white file:font-medium hover:file:bg-blue-700 focus:outline-none cursor-pointer">
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="md:col-span-12">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Keterangan</label>
                    <textarea name="keterangan"
                              rows="4"
                              class="w-full rounded-xl border border-slate-700 bg-slate-800/80 px-3.5 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">{{ old('keterangan') }}</textarea>
                </div>

            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex items-center gap-3">
                <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium transition-all focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-md">
                    Simpan
                </button>
                <a href="{{ route('arsip.index') }}"
                   class="px-6 py-2.5 bg-slate-800 hover:bg-slate-700 border border-slate-700 text-gray-300 rounded-xl text-sm font-medium transition-all focus:outline-none">
                    Batal
                </a>
            </div>

        </form>

    </div>

</div>

@endsection