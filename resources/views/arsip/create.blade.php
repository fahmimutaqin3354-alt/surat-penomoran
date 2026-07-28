@extends('layouts.app')

@section('title', 'Tambah Arsip Surat')

@section('content')

<div class="px-4 py-6">

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h4 class="text-xl font-semibold text-gray-800">Tambah Arsip Surat</h4>
            <p class="text-sm text-gray-500">Tambahkan data arsip surat masuk atau surat keluar</p>
        </div>
        <a href="{{ route('arsip.index') }}"
           class="inline-flex items-center gap-1 px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-4">
            <ul class="list-disc list-inside space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

        <form action="{{ route('arsip.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">

                <div class="md:col-span-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Surat</label>
                    <select name="jenis"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="masuk" @selected(old('jenis')=='masuk')>Surat Masuk</option>
                        <option value="keluar" @selected(old('jenis')=='keluar')>Surat Keluar</option>
                    </select>
                </div>

                <div class="md:col-span-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Surat</label>
                    <input type="text"
                           name="no_surat"
                           value="{{ old('no_surat') }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>

                <div class="md:col-span-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="kategori"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoriList ?? [] as $kategori)
                            <option value="{{ $kategori }}" @selected(old('kategori')==$kategori)>{{ $kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-12">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Surat</label>
                    <input type="text"
                           name="judul"
                           value="{{ old('judul') }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>

                <div class="md:col-span-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pengirim / Penerima</label>
                    <input type="text"
                           name="pengirim_penerima"
                           value="{{ old('pengirim_penerima') }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>

                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Surat</label>
                    <input type="date"
                           name="tanggal_surat"
                           value="{{ old('tanggal_surat') }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>

                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                    <input type="number"
                           name="tahun"
                           value="{{ old('tahun', date('Y')) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>

                <div class="md:col-span-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                        <option value="">-- Pilih Status --</option>
                        <option value="Draft" @selected(old('status')=='Draft')>Draft</option>
                        <option value="Diproses" @selected(old('status')=='Diproses')>Diproses</option>
                        <option value="Selesai" @selected(old('status')=='Selesai')>Selesai</option>
                    </select>
                </div>

                <div class="md:col-span-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Arsip Oleh</label>
                    <input type="text"
                           name="arsip_oleh"
                           value="{{ old('arsip_oleh', auth()->user()->name ?? '') }}"
                           class="w-full rounded-lg border border-gray-300 bg-gray-100 px-3 py-2 text-sm text-gray-600 cursor-not-allowed focus:outline-none"
                           readonly>
                </div>

                <div class="md:col-span-12">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload File (PDF)</label>
                    <input type="file"
                           name="file_surat"
                           accept=".pdf"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="md:col-span-12">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                    <textarea name="keterangan"
                              rows="4"
                              class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('keterangan') }}</textarea>
                </div>

            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-white text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                    <i class="bi bi-save"></i>
                    Simpan
                </button>
                <a href="{{ route('arsip.index') }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-gray-200 px-4 py-2 text-gray-700 text-sm font-medium hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-colors">
                    Batal
                </a>
            </div>

        </form>

    </div>

</div>

@endsection