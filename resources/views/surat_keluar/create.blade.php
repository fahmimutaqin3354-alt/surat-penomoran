@extends('layouts.app')

@section('title', 'Tambah Surat Keluar')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="bi bi-plus-circle"></i>
                Tambah Surat Keluar
            </h4>
        </div>

        <div class="card-body">

            @if ($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

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

                <div class="row">

                    <div class="col-md-2 mb-3">

    <label class="form-label">Nomor Urut</label>

    <input
        type="text"
        id="nomor_urut"
        class="form-control"
        value="01"
        readonly>

</div>

<div class="col-md-4 mb-3">

    <label class="form-label">Jenis Surat</label>

    <select
        id="jenis_surat"
        class="form-select">

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

<div class="col-md-2 mb-3">

    <label class="form-label">Kode Divisi</label>

    <select
        id="divisi"
        class="form-select">

        <option value="DIR-I">DIR-I</option>
        <option value="DIR-II">DIR-II</option>
        <option value="HRD">HRD</option>
        <option value="IT">IT</option>

    </select>

</div>

<div class="col-md-2 mb-3">

    <label class="form-label">Perusahaan</label>

    <input
        type="text"
        class="form-control"
        value="PT-MDI"
        readonly>

</div>

<div class="col-md-2 mb-3">

    <label class="form-label">Bulan</label>

    <input
        type="text"
        id="bulan"
        class="form-control"
        readonly>

</div>

<div class="col-md-12 mb-3">

    <label class="form-label fw-bold">

        Nomor Surat

    </label>

    <input
        type="text"
        name="nomor_surat"
        id="nomor_surat"
        class="form-control"
        readonly>

</div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">Tanggal Surat</label>

                        <input type="date"
                               name="tanggal_surat"
                               class="form-control"
                               value="{{ old('tanggal_surat') }}"
                               required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">Tujuan</label>

                        <input type="text"
                               name="tujuan"
                               class="form-control"
                               value="{{ old('tujuan') }}"
                               required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">Perihal</label>

                        <input type="text"
                               name="perihal"
                               class="form-control"
                               value="{{ old('perihal') }}"
                               required>

                    </div>

                    <div class="col-md-12 mb-3">

                        <label class="form-label">Isi Surat</label>

                        <textarea
                            name="isi_surat"
                            rows="5"
                            class="form-control">{{ old('isi_surat') }}</textarea>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">Status</label>

                        <select name="status"
                                class="form-select"
                                required>

                            <option value="">-- Pilih Status --</option>

                            <option value="Draft">Draft</option>

                            <option value="Dikirim">Dikirim</option>

                            <option value="Selesai">Selesai</option>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Upload File (PDF)
                        </label>

                        <input type="file"
                               name="file_surat"
                               class="form-control"
                               accept=".pdf">

                    </div>

                </div>

                <button class="btn btn-primary">

                    <i class="bi bi-save"></i>

                    Simpan

                </button>

                <a href="{{ route('surat_keluar.index') }}"
                   class="btn btn-secondary">

                    Kembali

                </a>

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
