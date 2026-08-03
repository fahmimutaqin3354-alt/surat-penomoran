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
                Tambahkan data surat masuk baru ke dalam sistem.
            </p>
        </div>

        <a href="{{ route('surat_masuk.index') }}"
           class="px-5 py-3 rounded-xl bg-slate-700 hover:bg-slate-600 text-white font-semibold transition inline-flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali</span>
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

            {{-- Global Error Alert --}}
            @if ($errors->any())
                <div class="mb-6 rounded-xl bg-red-500/10 border border-red-500/30 p-4">
                    <div class="text-red-400 font-semibold mb-2 flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span>Terjadi kesalahan pada pengisian form:</span>
                    </div>
                    <ul class="list-disc list-inside text-red-300 space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('surat_masuk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Nomor Agenda --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Nomor Agenda
                        </label>
                        <input type="text"
                               name="nomor_agenda"
                               value="{{ old('nomor_agenda', $nomorAgenda ?? '') }}"
                               readonly
                               class="w-full rounded-xl border border-slate-700 bg-slate-800/60 px-4 py-3 text-slate-400 cursor-not-allowed focus:outline-none">
                    </div>

                    {{-- Nomor Surat --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Nomor Surat <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                               name="nomor_surat"
                               value="{{ old('nomor_surat') }}"
                               required
                               placeholder="Masukkan nomor surat"
                               class="w-full rounded-xl border @error('nomor_surat') border-red-500 @else border-slate-700 @enderror bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        @error('nomor_surat')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal Surat --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Tanggal Surat <span class="text-rose-500">*</span>
                        </label>
                        <input type="date"
                               name="tanggal_surat"
                               value="{{ old('tanggal_surat') }}"
                               required
                               class="w-full rounded-xl border @error('tanggal_surat') border-red-500 @else border-slate-700 @enderror bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        @error('tanggal_surat')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal Terima --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Tanggal Diterima <span class="text-rose-500">*</span>
                        </label>
                        <input type="date"
                               name="tanggal_terima"
                               value="{{ old('tanggal_terima', date('Y-m-d')) }}"
                               required
                               class="w-full rounded-xl border @error('tanggal_terima') border-red-500 @else border-slate-700 @enderror bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        @error('tanggal_terima')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Asal Surat / Instansi --}}
                    <div>
                        <label for="instansi_id" class="block text-sm font-medium text-slate-300 mb-2">
                            Asal Surat / Instansi <span class="text-rose-500">*</span>
                        </label>
                        <select name="instansi_id" 
                                id="instansi_id" 
                                required
                                class="w-full rounded-xl border @error('instansi_id') border-red-500 @else border-slate-700 @enderror bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <option value="" disabled {{ old('instansi_id') ? '' : 'selected' }}>-- Pilih Instansi --</option>
                            @if(isset($instansis) && $instansis->count() > 0)
                                @foreach($instansis as $instansi)
                                    <option value="{{ $instansi->id }}" {{ old('instansi_id') == $instansi->id ? 'selected' : '' }}>
                                        {{ $instansi->nama_instansi }} {{ !empty($instansi->kode_instansi) ? '('.$instansi->kode_instansi.')' : '' }}
                                    </option>
                                @endforeach
                            @else
                                <option value="" disabled>Belum ada data instansi.</option>
                            @endif
                        </select>
                        @error('instansi_id')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis Surat --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Jenis Surat <span class="text-rose-500">*</span>
                        </label>
                        <select name="jenis_surat"
                                required
                                class="w-full rounded-xl border @error('jenis_surat') border-red-500 @else border-slate-700 @enderror bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <option value="" disabled {{ old('jenis_surat') ? '' : 'selected' }}>-- Pilih Jenis Surat --</option>
                            <option value="Surat Tugas" {{ old('jenis_surat') == 'Surat Tugas' ? 'selected' : '' }}>Surat Tugas</option>
                            <option value="Surat Undangan" {{ old('jenis_surat') == 'Surat Undangan' ? 'selected' : '' }}>Surat Undangan</option>
                            <option value="Surat Pemberitahuan" {{ old('jenis_surat') == 'Surat Pemberitahuan' ? 'selected' : '' }}>Surat Pemberitahuan</option>
                            <option value="Surat Permohonan" {{ old('jenis_surat') == 'Surat Permohonan' ? 'selected' : '' }}>Surat Permohonan</option>
                        </select>
                        @error('jenis_surat')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Perihal --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Perihal <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                               name="perihal"
                               value="{{ old('perihal') }}"
                               required
                               placeholder="Masukkan perihal surat"
                               class="w-full rounded-xl border @error('perihal') border-red-500 @else border-slate-700 @enderror bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        @error('perihal')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Isi Ringkas --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Isi Ringkas
                        </label>
                        <textarea name="isi_ringkas"
                                  rows="4"
                                  placeholder="Masukkan ringkasan isi surat..."
                                  class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('isi_ringkas') }}</textarea>
                    </div>

                    {{-- Lampiran --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Lampiran
                        </label>
                        <input type="text"
                               name="lampiran"
                               value="{{ old('lampiran') }}"
                               placeholder="Contoh : 1 Berkas"
                               class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Status <span class="text-rose-500">*</span>
                        </label>
                        <select name="status"
                                required
                                class="w-full rounded-xl border @error('status') border-red-500 @else border-slate-700 @enderror bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <option value="Baru" {{ old('status', 'Baru') == 'Baru' ? 'selected' : '' }}>Baru</option>
                            <option value="Diproses" {{ old('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Keterangan --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Keterangan
                        </label>
                        <textarea name="keterangan"
                                  rows="3"
                                  placeholder="Catatan atau keterangan tambahan..."
                                  class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('keterangan') }}</textarea>
                    </div>

                    {{-- Upload File --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Upload File Surat (PDF)
                        </label>
                        <input type="file"
                               name="file_surat"
                               accept=".pdf"
                               class="block w-full text-sm text-slate-300 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-white hover:file:bg-indigo-700 transition cursor-pointer border border-slate-700 rounded-xl bg-slate-950 p-2">
                        <p class="mt-1 text-xs text-slate-400">Format yang diterima: PDF. Ukuran maks: 2MB - 5MB (sesuai konfigurasi server).</p>
                        @error('file_surat')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Tombol Actions --}}
                <div class="mt-8 flex flex-col sm:flex-row gap-3 pt-6 border-t border-slate-800">
                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-xl text-white font-semibold transition cursor-pointer">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Surat</span>
                    </button>

                    <a href="{{ route('surat_masuk.index') }}"
                       class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-slate-700 hover:bg-slate-600 rounded-xl text-white font-semibold transition">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Batal</span>
                    </a>

                    <button type="reset"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-rose-600/20 hover:bg-rose-600/30 text-rose-400 rounded-xl font-semibold transition border border-rose-500/30 cursor-pointer">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Reset Form</span>
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>

@endsection