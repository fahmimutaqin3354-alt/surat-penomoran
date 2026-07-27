@extends('layouts.app')

@section('title', 'Tambah Surat Keluar')

@section('content')

<div class="container-fluid">

    <div class="card shadow border-0">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="bi bi-envelope-plus"></i>
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

                    {{-- Jenis Surat --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jenis Surat</label>

                        <select
                            name="jenis_surat"
                            class="form-select"
                            required>

                            <option value="">-- Pilih Jenis Surat --</option>

                            <option value="Surat Tugas"
                                {{ old('jenis_surat') == 'Surat Tugas' ? 'selected' : '' }}>
                                Surat Tugas
                            </option>

                            <option value="Surat Undangan"
                                {{ old('jenis_surat') == 'Surat Undangan' ? 'selected' : '' }}>
                                Surat Undangan
                            </option>

                            <option value="Surat Pemberitahuan"
                                {{ old('jenis_surat') == 'Surat Pemberitahuan' ? 'selected' : '' }}>
                                Surat Pemberitahuan
                            </option>

                            <option value="Surat Permohonan"
                                {{ old('jenis_surat') == 'Surat Permohonan' ? 'selected' : '' }}>
                                Surat Permohonan
                            </option>

                        </select>
                    </div>

                    {{-- Tanggal --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Surat</label>

                        <input
                            type="date"
                            name="tanggal_surat"
                            class="form-control"
                            value="{{ old('tanggal_surat') }}"
                            required>
                    </div>

                    {{-- Tujuan --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tujuan</label>

                        <input
                            type="text"
                            name="tujuan"
                            class="form-control"
                            value="{{ old('tujuan') }}"
                            required>
                    </div>

                    {{-- Perihal --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Perihal</label>

                        <input
                            type="text"
                            name="perihal"
                            class="form-control"
                            value="{{ old('perihal') }}"
                            required>
                    </div>

                    {{-- Isi Surat --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Isi Surat</label>

                        <textarea
                            name="isi_surat"
                            rows="6"
                            class="form-control"
                            required>{{ old('isi_surat') }}</textarea>
                    </div>

                    {{-- Lampiran --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lampiran</label>

                        <input
                            type="text"
                            name="lampiran"
                            class="form-control"
                            value="{{ old('lampiran') }}"
                            placeholder="Contoh: 1 Berkas">
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>

                        <select
                            name="status"
                            class="form-select"
                            required>

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
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Penandatangan</label>

                        <input
                            type="text"
                            name="penandatangan"
                            class="form-control"
                            value="{{ old('penandatangan') }}"
                            required>
                    </div>

                    {{-- Jabatan --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jabatan Penandatangan</label>

                        <input
                            type="text"
                            name="jabatan_penandatangan"
                            class="form-control"
                            value="{{ old('jabatan_penandatangan') }}"
                            required>
                    </div>

                    {{-- Upload PDF --}}
                    <div class="col-md-12 mb-4">
                        <label class="form-label">
                            Upload File Surat (PDF)
                        </label>

                        <input
                            type="file"
                            name="file_surat"
                            class="form-control"
                            accept=".pdf">
                    </div>

                </div>

                <div class="d-flex gap-2">

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i>
                        Simpan
                    </button>

                    <a href="{{ route('surat_keluar.index') }}"
                       class="btn btn-secondary">

                        <i class="bi bi-arrow-left"></i>
                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
