@extends('layouts.app')

@section('title', 'Edit Surat Masuk')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>

            <h1 class="text-3xl font-bold text-white">
                Edit Surat Masuk
            </h1>

            <p class="text-slate-400 mt-1">
                Perbarui data surat masuk PT Microdata Indonesia.
            </p>

        </div>

        <a href="{{ route('surat_masuk.index') }}"
           class="inline-flex items-center gap-2 bg-slate-700 hover:bg-slate-600 text-white px-5 py-3 rounded-xl font-semibold transition">

            <i class="fa-solid fa-arrow-left"></i>

            Kembali

        </a>

    </div>

    {{-- Card --}}
    <div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-lg">

        {{-- Header Card --}}
        <div class="border-b border-slate-800 px-6 py-5">

            <h2 class="text-xl font-bold text-white flex items-center gap-2">

                <i class="fa-solid fa-pen-to-square text-yellow-400"></i>

                Form Edit Surat Masuk

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
                action="{{ route('surat_masuk.update',$surat->id) }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Nomor Agenda --}}
                    <div>

                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Nomor Agenda
                        </label>

                        <input
                            type="text"
                            name="nomor_agenda"
                            value="{{ old('nomor_agenda',$surat->nomor_agenda) }}"
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
                            value="{{ old('nomor_surat',$surat->nomor_surat) }}"
                            required
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none">

                    </div>

                    {{-- Tanggal Surat --}}
                    <div>

                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Tanggal Surat
                        </label>

                        <input
                            type="date"
                            name="tanggal_surat"
                            value="{{ old('tanggal_surat',$surat->tanggal_surat) }}"
                            required
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500">

                    </div>

                    {{-- Tanggal Diterima --}}
                    <div>

                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Tanggal Diterima
                        </label>

                        <input
                            type="date"
                            name="tanggal_terima"
                            value="{{ old('tanggal_terima',$surat->tanggal_terima) }}"
                            required
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500">

                    </div>

                    {{-- Asal Surat --}}
                    <div>

                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Asal Surat
                        </label>

                        <input
                            type="text"
                            name="asal_surat"
                            value="{{ old('asal_surat',$surat->asal_surat) }}"
                            required
                            placeholder="Masukkan asal surat"
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500">

                    </div>

                    {{-- Jenis Surat --}}
                    <div>

                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Jenis Surat
                        </label>

                        <select
                            name="jenis_surat"
                            required
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500">

                            <option value="">-- Pilih Jenis Surat --</option>

                            <option value="Surat Tugas"
                                {{ old('jenis_surat',$surat->jenis_surat)=='Surat Tugas' ? 'selected' : '' }}>
                                Surat Tugas
                            </option>

                            <option value="Surat Undangan"
                                {{ old('jenis_surat',$surat->jenis_surat)=='Surat Undangan' ? 'selected' : '' }}>
                                Surat Undangan
                            </option>

                            <option value="Surat Pemberitahuan"
                                {{ old('jenis_surat',$surat->jenis_surat)=='Surat Pemberitahuan' ? 'selected' : '' }}>
                                Surat Pemberitahuan
                            </option>

                            <option value="Surat Permohonan"
                                {{ old('jenis_surat',$surat->jenis_surat)=='Surat Permohonan' ? 'selected' : '' }}>
                                Surat Permohonan
                            </option>

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
                            value="{{ old('perihal',$surat->perihal) }}"
                            required
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500">

                    </div>

                    {{-- Isi Ringkas --}}
                    <div class="md:col-span-2">

                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Isi Ringkas
                        </label>

                        <textarea
                            name="isi_ringkas"
                            rows="6"
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500">{{ old('isi_ringkas',$surat->isi_ringkas) }}</textarea>

                    </div>

                    {{-- Lampiran --}}
                    <div>

                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Lampiran
                        </label>

                        <input
                            type="text"
                            name="lampiran"
                            value="{{ old('lampiran',$surat->lampiran) }}"
                            placeholder="Contoh : 1 Berkas"
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none">

                    </div>

                    {{-- Status --}}
                    <div>

                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Status
                        </label>

                        <select
                            name="status"
                            required
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none">

                            <option value="">-- Pilih Status --</option>

                            <option value="Baru"
                                {{ old('status',$surat->status)=='Baru' ? 'selected' : '' }}>
                                Baru
                            </option>

                            <option value="Diproses"
                                {{ old('status',$surat->status)=='Diproses' ? 'selected' : '' }}>
                                Diproses
                            </option>

                            <option value="Selesai"
                                {{ old('status',$surat->status)=='Selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>

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
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none">{{ old('keterangan',$surat->keterangan) }}</textarea>

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
                            class="block w-full text-sm text-slate-300
                                   file:mr-4
                                   file:rounded-lg
                                   file:border-0
                                   file:bg-yellow-500
                                   file:px-4
                                   file:py-2
                                   file:text-white
                                   hover:file:bg-yellow-600">

                        @if($surat->file_surat)

                            <div class="mt-4 rounded-xl bg-slate-800 border border-slate-700 p-4">

                                <p class="text-slate-300 mb-2">
                                    File saat ini:
                                </p>

                                <a
                                    href="{{ asset('storage/surat_masuk/'.$surat->file_surat) }}"
                                    target="_blank"
                                    class="inline-flex items-center gap-2 text-yellow-400 hover:text-yellow-300">

                                    <i class="fa-solid fa-file-pdf"></i>

                                    Lihat PDF

                                </a>

                            </div>

                        @endif

                    </div>

                </div>

                {{-- Tombol --}}
                <div class="mt-8 flex flex-col sm:flex-row gap-3">

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-yellow-500 hover:bg-yellow-600 rounded-xl text-white font-semibold transition duration-200 shadow">

                        <i class="fa-solid fa-floppy-disk"></i>

                        Update Surat

                    </button>

                    <a
                        href="{{ route('surat_masuk.index') }}"
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
