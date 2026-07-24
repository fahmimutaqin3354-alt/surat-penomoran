@extends('layouts.app')

@section('title','Tambah Surat Keluar')

@section('content')
<h4>Edit Surat Keluar</h4>

<div class="container-fluid">

<div class="card shadow-sm border-0">

<div class="card-header bg-primary text-white">

<h4 class="mb-0">

Tambah Surat Keluar

</h4>

</div>

<div class="card-body">

<form>

<div class="row">

<div class="col-md-6 mb-3">

<label>Nomor Surat</label>

<input type="text" class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Tanggal Surat</label>

<input type="date" class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Tujuan</label>

<input type="text" class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Perihal</label>

<input type="text" class="form-control">

</div>

<div class="col-md-12 mb-3">

<label>Isi Surat</label>

<textarea class="form-control" rows="5"></textarea>

</div>

<div class="col-md-12 mb-3">

<label>Upload File PDF</label>

<input type="file" class="form-control">

</div>

</div>

<button class="btn btn-primary">

<i class="bi bi-save"></i>

Simpan

</button>

<a href="{{ route('surat_keluar.index') }}" class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

@endsection
