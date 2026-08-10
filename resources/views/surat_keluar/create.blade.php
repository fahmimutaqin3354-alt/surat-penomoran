@extends('layouts.app')

@section('title', 'Tambah Surat Keluar')

@section('content')

{{-- Style khusus untuk mengubah warna ikon kalender menjadi putih cerah --}}
<style>
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1) brightness(2) !important;
        cursor: pointer !important;
        opacity: 0.9 !important;
    }
    [x-cloak] { display: none !important; }
</style>

<div class="max-w-7xl mx-auto">

@if(session('surat_tersimpan'))
    @php($suratBaru = session('surat_tersimpan'))
 
    <div class="mb-6 bg-emerald-500/10 border border-emerald-500/30 rounded-2xl p-5 flex flex-wrap items-center justify-between gap-4">
 
        <div>
            <p class="text-emerald-400 font-semibold flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i>
                Surat berhasil disimpan
            </p>
            <p class="text-sm text-slate-400 mt-1">
                Nomor Surat: <span class="text-slate-200 font-medium">{{ $suratBaru->nomor_surat }}</span>
                — silakan ekspor surat ini kalau diperlukan.
            </p>
        </div>
 
        {{-- ============ DROPDOWN EKSPOR (Email / WhatsApp) ============ --}}
        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
            <button type="button" @click="open = !open"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 focus:outline-none transition">
                <i class="fa-solid fa-share-nodes"></i>
                Ekspor Surat
                <i class="fa-solid fa-chevron-down text-xs opacity-70"></i>
            </button>
 
            <div x-show="open" x-cloak
                class="absolute right-0 mt-2 w-52 bg-slate-900 border border-slate-800 rounded-xl shadow-lg z-20 overflow-hidden py-1">
 
                <a href="{{ route('surat_keluar.pdf', $suratBaru->id) }}"
                    class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-300 hover:bg-slate-800">
                    <i class="fa-solid fa-file-pdf text-slate-500 w-4"></i>
                    Unduh PDF
                </a>
 
                <div class="my-1 border-t border-slate-800"></div>
 
                <button type="button" @click="$dispatch('open-modal-email-surat'); open = false"
                    class="flex items-center gap-2 w-full text-left px-4 py-2.5 text-sm text-slate-300 hover:bg-slate-800">
                    <i class="fa-solid fa-envelope text-slate-500 w-4"></i>
                    Kirim ke Email
                </button>
                <button type="button" @click="$dispatch('open-modal-wa-surat'); open = false"
                    class="flex items-center gap-2 w-full text-left px-4 py-2.5 text-sm text-slate-300 hover:bg-slate-800">
                    <i class="fa-brands fa-whatsapp text-slate-500 w-4"></i>
                    Kirim ke WhatsApp
                </button>
            </div>
        </div>
 
    </div>
