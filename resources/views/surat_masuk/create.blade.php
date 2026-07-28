@extends('layouts.app')

@section('title', 'Tambah Surat Masuk')

@section('content')

{{-- Trik khusus agar ikon kalender menjadi putih cerah di semua browser --}}
<style>
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1) brightness(2) !important;
        cursor: pointer !important;
        opacity: 0.9 !important;
    }
</style>

<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-3xl font-bold text-white">
                Tambah Surat Masuk
            </h1>

            <p class="text-slate-400 mt-1">
                Tambahkan data surat masuk baru.
            </p>

        </div>

        <a href="{{ route('surat_masuk.index') }}"
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

                <i class="fa-solid fa-envelope-open-text text-indigo-500"></i>

                Form Surat Masuk

            </h2>

        </div>

        {{-- Body --}}
        <div class="p-6">

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
                action="{{ route('surat_masuk.store') }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Nomor Agenda --}}
                    <div>

                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Nomor Agenda
                        </label>

                        <input
                            type="text"
                            name="nomor_agenda"
                            value="{{ old('nomor_agenda',$nomorAgenda) }}"
                            readonly
                            class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-slate-300">

                    </div>

                    {{-- Nomor Surat --}}
                    <div>

                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Nomor Surat
                        </label>

                        <input
                            type="text"
                            name="nomor_surat"
                            value="{{ old('nomor_surat') }}"
                            required
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500">

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
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500">

                    </div>

                    {{-- Tanggal Terima --}}
                    <div>

                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Tanggal Diterima
                        </label>

                        <input
                            type="date"
                            name="tanggal_terima"
                            value="{{ old('tanggal_terima') }}"
                            required
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500">

                    </div>

                    {{-- Asal Surat --}}
                    <div>

                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Asal Surat
                        </label>

                        <input
                            type="text"
                            name="asal_surat"
                            value="{{ old('asal_surat') }}"
                            required
                            placeholder="Masukkan asal surat"
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500">

                    </div>

                    {{-- Jenis Surat --}}
                    <div>

                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Jenis Surat
                        </label>

                        <select
                            name="jenis_surat"
                            required
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500">

                            <option value="">-- Pilih Jenis Surat --</option>

                            <option value="Surat Tugas">Surat Tugas</option>
                            <option value="Surat Undangan">Surat Undangan</option>
                            <option value="Surat Pemberitahuan">Surat Pemberitahuan</option>
                            <option value="Surat Permohonan">Surat Permohonan</option>

                        </select>

                    </div>

                    {{-- Perihal --}}
                    <div class="md:col-span-2">

                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Perihal
                        </label>

                        <input
                            type="text"
                            name="perihal"
                            value="{{ old('perihal') }}"
                            required
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500">

                    </div>

                    {{-- Isi Ringkas --}}
                    <div class="md:col-span-2">

                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Isi Ringkas
                        </label>

                        <textarea
                            name="isi_ringkas"
                            rows="6"
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500">{{ old('isi_ringkas') }}</textarea>

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
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500">

                    </div>

                    {{-- Status --}}
                    <div>

                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Status
                        </label>

                        <select
                            name="status"
                            required
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500">

                            <option value="Baru">Baru</option>
                            <option value="Diproses">Diproses</option>
                            <option value="Selesai">Selesai</option>

                        </select>

                    </div>

                    {{-- Keterangan --}}
                    <div class="md:col-span-2">

                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Keterangan
                        </label>

                        <textarea
                            name="keterangan"
                            rows="4"
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500">{{ old('keterangan') }}</textarea>

                    </div>

                    {{-- Upload File --}}
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
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-xl text-white font-semibold transition">

                        <i class="fa-solid fa-floppy-disk"></i>

                        Simpan Surat

                    </button>

                    <a
                        href="{{ route('surat_masuk.index') }}"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-slate-700 hover:bg-slate-600 rounded-xl text-white font-semibold transition">

                        <i class="fa-solid fa-arrow-left"></i>

                        Kembali

                    </a>

                    <button
                        type="reset"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-700 rounded-xl text-white font-semibold transition">

                        <i class="fa-solid fa-rotate-left"></i>

                        Reset

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection