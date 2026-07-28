@extends('layouts.app')

@section('title', 'Tambah Surat Keluar')

@section('content')

<div class="w-full px-4 py-6">

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

<div class="bg-blue-600 text-white rounded-t-xl px-6 py-4">
            <h4 class="text-lg font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Surat Keluar
            </h4>
        </div>

        <div class="p-6">

            @if ($errors->any())

                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-4">

                    <ul class="list-disc list-inside space-y-1">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form action="{{ route('surat_keluar.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">

                    <div class="md:col-span-2">

                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Urut</label>

                        <input
                            type="text"
                            id="nomor_urut"
                            class="w-full rounded-lg border border-gray-300 bg-gray-100 px-3 py-2 text-gray-600 cursor-not-allowed focus:outline-none"
                            value="01"
                            readonly>

                    </div>

                    <div class="md:col-span-4">

                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Surat</label>

                        <select
                            id="jenis_surat"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                            <option value="">Pilih Jenis</option>

                            <option value="permohonan-terbit-referensi">
                                Permohonan Terbit Referensi
                            </option>

                            <option value="surat-tugas">
                                Surat Tugas
                            </option>

                            <option value="undangan">
                                Undangan
                            </option>

                            <option value="pemberitahuan">
                                Pemberitahuan
                            </option>

                        </select>

                    </div>

                    <div class="md:col-span-2">

                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Divisi</label>

                        <select
                            id="divisi"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                            <option value="DIR-I">DIR-I</option>
                            <option value="DIR-II">DIR-II</option>
                            <option value="HRD">HRD</option>
                            <option value="IT">IT</option>

                        </select>

                    </div>

                    <div class="md:col-span-2">

                        <label class="block text-sm font-medium text-gray-700 mb-1">Perusahaan</label>

                        <input
                            type="text"
                            class="w-full rounded-lg border border-gray-300 bg-gray-100 px-3 py-2 text-gray-600 cursor-not-allowed focus:outline-none"
                            value="PT-MDI"
                            readonly>

                    </div>

                    <div class="md:col-span-2">

                        <label class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>

                        <input
                            type="text"
                            id="bulan"
                            class="w-full rounded-lg border border-gray-300 bg-gray-100 px-3 py-2 text-gray-600 cursor-not-allowed focus:outline-none"
                            readonly>

                    </div>

                    <div class="md:col-span-12">

                        <label class="block text-sm font-bold text-gray-800 mb-1">

                            Nomor Surat

                        </label>

                        <input
                            type="text"
                            name="nomor_surat"
                            id="nomor_surat"
                            class="w-full rounded-lg border border-gray-300 bg-gray-100 px-3 py-2 text-gray-700 font-medium cursor-not-allowed focus:outline-none"
                            readonly>

                    </div>

                    <div class="md:col-span-6">

                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Surat</label>

                        <input type="date"
                               name="tanggal_surat"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('tanggal_surat') }}"
                               required>

                    </div>

                    <div class="md:col-span-6">

                        <label class="block text-sm font-medium text-gray-700 mb-1">Tujuan</label>

                        <input type="text"
                               name="tujuan"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('tujuan') }}"
                               required>

                    </div>

                    <div class="md:col-span-6">

                        <label class="block text-sm font-medium text-gray-700 mb-1">Perihal</label>

                        <input type="text"
                               name="perihal"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('perihal') }}"
                               required>

                    </div>

                    <div class="md:col-span-12">

                        <label class="block text-sm font-medium text-gray-700 mb-1">Isi Surat</label>

                        <textarea
                            name="isi_surat"
                            rows="5"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('isi_surat') }}</textarea>

                    </div>

                    <div class="md:col-span-6">

                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>

                        <select name="status"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>

                            <option value="">-- Pilih Status --</option>

                            <option value="Draft">Draft</option>

                            <option value="Dikirim">Dikirim</option>

                            <option value="Selesai">Selesai</option>

                        </select>

                    </div>

                    <div class="md:col-span-6">

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Upload File (PDF)
                        </label>

                        <input type="file"
                               name="file_surat"
                               accept=".pdf"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-900 file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                    </div>

                </div>

                <div class="mt-6 flex items-center gap-3">

<button class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-white font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">

                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>

                        Simpan

                    </button>

                    <a href="{{ route('surat_keluar.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg bg-gray-200 px-4 py-2 text-gray-700 font-medium hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-colors">

                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

const romawi = [
    "",
    "I",
    "II",
    "III",
    "IV",
    "V",
    "VI",
    "VII",
    "VIII",
    "IX",
    "X",
    "XI",
    "XII"
];

document.getElementById('bulan').value =
romawi[new Date().getMonth()+1];

function generateNomor(){

    let urut=document.getElementById('nomor_urut').value;

    let jenis=document.getElementById('jenis_surat').value;

    let divisi=document.getElementById('divisi').value;

    let bulan=document.getElementById('bulan').value;

    let tahun=new Date().getFullYear();

    document.getElementById('nomor_surat').value=
    `${urut}/${jenis}/${divisi}/PT-MDI/${bulan}/${tahun}`;

}

document.getElementById('jenis_surat')
.addEventListener('change',generateNomor);

document.getElementById('divisi')
.addEventListener('change',generateNomor);

generateNomor();

</script>

@endpush