@endif

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
                enctype="multipart/form-data"
                x-data="suratKeluarForm()"
                x-init="initForm()">

                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Jenis Surat + Tombol Tambah --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Jenis Surat
                        </label>

                        <div class="flex gap-2">
                            <select
                                name="jenis_surat"
                                id="jenis_surat"
                                x-model="jenisSurat"
                                required
                                class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">

                                <option value="">-- Pilih Jenis Surat --</option>

                                @foreach($jenisSuratList as $jenis)
                                    <option value="{{ $jenis->nama }}"
                                        data-kode="{{ $jenis->kode_surat }}"
                                        data-form="{{ $jenis->form_type }}"
                                        {{ old('jenis_surat') == $jenis->nama ? 'selected' : '' }}>
                                        {{ $jenis->nama }} ({{ $jenis->kode_surat }})
                                    </option>
                                @endforeach

                            </select>

                            <button type="button"
                                @click="$dispatch('open-modal-jenis-surat')"
                                title="Tambah Jenis Surat Baru"
                                class="shrink-0 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold transition">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Kode Surat --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Kode Surat
                        </label>

                        <input
                            type="text"
                            name="kode_surat"
                            id="kode_surat"
                            x-model="kodeSurat"
                            placeholder="Contoh : SK"
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">

                        <p class="text-xs text-slate-500 mt-1">
                            Kode ini otomatis terisi dari jenis surat dan dipakai saat generate nomor surat.
                        </p>
                    </div>

                    {{-- Kode Divisi --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Kode Divisi
                        </label>

                        <select
                            name="kode_divisi"
                            required
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">

                            <option value="">-- Pilih Divisi --</option>
                            <option value="DIR-I" {{ old('kode_divisi') == 'DIR-I' ? 'selected' : '' }}>Direktur I</option>
                            <option value="DIR-II" {{ old('kode_divisi') == 'DIR-II' ? 'selected' : '' }}>Direktur II</option>
                            <option value="HRD" {{ old('kode_divisi') == 'HRD' ? 'selected' : '' }}>HRD</option>
                            <option value="IT" {{ old('kode_divisi') == 'IT' ? 'selected' : '' }}>IT</option>
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

                    {{-- ============================================================
                         FORM UMUM
                    ============================================================ --}}
                    <template x-if="isKuasa">
                        <div class="md:col-span-2"></div>
                    </template>

                    <template x-if="!isKuasa">
                        <div class="md:col-span-2">
                            <div class="border border-slate-800 rounded-2xl p-5 bg-slate-950/50">
                                <h3 class="text-sm font-semibold text-slate-300 mb-4 flex items-center gap-2">
                                    <i class="fa-solid fa-file-lines text-indigo-500"></i>
                                    Data Surat Umum
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- Tujuan --}}
                                    <div>
                                        <label class="block text-sm font-medium text-slate-300 mb-2">
                                            Tujuan
                                        </label>

                                        <input
                                            type="text"
                                            name="tujuan"
                                            value="{{ old('tujuan') }}"
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
                                            value="{{ old('perihal') }}"
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
                                            placeholder="Tulis isi surat..."
                                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">{{ old('isi_surat') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- ============================================================
                         FORM KHUSUS SURAT KUASA
                    ============================================================ --}}
                    <template x-if="isKuasa">
                        <div class="md:col-span-2">
                            <div class="border border-indigo-500/30 rounded-2xl p-5 bg-indigo-500/5">
                                <h3 class="text-sm font-semibold text-indigo-300 mb-4 flex items-center gap-2">
                                    <i class="fa-solid fa-file-signature text-indigo-400"></i>
                                    Form Surat Kuasa
                                </h3>

                                {{-- Pemberi Kuasa --}}
                                <div class="mb-6">
                                    <h4 class="text-sm font-semibold text-slate-300 mb-3 flex items-center gap-2">
                                        <i class="fa-solid fa-user text-slate-500"></i>
                                        Pemberi Kuasa
                                    </h4>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-slate-400 mb-1">Nama Lengkap</label>
                                            <input type="text"
                                                name="data_khusus[pemberi][nama]"
                                                x-model="dataKhusus.pemberi.nama"
                                                placeholder="Nama pemberi kuasa"
                                                class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-400 mb-1">Alamat</label>
                                            <input type="text"
                                                name="data_khusus[pemberi][alamat]"
                                                x-model="dataKhusus.pemberi.alamat"
                                                placeholder="Alamat lengkap"
                                                class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-400 mb-1">No. KTP</label>
                                            <input type="text"
                                                name="data_khusus[pemberi][ktp]"
                                                x-model="dataKhusus.pemberi.ktp"
                                                placeholder="Nomor KTP"
                                                class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 outline-none">
                                        </div>
                                    </div>
                                </div>

                                {{-- Penerima Kuasa --}}
                                <div class="mb-6">
                                    <h4 class="text-sm font-semibold text-slate-300 mb-3 flex items-center gap-2">
                                        <i class="fa-solid fa-user-tie text-slate-500"></i>
                                        Penerima Kuasa
                                    </h4>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-slate-400 mb-1">Nama Lengkap</label>
                                            <input type="text"
                                                name="data_khusus[penerima][nama]"
                                                x-model="dataKhusus.penerima.nama"
                                                placeholder="Nama penerima kuasa"
                                                class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-400 mb-1">Alamat</label>
                                            <input type="text"
                                                name="data_khusus[penerima][alamat]"
                                                x-model="dataKhusus.penerima.alamat"
                                                placeholder="Alamat lengkap"
                                                class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-400 mb-1">No. KTP</label>
                                            <input type="text"
                                                name="data_khusus[penerima][ktp]"
                                                x-model="dataKhusus.penerima.ktp"
                                                placeholder="Nomor KTP"
                                                class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 outline-none">
                                        </div>
                                    </div>
                                </div>

                                {{-- Hal yang dikuasakan --}}
                                <div>
                                    <label class="block text-sm font-medium text-slate-400 mb-1">
                                        Hal yang Dikuasakan
                                    </label>
                                    <textarea
                                        name="data_khusus[hal]"
                                        x-model="dataKhusus.hal"
                                        rows="4"
                                        placeholder="Contoh: Mewakili saya untuk mengurus dan menandatangani dokumen terkait ..."
                                        class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 outline-none"></textarea>
                                </div>
                            </div>
                        </div>
                    </template>

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

