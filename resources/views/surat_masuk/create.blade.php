@extends('layouts.app')

@section('title','Tambah Surat Masuk')

@section('content')

<div class="container-fluid">

<div class="card shadow-sm border-0">

<div class="card-header bg-primary text-white">

<h4><i class="bi bi-plus-circle"></i> Tambah Surat Masuk</h4>

</div>

<div class="card-body">

<form action="{{ route('surat_masuk.store') }}" method="POST" enctype="multipart/form-data">

@csrf

<div class="row">

<div class="col-md-6 mb-3">

    <label class="form-label">
        Nomor Agenda
    </label>

    <input
        type="text"
        name="nomor_agenda"
        class="form-control"
        value="{{ $nomorAgenda }}"
        readonly>

</div>

<div class="col-md-6 mb-3">
<label>Nomor Surat</label>
<input type="text" name="nomor_surat" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Tanggal Surat</label>
<input type="date" name="tanggal_surat" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Tanggal Terima</label>
<input type="date" name="tanggal_terima" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Pengirim</label>
<input type="text" name="pengirim" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Perihal</label>
<input type="text" name="perihal" class="form-control" required>
</div>

<div class="col-md-12 mb-3">
<label>Isi Ringkas</label>
<textarea name="isi_ringkas" rows="5" class="form-control"></textarea>
</div>

<div class="col-md-6 mb-3">
<label>Status</label>

<select name="status" class="form-select">

<option value="Baru">Baru</option>

<option value="Diproses">Diproses</option>

<option value="Selesai">Selesai</option>

</select>

</div>

<div class="col-md-6 mb-3">
<label>Upload PDF</label>
<input type="file" name="file_surat" class="form-control">
</div>

</div>

<button class="btn btn-primary">
<i class="bi bi-save"></i>
Simpan
</button>

<a href="{{ route('surat_masuk.index') }}" class="btn btn-secondary">
Kembali
</a>

</form>

</div>

</div>

</div>

@endsection
