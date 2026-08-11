@extends('layouts.app')

@section('title', 'Tambah Surat Masuk')

@section('content')

<style>
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1) brightness(2) !important;
        cursor: pointer !important;
        opacity: 0.9 !important;
    }
    .a4-paper {
        width: 100%;
        min-height: 297mm;
        background: white;
        color: #000;
        font-family: "Times New Roman", Times, serif;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);
    }
</style>

<div class="max-w-[1600px] mx-auto"
     x-data="{
        nomor_agenda: '{{ old('nomor_agenda', $nomorAgenda ?? 'AGD-0001') }}',
        nomor_surat: '{{ old('nomor_surat', '') }}',
        tanggal_surat: '{{ old('tanggal_surat', date('Y-m-d')) }}',
        tanggal_terima: '{{ old('tanggal_terima', date('Y-m-d')) }}',
        instansi_id: '{{ old('instansi_id', '') }}',
        instansi_nama: '',
        jenis_surat: '{{ old('jenis_surat', 'Surat Pemberitahuan') }}',
        perihal: '{{ old('perihal', '') }}',
        isi_ringkas: '{{ old('isi_ringkas', '') }}',
        lampiran: '{{ old('lampiran', '') }}',
        status: '{{ old('status', 'Baru') }}',
        keterangan: '{{ old('keterangan', '') }}',

        updateInstansiNama(el) {
            if(el.selectedIndex >= 0) {
                const optText = el.options[el.selectedIndex].text;
                this.instansi_nama = optText.startsWith('--') ? '' : optText;
            }
        },

        formatTanggal(val) {
            if (!val) return '-';
            const parts = val.split('-');
            if (parts.length !== 3) return val;
            const bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            const blnIdx = parseInt(parts[1], 10);
            return parseInt(parts[2], 10) + ' ' + (bulan[blnIdx] || '') + ' ' + parts[0];
        },

        downloadPreviewPdf() {
            const element = document.getElementById('surat-masuk-preview-paper');
            const opt = {
                margin: [10, 10, 10, 10],
                filename: 'Surat_Masuk_Agenda_Preview.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true, logging: false },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save();
        }
     }"
     x-init="$nextTick(() => { const sel = document.getElementById('instansi_select'); if(sel) updateInstansiNama(sel); })">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                <i class="fa-solid fa-inbox text-indigo-500"></i>
                Tambah Surat Masuk
            </h1>
            <p class="text-slate-400 mt-1">
                Isi rincian surat masuk di sebelah kiri, dokumen Lembar Agenda A4 akan ter-update secara <span class="text-indigo-400 font-semibold">Real-time</span> di sebelah kanan.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('surat_masuk.index') }}"
               class="px-5 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-semibold transition inline-flex items-center gap-2 border border-slate-700">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    {{-- Grid Layout Split Screen --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        {{-- LEFT COLUMN: FORM INPUTS --}}
        <div class="lg:col-span-6 space-y-6">

            <div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-xl overflow-hidden">
                <div class="border-b border-slate-800 px-6 py-4 bg-slate-950/50 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-envelope-open-text text-indigo-400"></i>
                        Form Surat Masuk
                    </h2>
                    <span class="text-xs bg-indigo-500/20 text-indigo-300 px-3 py-1 rounded-full font-medium border border-indigo-500/30">
                        Live Preview Mode
                    </span>
                </div>

                <div class="p-6">
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

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                            {{-- Nomor Agenda --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Nomor Agenda
                                </label>
                                <input type="text" name="nomor_agenda" x-model="nomor_agenda" readonly
                                       class="w-full rounded-xl border border-slate-700 bg-slate-800/60 px-4 py-3 text-slate-400 cursor-not-allowed outline-none">
                            </div>

                            {{-- Nomor Surat --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Nomor Surat <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="nomor_surat" required x-model="nomor_surat"
                                       placeholder="Masukkan nomor surat"
                                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 outline-none">
                            </div>

                            {{-- Tanggal Surat --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Tanggal Surat <span class="text-rose-500">*</span>
                                </label>
                                <input type="date" name="tanggal_surat" required x-model="tanggal_surat"
                                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 outline-none">
                            </div>

                            {{-- Tanggal Diterima --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Tanggal Diterima <span class="text-rose-500">*</span>
                                </label>
                                <input type="date" name="tanggal_terima" required x-model="tanggal_terima"
                                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 outline-none">
                            </div>

                            {{-- Asal Surat / Instansi --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Asal Surat / Instansi <span class="text-rose-500">*</span>
                                </label>
                                <select name="instansi_id" id="instansi_select" required x-model="instansi_id" @change="updateInstansiNama($event.target)"
                                        class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 outline-none">
                                    <option value="">-- Pilih Instansi --</option>
                                    @foreach($instansis as $instansi)
                                        <option value="{{ $instansi->id }}" {{ old('instansi_id') == $instansi->id ? 'selected' : '' }}>
                                            {{ $instansi->nama_instansi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Jenis Surat --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Jenis Surat <span class="text-rose-500">*</span>
                                </label>
                                <select name="jenis_surat" required x-model="jenis_surat"
                                        class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 outline-none">
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
                                    Perihal <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="perihal" required x-model="perihal"
                                       placeholder="Masukkan perihal surat"
                                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 outline-none">
                            </div>

                            {{-- Isi Ringkas --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Isi Ringkas
                                </label>
                                <textarea name="isi_ringkas" rows="5" x-model="isi_ringkas"
                                          placeholder="Masukkan ringkasan isi surat..."
                                          class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 outline-none"></textarea>
                            </div>

                            {{-- Lampiran --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Lampiran
                                </label>
                                <input type="text" name="lampiran" x-model="lampiran"
                                       placeholder="Contoh: 1 Berkas"
                                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 outline-none">
                            </div>

                            {{-- Status --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Status <span class="text-rose-500">*</span>
                                </label>
                                <select name="status" required x-model="status"
                                        class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 outline-none">
                                    <option value="Baru">Baru</option>
                                    <option value="Diproses">Diproses</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                            </div>

                            {{-- Keterangan --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Keterangan / Catatan Disposisi
                                </label>
                                <textarea name="keterangan" rows="3" x-model="keterangan"
                                          placeholder="Catatan atau keterangan tambahan..."
                                          class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 outline-none"></textarea>
                            </div>

                            {{-- Upload File --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Upload File Surat Fisik (PDF)
                                </label>
                                <input type="file" name="file_surat" accept=".pdf"
                                       class="block w-full text-sm text-slate-300 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-white hover:file:bg-indigo-700 transition cursor-pointer border border-slate-700 rounded-xl bg-slate-950 p-2">
                            </div>

                        </div>

                        {{-- Action Buttons --}}
                        <div class="mt-8 flex flex-col sm:flex-row gap-3 pt-6 border-t border-slate-800">
                            <button type="submit"
                                    class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-indigo-600 hover:bg-indigo-700 rounded-xl text-white font-semibold transition cursor-pointer shadow-lg shadow-indigo-600/30">
                                <i class="fa-solid fa-floppy-disk"></i>
                                <span>Simpan Surat Masuk</span>
                            </button>

                            <button type="reset"
                                    class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl font-semibold transition border border-slate-700">
                                <i class="fa-solid fa-rotate-left"></i>
                                <span>Reset</span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN: REALTIME A4 LEMBAR AGENDA PREVIEW --}}
        <div class="lg:col-span-6 lg:sticky lg:top-20">
            <div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-2xl overflow-hidden">
                <div class="border-b border-slate-800 px-6 py-4 bg-slate-950/80 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-eye text-emerald-400"></i>
                        Preview Agenda Surat Masuk (A4)
                    </h2>
                    <button type="button" @click="downloadPreviewPdf()"
                            class="px-3 py-1.5 rounded-lg bg-emerald-600/20 text-emerald-400 hover:bg-emerald-600/30 border border-emerald-500/30 text-xs font-semibold flex items-center gap-1.5 transition">
                        <i class="fa-solid fa-download"></i>
                        <span>Unduh PDF</span>
                    </button>
                </div>

                {{-- A4 Container Scroll Area --}}
                <div class="p-6 bg-slate-950 max-h-[85vh] overflow-y-auto flex justify-center">
                    <div id="surat-masuk-preview-paper" class="a4-paper p-10 text-slate-900 relative text-sm sm:text-base">

                        {{-- Kop Surat Header --}}
                        <div class="mb-4 border-b-2 border-black pb-3">
                            <img src="{{ asset('image/kop-surat.png') }}" alt="Kop Surat" class="w-full h-auto block"
                                 onerror="this.style.display='none'; document.getElementById('kop-fallback-sm').style.display='block';">
                            <div id="kop-fallback-sm" style="display:none;" class="text-center font-bold text-lg border-b-2 border-black pb-2">
                                PT MICRODATA INDONESIA<br>
                                <span class="text-xs font-normal">Sistem Manajemen & Arsip Surat Masuk</span>
                            </div>
                        </div>

                        {{-- Judul Surat Masuk --}}
                        <div class="text-center my-4 border-b pb-2">
                            <h2 class="font-bold text-lg uppercase tracking-wider">LEMBAR AGENDA SURAT MASUK</h2>
                            <p class="text-xs text-slate-600">PT MICRODATA INDONESIA</p>
                        </div>

                        {{-- Status Badge --}}
                        <div class="flex justify-end mb-4">
                            <span class="px-3 py-1 text-xs font-bold uppercase rounded border border-black bg-slate-100" x-text="'Status: ' + status"></span>
                        </div>

                        {{-- Grid Info Table --}}
                        <table class="w-full text-xs sm:text-sm mb-6 border-collapse border border-slate-400">
                            <tr>
                                <td class="w-36 font-semibold bg-slate-100 p-2 border border-slate-400">Nomor Agenda</td>
                                <td class="p-2 border border-slate-400 font-mono font-bold" x-text="nomor_agenda"></td>
                            </tr>
                            <tr>
                                <td class="font-semibold bg-slate-100 p-2 border border-slate-400">Nomor Surat</td>
                                <td class="p-2 border border-slate-400" x-text="nomor_surat || '(Belum diisi)'"></td>
                            </tr>
                            <tr>
                                <td class="font-semibold bg-slate-100 p-2 border border-slate-400">Tanggal Surat</td>
                                <td class="p-2 border border-slate-400" x-text="formatTanggal(tanggal_surat)"></td>
                            </tr>
                            <tr>
                                <td class="font-semibold bg-slate-100 p-2 border border-slate-400">Tanggal Diterima</td>
                                <td class="p-2 border border-slate-400" x-text="formatTanggal(tanggal_terima)"></td>
                            </tr>
                            <tr>
                                <td class="font-semibold bg-slate-100 p-2 border border-slate-400">Asal Surat / Instansi</td>
                                <td class="p-2 border border-slate-400 font-bold" x-text="instansi_nama || '(Pilih Instansi)'"></td>
                            </tr>
                            <tr>
                                <td class="font-semibold bg-slate-100 p-2 border border-slate-400">Jenis Surat</td>
                                <td class="p-2 border border-slate-400" x-text="jenis_surat || '-'"></td>
                            </tr>
                            <tr>
                                <td class="font-semibold bg-slate-100 p-2 border border-slate-400">Perihal</td>
                                <td class="p-2 border border-slate-400 font-bold text-slate-900" x-text="perihal || '(Perihal)'"></td>
                            </tr>
                            <tr>
                                <td class="font-semibold bg-slate-100 p-2 border border-slate-400">Lampiran</td>
                                <td class="p-2 border border-slate-400" x-text="lampiran || '-'"></td>
                            </tr>
                        </table>

                        {{-- Ringkasan Isi Surat --}}
                        <div class="mb-4 text-xs sm:text-sm">
                            <p class="font-bold mb-1">Ringkasan Isi Surat:</p>
                            <div class="p-3 border border-slate-400 bg-slate-50 min-h-[90px] whitespace-pre-line text-justify"
                                 x-text="isi_ringkas || 'Ringkasan isi surat akan langsung muncul di sini secara realtime...'"></div>
                        </div>

                        {{-- Catatan Disposisi --}}
                        <div class="mb-6 text-xs sm:text-sm">
                            <p class="font-bold mb-1">Keterangan / Catatan Disposisi:</p>
                            <div class="p-3 border border-slate-400 bg-slate-50 min-h-[50px] whitespace-pre-line"
                                 x-text="keterangan || '-'"></div>
                        </div>

                        {{-- Tanda Tangan / Disposisi --}}
                        <div class="mt-8 text-xs sm:text-sm grid grid-cols-2 gap-6 text-center">
                            <div>
                                <p class="mb-12">Diterima & Dicatat Oleh,</p>
                                <p class="font-bold">( Petugas Agenda )</p>
                            </div>
                            <div>
                                <p class="mb-1">Bandar Lampung, <span x-text="formatTanggal(tanggal_terima)"></span></p>
                                <p class="mb-10">Disetujui / Mengetahui,</p>
                                <p class="font-bold">( Pimpinan / Kepala Divisi )</p>
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="mt-14 pt-3 border-t border-slate-300 text-center text-[10px] text-slate-500">
                            Dokumen ini dibuat melalui <strong>Sistem Arsip Surat PT Microdata Indonesia</strong>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