{{-- ============================================================
     MODAL TAMBAH JENIS SURAT
============================================================ --}}
<div x-data="modalJenisSurat()"
    @open-modal-jenis-surat.window="show = true; nama=''; kode=''; formType='umum'; msg=''"
    x-show="show" x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <div class="absolute inset-0 bg-black/60" @click="show = false"></div>

    <div class="relative bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-md p-6">
        <h3 class="text-base font-semibold text-white mb-1">Tambah Jenis Surat</h3>
        <p class="text-sm text-slate-400 mb-4">
            Jenis surat baru akan langsung tersedia di dropdown.
        </p>

        <form @submit.prevent="simpanJenis()">
            <label class="block text-sm font-medium text-slate-300 mb-1">Nama Jenis Surat</label>
            <input type="text" x-model="nama" required placeholder="Contoh : Surat Edaran"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 mb-4">

            <label class="block text-sm font-medium text-slate-300 mb-1">Kode Surat</label>
            <input type="text" x-model="kode" required placeholder="Contoh : SE" maxlength="10"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 mb-4">

            <label class="block text-sm font-medium text-slate-300 mb-1">Tipe Form</label>
            <select x-model="formType"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 mb-4">
                <option value="umum">Umum (Tujuan, Perihal, Isi Surat)</option>
                <option value="kuasa">Khusus (Surat Kuasa)</option>
            </select>

            <p x-show="msg" x-cloak class="text-sm text-emerald-400 mb-4" x-text="msg"></p>

            <div class="flex justify-end gap-2 mt-2">
                <button type="button" @click="show = false"
                    class="px-4 py-2 rounded-xl text-sm text-slate-400 hover:bg-slate-800 transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 transition"
                    x-text="loading ? 'Menyimpan...' : 'Simpan'"
                    :disabled="loading">
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function suratKeluarForm() {
    return {
        jenisSurat: '{{ old('jenis_surat') }}',
        kodeSurat: '',
        dataKhusus: {
            pemberi: { nama: '', alamat: '', ktp: '' },
            penerima: { nama: '', alamat: '', ktp: '' },
            hal: ''
        },
        isKuasa: false,

        getJenisOptions() {
            return document.querySelectorAll('#jenis_surat option');
        },

        onJenisChange() {
            const opt = this.getJenisOptions();
            let found = null;
            opt.forEach(o => {
                if (o.value === this.jenisSurat) {
                    found = o;
                }
            });

            if (found) {
                this.kodeSurat = found.dataset.kode || '';
                this.isKuasa = (found.dataset.form === 'kuasa');
            } else {
                this.kodeSurat = '';
                this.isKuasa = false;
            }
        },

        initForm() {
            this.$watch('jenisSurat', () => this.onJenisChange());
            this.onJenisChange();
        }
    };
}

