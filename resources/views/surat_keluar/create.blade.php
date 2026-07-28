@extends('layouts.app')

@section('title', 'Tambah Surat Keluar')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-3xl font-bold text-white">
                Tambah Surat Keluar
            </h1>

            <p class="text-slate-400 mt-1">
                Tambahkan data surat keluar baru.
            </p>

        </div>

        <a href="{{ route('surat_keluar.index') }}"
           class="px-5 py-3 rounded-xl bg-slate-700 hover:bg-slate-600 text-white font-semibold transition">

            <i class="fa-solid fa-arrow-left mr-2"></i>

            Kembali

        </a>

    </div>

    {{-- Card --}}
    <div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-lg">

        {{-- Header Card --}}
        <div class="border-b border-slate-800 px-6 py-5">

            <h2 class="text-xl font-bold text-white flex items-center gap-2">

                <i class="fa-solid fa-file-circle-plus text-indigo-500"></i>

                Form Surat Keluar

            </h2>

        </div>

        {{-- Body --}}
        <div class="p-6">

            {{-- Error --}}
            @if ($errors->any())

                <div class="mb-6 rounded-xl bg-red-500/10 border border-red-500/30 p-4">

                    <div class="text-red-400 font-semibold mb-2">

                        Terjadi kesalahan:

                    </div>

                    <ul class="list-disc list-inside text-red-300 space-y-1">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form
                action="{{ route('surat_keluar.store') }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf
            @if($suratMasuk)
    <input
        type="hidden"
        name="surat_masuk_id"
        value="{{ $suratMasuk->id }}">
@endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

{{-- Jenis Surat --}}
<div>
    <label class="block text-sm font-medium text-slate-300 mb-2">
        Jenis Surat
    </label>

    <select
        name="jenis_surat"
        required
        class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">

        <option value="">-- Pilih Jenis Surat --</option>

        <option value="Surat Tugas"
            {{ old('jenis_surat') == 'Surat Tugas' ? 'selected' : '' }}>
            Surat Tugas
        </option>

        <option value="Surat Undangan"
            {{ old('jenis_surat') == 'Surat Undangan' ? 'selected' : '' }}>
            Surat Undangan
        </option>

        <option value="Surat Pemberitahuan"
            {{ old('jenis_surat') == 'Surat Pemberitahuan' ? 'selected' : '' }}>
            Surat Pemberitahuan
        </option>

        <option value="Surat Permohonan"
            {{ old('jenis_surat') == 'Surat Permohonan' ? 'selected' : '' }}>
            Surat Permohonan
        </option>

    </select>
</div>

{{-- Tanggal Surat --}}
<div>

    <label class="block text-sm font-medium text-slate-300 mb-2">
        Tanggal Surat
    </label>

    <input
        type="date"
        name="tanggal_surat"
        value="{{ old('tanggal_surat') }}"
        required
        class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">

</div>

{{-- Tujuan --}}
<div>

    <label class="block text-sm font-medium text-slate-300 mb-2">
        Tujuan
    </label>

    <input
        type="text"
        name="tujuan"
        value="{{ old('tujuan', $suratMasuk?->asal_surat) }}"
        required
        placeholder="Masukkan tujuan surat"
        class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">

</div>

{{-- Perihal --}}
<div>

    <label class="block text-sm font-medium text-slate-300 mb-2">
        Perihal
    </label>

    <input
        type="text"
        name="perihal"
        value="{{ old('perihal', $suratMasuk ? 'Re: '.$suratMasuk->perihal : '') }}"
        required
        placeholder="Masukkan perihal"
        class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">

</div>

{{-- Isi Surat --}}
<div class="md:col-span-2">

    <label class="block text-sm font-medium text-slate-300 mb-2">
        Isi Surat
    </label>

    <textarea
        name="isi_surat"
        rows="6"
        required
        placeholder="Tulis isi surat..."
        class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">{{ old('isi_surat') }}</textarea>

</div>

{{-- Lampiran --}}
<div>

    <label class="block text-sm font-medium text-slate-300 mb-2">
        Lampiran
    </label>

    <input
        type="text"
        name="lampiran"
        value="{{ old('lampiran') }}"
        placeholder="Contoh : 1 Berkas"
        class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">

</div>

{{-- Status --}}
<div>

    <label class="block text-sm font-medium text-slate-300 mb-2">
        Status
    </label>

    <select
        name="status"
        required
        class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">

        <option value="">-- Pilih Status --</option>

        <option value="Draft"
            {{ old('status') == 'Draft' ? 'selected' : '' }}>
            Draft
        </option>

        <option value="Dikirim"
            {{ old('status') == 'Dikirim' ? 'selected' : '' }}>
            Dikirim
        </option>

        <option value="Selesai"
            {{ old('status') == 'Selesai' ? 'selected' : '' }}>
            Selesai
        </option>

    </select>

</div>

{{-- Penandatangan --}}
<div>

    <label class="block text-sm font-medium text-slate-300 mb-2">
        Penandatangan
    </label>

    <input
        type="text"
        name="penandatangan"
        value="{{ old('penandatangan') }}"
        required
        class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">

</div>

{{-- Jabatan --}}
<div>

    <label class="block text-sm font-medium text-slate-300 mb-2">
        Jabatan Penandatangan
    </label>

    <input
        type="text"
        name="jabatan_penandatangan"
        value="{{ old('jabatan_penandatangan') }}"
        required
        class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">

</div>

{{-- Upload PDF --}}
<div class="md:col-span-2">

    <label class="block text-sm font-medium text-slate-300 mb-2">
        Upload File Surat (PDF)
    </label>

    <input
        type="file"
        name="file_surat"
        accept=".pdf"
        class="block w-full text-sm text-slate-300 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-white hover:file:bg-indigo-700">

</div>

                </div>

                {{-- Tombol --}}
                <div class="mt-8 flex flex-col sm:flex-row gap-3">

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-xl text-white font-semibold transition duration-200 shadow">

                        <i class="fa-solid fa-floppy-disk"></i>

                        Simpan Surat

                    </button>

                    <a
                        href="{{ route('surat_keluar.index') }}"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-slate-700 hover:bg-slate-600 rounded-xl text-white font-semibold transition duration-200">

                        <i class="fa-solid fa-arrow-left"></i>

                        Kembali

                    </a>

                    <button
                        type="reset"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-700 rounded-xl text-white font-semibold transition duration-200">

                        <i class="fa-solid fa-rotate-left"></i>

                        Reset

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
