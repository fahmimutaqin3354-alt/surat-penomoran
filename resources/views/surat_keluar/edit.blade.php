@extends('layouts.app')

@section('title', 'Edit Surat Keluar')

@section('content')

<div class="container-fluid">

    <div class="card shadow border-0">

        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">
                <i class="bi bi-pencil-square"></i>
                Edit Surat Keluar
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

            <form action="{{ route('surat_keluar.update', $surat->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Nomor Surat --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nomor Surat</label>

                        <input type="text"
                               class="form-control"
                               value="{{ $surat->nomor_surat }}"
                               readonly>
                    </div>

                    {{-- Jenis Surat --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jenis Surat</label>

                        <select name="jenis_surat"
                                class="form-select"
                                required>

                            <option value="">-- Pilih Jenis Surat --</option>

                            <option value="Surat Tugas"
                                {{ $surat->jenis_surat == 'Surat Tugas' ? 'selected' : '' }}>
                                Surat Tugas
                            </option>

                            <option value="Surat Undangan"
                                {{ $surat->jenis_surat == 'Surat Undangan' ? 'selected' : '' }}>
                                Surat Undangan
                            </option>

                            <option value="Surat Pemberitahuan"
                                {{ $surat->jenis_surat == 'Surat Pemberitahuan' ? 'selected' : '' }}>
                                Surat Pemberitahuan
                            </option>

                            <option value="Surat Permohonan"
                                {{ $surat->jenis_surat == 'Surat Permohonan' ? 'selected' : '' }}>
                                Surat Permohonan
                            </option>

                        </select>
                    </div>

                    {{-- Tanggal --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Surat</label>

                        <input type="date"
                               name="tanggal_surat"
                               class="form-control"
                               value="{{ old('tanggal_surat', $surat->tanggal_surat) }}"
                               required>
                    </div>

                    {{-- Tujuan --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tujuan</label>

                        <input type="text"
                               name="tujuan"
                               class="form-control"
                               value="{{ old('tujuan', $surat->tujuan) }}"
                               required>
                    </div>

                    {{-- Perihal --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Perihal</label>

                        <input type="text"
                               name="perihal"
                               class="form-control"
                               value="{{ old('perihal', $surat->perihal) }}"
                               required>
                    </div>

                    {{-- Isi Surat --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Isi Surat</label>

                        <textarea name="isi_surat"
                                  rows="6"
                                  class="form-control"
                                  required>{{ old('isi_surat', $surat->isi_surat) }}</textarea>
                    </div>

                    {{-- Lampiran --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lampiran</label>

                        <input type="text"
                               name="lampiran"
                               class="form-control"
                               value="{{ old('lampiran', $surat->lampiran) }}">
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>

                        <select name="status"
                                class="form-select"
                                required>

                            <option value="Draft"
                                {{ $surat->status == 'Draft' ? 'selected' : '' }}>
                                Draft
                            </option>

                            <option value="Dikirim"
                                {{ $surat->status == 'Dikirim' ? 'selected' : '' }}>
                                Dikirim
                            </option>

                            <option value="Selesai"
                                {{ $surat->status == 'Selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>

                        </select>
                    </div>

                    {{-- Penandatangan --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Penandatangan</label>

                        <input type="text"
                               name="penandatangan"
                               class="form-control"
                               value="{{ old('penandatangan', $surat->penandatangan) }}"
                               required>
                    </div>

                    {{-- Jabatan --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jabatan Penandatangan</label>

                        <input type="text"
                               name="jabatan_penandatangan"
                               class="form-control"
                               value="{{ old('jabatan_penandatangan', $surat->jabatan_penandatangan) }}"
                               required>
                    </div>

                    {{-- File Lama --}}
                    @if($surat->file_surat)
                    <div class="col-md-12 mb-3">
                        <label class="form-label">File Saat Ini</label>

                        <div>
                            <a href="{{ asset('storage/surat_keluar/'.$surat->file_surat) }}"
                               target="_blank"
                               class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-file-earmark-pdf"></i>
                                Lihat PDF
                            </a>
                        </div>
                    </div>
                    @endif

                    {{-- Upload Baru --}}
                    <div class="col-md-12 mb-4">
                        <label class="form-label">
                            Upload File Baru (Opsional)
                        </label>

                        <input type="file"
                               name="file_surat"
                               class="form-control"
                               accept=".pdf">
                    </div>

                </div>

                <div class="d-flex gap-2">

                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-save"></i>
                        Update
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
