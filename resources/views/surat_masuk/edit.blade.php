@extends('layouts.app')

@section('title', 'Edit Surat Masuk')

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
        nomor_agenda: '{{ old('nomor_agenda', $surat->nomor_agenda) }}',
        nomor_surat: '{{ old('nomor_surat', $surat->nomor_surat) }}',
        tanggal_surat: '{{ old('tanggal_surat', $surat->tanggal_surat) }}',
        tanggal_terima: '{{ old('tanggal_terima', $surat->tanggal_terima) }}',
        instansi_id: '{{ old('instansi_id', $surat->instansi_id) }}',
        instansi_nama: '{{ old('asal_surat', $surat->asal_surat) }}',
        jenis_surat: '{{ old('jenis_surat', $surat->jenis_surat) }}',
        perihal: '{{ old('perihal', $surat->perihal) }}',
        isi_ringkas: '{{ old('isi_ringkas', $surat->isi_ringkas) }}',
        lampiran: '{{ old('lampiran', $surat->lampiran) }}',
        status: '{{ old('status', $surat->status) }}',
        keterangan: '{{ old('keterangan', $surat->keterangan) }}',
        nama_petugas: '{{ old('nama_petugas', $surat->nama_petugas ?? '') }}',
        jabatan_petugas: '{{ old('jabatan_petugas', $surat->jabatan_petugas ?? '') }}',
        nama_pimpinan: '{{ old('nama_pimpinan', $surat->nama_pimpinan ?? '') }}',
        jabatan_pimpinan: '{{ old('jabatan_pimpinan', $surat->jabatan_pimpinan ?? '') }}',

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
                filename: 'Surat_Masuk_Edit_Preview.pdf',
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
                Edit Surat Masuk
            </h1>
            <p class="text-slate-400 mt-1">
                Edit data surat masuk — preview A4 ter-update secara <span class="text-amber-400 font-semibold">real-time</span>.
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
                        <i class="fa-solid fa-pen-to-square text-amber-400"></i>
                        Form Edit Surat Masuk
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

                    <form id="form-surat-masuk" action="{{ route('surat_masuk.update', $surat->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

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
                                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 outline-none">
                            </div>

                            {{-- Tanggal Surat --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Tanggal Surat <span class="text-rose-500">*</span>
                                </label>
                                <input type="date" name="tanggal_surat" required x-model="tanggal_surat"
                                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 outline-none">
                            </div>

                            {{-- Tanggal Diterima --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Tanggal Diterima <span class="text-rose-500">*</span>
                                </label>
                                <input type="date" name="tanggal_terima" required x-model="tanggal_terima"
                                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 outline-none">
                            </div>

                            {{-- Asal Surat / Instansi --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Asal Surat / Instansi <span class="text-rose-500">*</span>
                                </label>
                                <select name="instansi_id" id="instansi_select" required x-model="instansi_id" @change="updateInstansiNama($event.target)"
                                        class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 outline-none">
                                    <option value="">-- Pilih Instansi --</option>
                                    @foreach($instansis as $instansi)
                                        <option value="{{ $instansi->id }}" {{ old('instansi_id', $surat->instansi_id) == $instansi->id ? 'selected' : '' }}>
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
                                        class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 outline-none">
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
                                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 outline-none">
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
                                    <option value="Baru">Baru</option>
                                    <option value="Diproses">Diproses</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                            </div>

                            {{-- Isi Ringkas --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Isi Ringkas
                                </label>
                                <textarea name="isi_ringkas" rows="4" x-model="isi_ringkas"
                                          placeholder="Masukkan ringkasan isi surat..."
                                          class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 outline-none"></textarea>
                            </div>

                            {{-- Keterangan --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Keterangan / Catatan Disposisi
                                </label>
                                <textarea name="keterangan" rows="3" x-model="keterangan"
                                          placeholder="Catatan atau keterangan tambahan..."
                                          class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 outline-none"></textarea>
                            </div>

                            {{-- Upload File --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Upload File Surat Fisik (PDF)
                                </label>
                                <input type="file" name="file_surat" accept=".pdf"
                                       class="block w-full text-sm text-slate-300 file:mr-4 file:rounded-lg file:border-0 file:bg-amber-600 file:px-4 file:py-2 file:text-white hover:file:bg-amber-700 transition cursor-pointer border border-slate-700 rounded-xl bg-slate-950 p-2">
                                @if($surat->file_surat)
                                    <div class="mt-2 text-xs text-slate-400">
                                        File saat ini: <a href="{{ asset('storage/surat_masuk/'.$surat->file_surat) }}" target="_blank" class="text-amber-400 underline">{{ $surat->file_surat }}</a>
                                    </div>
                                @endif
                            </div>

                        </div>

                        {{-- Action Buttons --}}
                        <div class="mt-8 flex flex-col sm:flex-row gap-3 pt-6 border-t border-slate-800">
                            <button type="submit"
                                    class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-amber-600 hover:bg-amber-700 rounded-xl text-white font-semibold transition cursor-pointer shadow-lg shadow-amber-600/30">
                                <i class="fa-solid fa-floppy-disk"></i>
                                <span>Update Surat Masuk</span>
                            </button>

                            <a href="{{ route('surat_masuk.index') }}"
                               class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl font-semibold transition border border-slate-700">
                                <i class="fa-solid fa-arrow-left"></i>
                                <span>Batal</span>
                            </a>
                        </div>

                    </form>
                </div>
            </div>

            {{-- Card Penandatangan --}}
            <div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-xl overflow-hidden">
                <div class="border-b border-slate-800 px-6 py-4 bg-slate-950/50 flex items-center gap-2">
                    <i class="fa-solid fa-signature text-amber-400"></i>
                    <h2 class="text-lg font-bold text-white">Penandatangan</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- Petugas Agenda --}}
                    <div class="space-y-3">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Petugas Agenda</p>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Nama Petugas</label>
                            <input type="text" name="nama_petugas" x-model="nama_petugas"
                                   placeholder="Nama lengkap petugas"
                                   form="form-surat-masuk"
                                   class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Jabatan</label>
                            <input type="text" name="jabatan_petugas" x-model="jabatan_petugas"
                                   placeholder="Jabatan petugas"
                                   form="form-surat-masuk"
                                   class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 outline-none">
                        </div>
                    </div>

                    {{-- Pimpinan / Kepala Divisi --}}
                    <div class="space-y-3">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pimpinan / Kepala Divisi</p>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Nama Pimpinan</label>
                            <input type="text" name="nama_pimpinan" x-model="nama_pimpinan"
                                   placeholder="Nama lengkap pimpinan"
                                   form="form-surat-masuk"
                                   class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Jabatan</label>
                            <input type="text" name="jabatan_pimpinan" x-model="jabatan_pimpinan"
                                   placeholder="Jabatan pimpinan"
                                   form="form-surat-masuk"
                                   class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-amber-500 outline-none">
                        </div>
                    </div>

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
                                <p class="invisible text-xs leading-normal">placeholder</p>
                                <p class="mb-10">Diterima &amp; Dicatat Oleh,</p>
                                <div class="min-h-[48px]"></div>
                                <p class="font-bold" x-text="nama_petugas || '( Petugas Agenda )'"></p>
                                <p class="text-slate-600" x-show="jabatan_petugas" x-text="jabatan_petugas"></p>
                            </div>
                            <div>
                                <p class="mb-1 text-xs leading-normal">Bandar Lampung, <span x-text="formatTanggal(tanggal_terima)"></span></p>
                                <p class="mb-10">Disetujui / Mengetahui,</p>
                                <div class="min-h-[48px]"></div>
                                <p class="font-bold" x-text="nama_pimpinan || '( Pimpinan / Kepala Divisi )'"></p>
                                <p class="text-slate-600" x-show="jabatan_pimpinan" x-text="jabatan_pimpinan"></p>
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