// Handler modal tambah jenis surat (dipanggil dari komponen modal)
document.addEventListener('alpine:init', () => {
    Alpine.data('modalJenisSurat', () => ({
        show: false,
        nama: '',
        kode: '',
        formType: 'umum',
        loading: false,
        msg: '',
        simpanJenis() {
            this.loading = true;
            this.msg = '';

            fetch('{{ route('jenis_surat.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    nama: this.nama,
                    kode_surat: this.kode,
                    form_type: this.formType
                })
            })
            .then(r => r.json())
            .then(data => {
                this.loading = false;
                if (data.success) {
                    this.msg = data.message;
                    // Tambahkan option ke dropdown
                    const sel = document.getElementById('jenis_surat');
                    const opt = document.createElement('option');
                    opt.value = data.data.nama;
                    opt.dataset.kode = data.data.kode_surat;
                    opt.dataset.form = data.data.form_type;
                    opt.textContent = data.data.nama + ' (' + data.data.kode_surat + ')';
                    sel.appendChild(opt);
                    sel.value = data.data.nama;
                    sel.dispatchEvent(new Event('change'));
                    setTimeout(() => { this.show = false; }, 800);
                } else {
                    this.msg = 'Gagal menyimpan. Periksa kembali data.';
                }
            })
            .catch(() => {
                this.loading = false;
                this.msg = 'Terjadi kesalahan. Coba lagi.';
            });
        }
    }));
});
</script>

@if(session('surat_tersimpan'))
    @php($suratBaru = session('surat_tersimpan'))
 
    {{-- Modal: Kirim ke Email --}}
    <div x-data="{ show: false }"
        @open-modal-email-surat.window="show = true"
        x-show="show" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4">
 
        <div class="absolute inset-0 bg-black/60" @click="show = false"></div>
 
        <div class="relative bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-sm p-6">
            <h3 class="text-base font-semibold text-white mb-1">Kirim Surat ke Email</h3>
            <p class="text-sm text-slate-400 mb-4">
                 Masukkan alamat email tujuan, surat ini akan langsung dikirim beserta lampiran PDF-nya.
            </p>
 
           <form action="{{ route('surat_keluar.send.email', $suratBaru->id) }}" method="POST">
    @csrf

    <label class="block text-sm font-medium text-slate-300 mb-1">Alamat Email</label>
    <input type="email" name="email" required placeholder="nama@contoh.com"
        class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 mb-4">

    <p class="text-xs text-slate-500 mb-4">
        <i class="fa-solid fa-paperclip mr-1"></i>
        File PDF surat ini akan otomatis dilampirkan ke email tujuan.
         <a href="{{ URL::temporarySignedRoute('surat_keluar.download.public', now()->addHours(24), ['id' => $suratBaru->id]) }}"
       target="_blank"
       class="text-indigo-400 hover:text-indigo-300 underline font-medium">
        Lihat file PDF
    </a>
    </p>

    <div class="flex justify-end gap-2 mt-2">
        <button type="button" @click="show = false"
            class="px-4 py-2 rounded-xl text-sm text-slate-400 hover:bg-slate-800 transition">
            Batal
        </button>
        <button type="submit"
            class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition">
            Kirim
        </button>
    </div>
</form>
        </div>
    </div>
 
 {{-- Modal: Kirim ke WhatsApp --}}
<div x-data="{ show: false }"
    @open-modal-wa-surat.window="show = true"
    x-show="show" x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <div class="absolute inset-0 bg-black/60" @click="show = false"></div>

    <div class="relative bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-sm p-6">
        <h3 class="text-base font-semibold text-white mb-1">Kirim Surat ke WhatsApp</h3>
        <p class="text-sm text-slate-400 mb-4">
            Surat akan langsung dikirim otomatis beserta file PDF-nya.
        </p>

        <form action="{{ route('surat_keluar.send.whatsapp', $suratBaru->id) }}" method="POST">
            @csrf

            <label class="block text-sm font-medium text-slate-300 mb-1">Nomor WhatsApp</label>
            <input type="text" name="nomor_wa" required placeholder="08xxxxxxxxxx"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 mb-4">

            <div class="flex justify-end gap-2">
                <button type="button" @click="show = false"
                    class="px-4 py-2 rounded-xl text-sm text-slate-400 hover:bg-slate-800 transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 transition">
                    Kirim
                </button>
            </div>
        </form>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
// Pastikan modal tambah jenis surat terinisialisasi
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi handler event untuk modal (Alpine sudah handle via @click)
});
</script>
@endpush

