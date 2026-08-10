@extends('layouts.app')

@section('title', 'Edit Surat Keluar')

@section('content')

<style>
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1) brightness(2) !important;
        cursor: pointer !important;
        opacity: 0.9 !important;
    }
    [x-cloak] { display: none !important; }
</style>

<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-3xl font-bold text-white">
                Edit Surat Keluar
            </h1>
            <p class="text-slate-400 mt-1">
                Perbarui data surat keluar PT Microdata Indonesia.
            </p>
        </div>

        <a href="{{ route('surat_keluar.index') }}"
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
                Form Edit Surat Keluar
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

            @php
                $dataKhusus = $surat->data_khusus ?? [];
                $pemberi = $dataKhusus['pemberi'] ?? ['nama' => '', 'alamat' => '', 'ktp' => ''];
                $penerima = $dataKhusus['penerima'] ?? ['nama' => '', 'alamat' => '', 'ktp' => ''];
                $hal = $dataKhusus['hal'] ?? '';
            @endphp

            <form
                action="{{ route('surat_keluar.update', $surat->id) }}"
                method="POST"
                enctype="multipart/form-data"
                x-data="suratKeluarEditForm()"
                x-init="initForm()">

                @csrf
                @method('PUT')

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
                                class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none">

                                <option value="">-- Pilih Jenis Surat --</option>

                                @foreach($jenisSuratList as $jenis)
                                    <option value="{{ $jenis->nama }}"
                                        data-kode="{{ $jenis->kode_surat }}"
                                        data-form="{{ $jenis->form_type }}"
                                        {{ old('jenis_surat', $surat->jenis_surat) == $jenis->nama ? 'selected' : '' }}>
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
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none">

                        <p class="text-xs text-slate-500 mt-1">
                            Kode ini otomatis terisi dari jenis surat.
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
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none">

                            <option value="">-- Pilih Divisi --</option>
                            <option value="DIR-I" {{ old('kode_divisi', $surat->kode_divisi) == 'DIR-I' ? 'selected' : '' }}>Direktur I</option>
                            <option value="DIR-II" {{ old('kode_divisi', $surat->kode_divisi) == 'DIR-II' ? 'selected' : '' }}>Direktur II</option>
                            <option value="HRD" {{ old('kode_divisi', $surat->kode_divisi) == 'HRD' ? 'selected' : '' }}>HRD</option>
                            <option value="IT" {{ old('kode_divisi', $surat->kode_divisi) == 'IT' ? 'selected' : '' }}>IT</option>
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
                            value="{{ old('tanggal_surat', $surat->tanggal_surat) }}"
                            required
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none">
                    </div>

                    {{-- FORM UMUM --}}
                    <template x-if="isKuasa">
                        <div class="md:col-span-2"></div>
                    </template>

                    <template x-if="!isKuasa">
                        <div class="md:col-span-2">
                            <div class="border border-slate-800 rounded-2xl p-5 bg-slate-950/50">
                                <h3 class="text-sm font-semibold text-slate-300 mb-4 flex items-center gap-2">
                                    <i class="fa-solid fa-file-lines text-yellow-500"></i>
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
                                            value="{{ old('tujuan', $surat->tujuan) }}"
                                            placeholder="Masukkan tujuan surat"
                                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none">
                                    </div>

                                    {{-- Perihal --}}
                                    <div>
                                        <label class="block text-sm font-medium text-slate-300 mb-2">
                                            Perihal
                                        </label>
                                        <input
                                            type="text"
                                            name="perihal"
                                            value="{{ old('perihal', $surat->perihal) }}"
                                            placeholder="Masukkan perihal surat"
                                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none">
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
                                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none">{{ old('isi_surat', $surat->isi_surat) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- FORM KHUSUS SURAT KUASA --}}
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
                                                class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-400 mb-1">Alamat</label>
                                            <input type="text"
                                                name="data_khusus[pemberi][alamat]"
                                                x-model="dataKhusus.pemberi.alamat"
                                                placeholder="Alamat lengkap"
                                                class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-400 mb-1">No. KTP</label>
                                            <input type="text"
                                                name="data_khusus[pemberi][ktp]"
                                                x-model="dataKhusus.pemberi.ktp"
                                                placeholder="Nomor KTP"
                                                class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500 outline-none">
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
                                                class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-400 mb-1">Alamat</label>
                                            <input type="text"
                                                name="data_khusus[penerima][alamat]"
                                                x-model="dataKhusus.penerima.alamat"
                                                placeholder="Alamat lengkap"
                                                class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-400 mb-1">No. KTP</label>
                                            <input type="text"
                                                name="data_khusus[penerima][ktp]"
                                                x-model="dataKhusus.penerima.ktp"
                                                placeholder="Nomor KTP"
                                                class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500 outline-none">
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
                                        placeholder="Contoh: Mewakili saya untuk mengurus dokumen..."
                                        class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500 outline-none"></textarea>
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
                            value="{{ old('lampiran', $surat->lampiran) }}"
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
                            <option value="Draft" {{ old('status', $surat->status) == 'Draft' ? 'selected' : '' }}>Draft</option>
                            <option value="Dikirim" {{ old('status', $surat->status) == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="Selesai" {{ old('status', $surat->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
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
                            value="{{ old('penandatangan', $surat->penandatangan) }}"
                            required
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none">
                    </div>

                    {{-- Jabatan Penandatangan --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Jabatan Penandatangan
                        </label>
                        <input
                            type="text"
                            name="jabatan_penandatangan"
                            value="{{ old('jabatan_penandatangan', $surat->jabatan_penandatangan) }}"
                            required
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none">
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
                            class="block w-full text-sm text-slate-300 file:mr-4 file:rounded-lg file:border-0 file:bg-yellow-500 file:px-4 file:py-2 file:text-white hover:file:bg-yellow-600">

                        @if($surat->file_surat)
                            <div class="mt-4 rounded-xl bg-slate-800 border border-slate-700 p-4">
                                <p class="text-slate-300 mb-2">File saat ini:</p>
                                <a
                                    href="{{ asset('storage/'.$surat->file_surat) }}"
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

{{-- Modal Tambah Jenis Surat --}}
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
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 mb-4">

            <label class="block text-sm font-medium text-slate-300 mb-1">Kode Surat</label>
            <input type="text" x-model="kode" required placeholder="Contoh : SE" maxlength="10"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 mb-4">

            <label class="block text-sm font-medium text-slate-300 mb-1">Tipe Form</label>
            <select x-model="formType"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 mb-4">
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
function suratKeluarEditForm() {
    return {
        jenisSurat: '{{ old('jenis_surat', $surat->jenis_surat) }}',
        kodeSurat: '{{ old('kode_surat', $surat->kode_surat) }}',
        dataKhusus: {
            pemberi: {
                nama: '{{ old('data_khusus.pemberi.nama', $pemberi['nama'] ?? '') }}',
                alamat: '{{ old('data_khusus.pemberi.alamat', $pemberi['alamat'] ?? '') }}',
                ktp: '{{ old('data_khusus.pemberi.ktp', $pemberi['ktp'] ?? '') }}'
            },
            penerima: {
                nama: '{{ old('data_khusus.penerima.nama', $penerima['nama'] ?? '') }}',
                alamat: '{{ old('data_khusus.penerima.alamat', $penerima['alamat'] ?? '') }}',
                ktp: '{{ old('data_khusus.penerima.ktp', $penerima['ktp'] ?? '') }}'
            },
            hal: '{{ old('data_khusus.hal', $hal ?? '') }}'
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
                if (!this.kodeSurat) {
                    this.kodeSurat = found.dataset.kode || '';
                }
                this.isKuasa = (found.dataset.form === 'kuasa');
            } else {
                this.isKuasa = false;
            }
        },

        initForm() {
            this.$watch('jenisSurat', () => this.onJenisChange());
            this.onJenisChange();
        }
    };
}

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
@endsection
