@extends('layouts.app')

@section('title', 'Edit Surat Keluar')

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
        nomor_surat: '{{ old('nomor_surat', $surat->nomor_surat) }}',
        jenis_surat: '{{ old('jenis_surat', $surat->jenis_surat) }}',
        kode_divisi: '{{ old('kode_divisi', $surat->kode_divisi ?? 'HRD') }}',
        instansi_id: '{{ old('instansi_id', $surat->instansi_id) }}',
        instansi_nama: '{{ $surat->instansi->nama_instansi ?? '' }}',
        tanggal_surat: '{{ old('tanggal_surat', $surat->tanggal_surat) }}',
        tujuan: '{{ old('tujuan', $surat->tujuan) }}',
        perihal: '{{ old('perihal', $surat->perihal) }}',
        isi_surat: '{{ old('isi_surat', $surat->isi_surat) }}',
        lampiran: '{{ old('lampiran', $surat->lampiran) }}',
        status: '{{ old('status', $surat->status) }}',
        penandatangan: '{{ old('penandatangan', $surat->penandatangan) }}',
        jabatan_penandatangan: '{{ old('jabatan_penandatangan', $surat->jabatan_penandatangan) }}',

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
            const element = document.getElementById('surat-keluar-preview-paper');
            const opt = {
                margin: [10, 10, 10, 10],
                filename: 'Surat_Keluar_Edit_Preview.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true, logging: false },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save();
        }
     }">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                <i class="fa-solid fa-pen-to-square text-amber-500"></i>
                Edit Surat Keluar
            </h1>
            <p class="text-slate-400 mt-1">
                Perbarui data surat keluar PT Microdata Indonesia. Preview di sebelah kanan ter-update secara <span class="text-amber-400 font-semibold">Real-time</span>.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('surat_keluar.index') }}"
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
                        <i class="fa-solid fa-pen-to-square text-amber-400"></i>
                        Form Edit Surat
                    </h2>
                    <span class="text-xs bg-amber-500/20 text-amber-300 px-3 py-1 rounded-full font-medium border border-amber-500/30">
                        Edit Mode
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

                    <form action="{{ route('surat_keluar.update', $surat->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                            {{-- Jenis Surat --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Jenis Surat <span class="text-rose-500">*</span>
                                </label>
                                <select name="jenis_surat" required x-model="jenis_surat"
                                        class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 outline-none">
                                    <option value="">-- Pilih Jenis Surat --</option>
                                    <option value="Surat Tugas">Surat Tugas</option>
                                    <option value="Surat Undangan">Surat Undangan</option>
                                    <option value="Surat Pemberitahuan">Surat Pemberitahuan</option>
                                    <option value="Surat Permohonan">Surat Permohonan</option>
                                </select>
                            </div>

                            {{-- Tanggal Surat --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Tanggal Surat <span class="text-rose-500">*</span>
                                </label>
                                <input type="date" name="tanggal_surat" required x-model="tanggal_surat"
                                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 outline-none">
                            </div>

                            {{-- Tujuan --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Tujuan <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="tujuan" required x-model="tujuan"
                                       placeholder="Masukkan tujuan surat"
                                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 outline-none">
                            </div>

                            {{-- Perihal --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Perihal <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="perihal" required x-model="perihal"
                                       placeholder="Masukkan perihal"
                                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 outline-none">
                            </div>

                            {{-- Isi Surat --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Isi Surat <span class="text-rose-500">*</span>
                                </label>
                                <textarea name="isi_surat" rows="7" required x-model="isi_surat"
                                          placeholder="Tulis isi surat..."
                                          class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 outline-none"></textarea>
                            </div>

                            {{-- Lampiran --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Lampiran
                                </label>
                                <input type="text" name="lampiran" x-model="lampiran"
                                       placeholder="Contoh: 1 Berkas"
                                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 outline-none">
                            </div>

                            {{-- Status --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Status <span class="text-rose-500">*</span>
                                </label>
                                <select name="status" required x-model="status"
                                        class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 outline-none">
                                    <option value="Draft">Draft</option>
                                    <option value="Dikirim">Dikirim</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                            </div>

                            {{-- Penandatangan --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Penandatangan <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="penandatangan" required x-model="penandatangan"
                                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 outline-none">
                            </div>

                            {{-- Jabatan Penandatangan --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Jabatan Penandatangan <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="jabatan_penandatangan" required x-model="jabatan_penandatangan"
                                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 outline-none">
                            </div>

                            {{-- File Surat (Optional PDF update) --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Upload File Surat (PDF)
                                </label>
                                <input type="file" name="file_surat" accept=".pdf"
                                       class="block w-full text-sm text-slate-300 file:mr-4 file:rounded-lg file:border-0 file:bg-amber-600 file:px-4 file:py-2 file:text-white hover:file:bg-amber-700 transition cursor-pointer border border-slate-700 rounded-xl bg-slate-950 p-2">
                                @if($surat->file_surat)
                                    <div class="mt-2 text-xs text-slate-400">
                                        File saat ini: <a href="{{ asset('storage/surat_keluar/'.$surat->file_surat) }}" target="_blank" class="text-amber-400 underline">{{ $surat->file_surat }}</a>
                                    </div>
                                @endif
                            </div>

                        </div>

                        {{-- Action buttons --}}
                        <div class="mt-8 flex flex-col sm:flex-row gap-3 pt-6 border-t border-slate-800">
                            <button type="submit"
                                    class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-amber-600 hover:bg-amber-700 rounded-xl text-white font-semibold transition cursor-pointer shadow-lg shadow-amber-600/30">
                                <i class="fa-solid fa-floppy-disk"></i>
                                <span>Update Surat</span>
                            </button>

                            <a href="{{ route('surat_keluar.index') }}"
                               class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl font-semibold transition border border-slate-700">
                                <i class="fa-solid fa-arrow-left"></i>
                                <span>Batal</span>
                            </a>
                        </div>

                    </form>
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN: REALTIME A4 LETTER PREVIEW --}}
        <div class="lg:col-span-6 lg:sticky lg:top-20">
            <div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-2xl overflow-hidden">
                <div class="border-b border-slate-800 px-6 py-4 bg-slate-950/80 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-eye text-emerald-400"></i>
                        Preview Surat Realtime (A4)
                    </h2>
                    <button type="button" @click="downloadPreviewPdf()"
                            class="px-3 py-1.5 rounded-lg bg-emerald-600/20 text-emerald-400 hover:bg-emerald-600/30 border border-emerald-500/30 text-xs font-semibold flex items-center gap-1.5 transition">
                        <i class="fa-solid fa-download"></i>
                        <span>Unduh PDF</span>
                    </button>
                </div>

                {{-- A4 Container Scroll Area --}}
                <div class="p-6 bg-slate-950 max-h-[85vh] overflow-y-auto flex justify-center">
                    <div id="surat-keluar-preview-paper" class="a4-paper p-10 text-slate-900 relative text-sm sm:text-base">

                        {{-- Kop Surat Header --}}
                        <div class="mb-6 border-b-2 border-black pb-3">
                            <img src="{{ asset('image/kop-surat.png') }}" alt="Kop Surat" class="w-full h-auto block"
                                 onerror="this.style.display='none'; document.getElementById('kop-fallback').style.display='block';">
                            <div id="kop-fallback" style="display:none;" class="text-center font-bold text-lg border-b-2 border-black pb-2">
                                PT MICRODATA INDONESIA<br>
                                <span class="text-xs font-normal">Jl. Utama No. 123, Bandar Lampung | Telp: (0721) 123456</span>
                            </div>
                        </div>

                        {{-- Judul Surat --}}
                        <div class="text-center my-4">
                            <h2 class="font-bold text-lg uppercase underline tracking-wider" x-text="jenis_surat ? jenis_surat.toUpperCase() : 'SURAT KELUAR'"></h2>
                        </div>

                        {{-- Tanggal Surat --}}
                        <div class="text-right my-4 text-sm font-medium">
                            Bandar Lampung, <span x-text="formatTanggal(tanggal_surat)"></span>
                        </div>

                        {{-- Table Info Surat --}}
                        <table class="w-full text-sm mb-6 border-collapse">
                            <tr>
                                <td class="w-28 align-top py-1">Nomor</td>
                                <td class="w-4 align-top py-1">:</td>
                                <td class="align-top py-1 font-mono font-semibold" x-text="nomor_surat"></td>
                            </tr>
                            <tr>
                                <td class="align-top py-1">Lampiran</td>
                                <td class="align-top py-1">:</td>
                                <td class="align-top py-1" x-text="lampiran || '-'"></td>
                            </tr>
                            <tr>
                                <td class="align-top py-1">Perihal</td>
                                <td class="align-top py-1">:</td>
                                <td class="align-top py-1 font-bold" x-text="perihal || '-' "></td>
                            </tr>
                        </table>

                        {{-- Tujuan Surat --}}
                        <div class="my-6 text-sm leading-relaxed">
                            <p>Kepada Yth.</p>
                            <p class="font-bold" x-text="tujuan || '(Tujuan Penerima)'"></p>
                            <p>Di Tempat</p>
                        </div>

                        {{-- Salam & Isi Surat --}}
                        <div class="my-6 text-sm leading-relaxed">
                            <p class="mb-4">Dengan hormat,</p>
                            <div class="text-justify whitespace-pre-line leading-relaxed min-h-[120px]"
                                 x-text="isi_surat || 'Isi surat...'"></div>
                        </div>

                        {{-- Penutup --}}
                        <div class="my-6 text-sm leading-relaxed">
                            <p>Demikian surat ini kami sampaikan. Atas perhatian dan kerja sama yang baik, kami mengucapkan terima kasih.</p>
                        </div>

                        {{-- Tanda Tangan --}}
                        <div class="mt-12 text-sm flex justify-end">
                            <div class="w-64 text-center">
                                <p>Hormat kami,</p>
                                <p class="font-semibold">PT Microdata Indonesia</p>

                                <div class="h-20 flex items-center justify-center text-slate-400 text-xs italic">
                                    ( Tanda Tangan & Stempel )
                                </div>

                                <p class="font-bold uppercase underline" x-text="penandatangan || 'NAMA PENANDATANGAN'"></p>
                                <p class="text-xs text-slate-700 font-medium" x-text="jabatan_penandatangan || 'Jabatan'"></p>
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="mt-16 pt-3 border-t border-slate-300 text-center text-[10px] text-slate-500">
                            Dokumen ini dibuat melalui <strong>Sistem Arsip Surat PT Microdata Indonesia</strong>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
