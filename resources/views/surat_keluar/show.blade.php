@extends('layouts.app')

@section('title', 'Detail Surat Keluar')

@section('content')

<div class="container-fluid">

    <div class="card shadow border-0">

        <div class="card-header bg-info text-white">
            <h4 class="mb-0">
                <i class="bi bi-eye"></i>
                Detail Surat Keluar
            </h4>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nomor Surat</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $surat->nomor_surat }}"
                           readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tanggal Surat</label>
                    <input type="text"
                           class="form-control"
                           value="{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d-m-Y') }}"
                           readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Jenis Surat</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $surat->jenis_surat }}"
                           readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tujuan</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $surat->tujuan }}"
                           readonly>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Perihal</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $surat->perihal }}"
                           readonly>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Isi Surat</label>

                    <textarea class="form-control"
                              rows="8"
                              readonly>{{ $surat->isi_surat }}</textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Lampiran</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $surat->lampiran }}"
                           readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Status</label>

                    @if($surat->status == 'Draft')
                        <span class="badge bg-secondary fs-6">
                            Draft
                        </span>

                    @elseif($surat->status == 'Dikirim')
                        <span class="badge bg-warning text-dark fs-6">
                            Dikirim
                        </span>

                    @else
                        <span class="badge bg-success fs-6">
                            Selesai
                        </span>
                    @endif
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        Penandatangan
                    </label>

                    <input type="text"
                           class="form-control"
                           value="{{ $surat->penandatangan }}"
                           readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        Jabatan Penandatangan
                    </label>

                    <input type="text"
                           class="form-control"
                           value="{{ $surat->jabatan_penandatangan }}"
                           readonly>
                </div>

                <div class="col-md-12 mb-4">

                    <label class="form-label fw-bold">
                        File Surat
                    </label>

                    @if($surat->file_surat)

                        <br>

                        <a href="{{ asset('storage/surat_keluar/'.$surat->file_surat) }}"
                           target="_blank"
                           class="btn btn-danger">

                            <i class="bi bi-file-earmark-pdf"></i>

                            Lihat PDF

                        </a>

                    @else

                        <div class="alert alert-warning mb-0">
                            File surat belum diupload.
                        </div>

                    @endif

                </div>

            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('surat_keluar.index') }}"
                   class="btn btn-secondary">

                    <i class="bi bi-arrow-left"></i>

                    Kembali

                </a>

                <a href="{{ route('surat_keluar.edit', $surat->id) }}"
                   class="btn btn-warning">

                    <i class="bi bi-pencil-square"></i>

                    Edit

                </a>

                <a href="{{ route('surat_keluar.preview', $surat->id) }}"
                   class="btn btn-primary">

                    <i class="bi bi-file-earmark-text"></i>

                    Preview Surat

                </a>

            </div>

        </div>

    </div>

</div>

@endsection
