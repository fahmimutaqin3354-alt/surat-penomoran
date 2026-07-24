@extends('layouts.app')

@section('title','Edit Surat Masuk')

@section('content')

<div class="container-fluid">

<div class="card shadow-sm border-0">

<div class="card-header bg-warning">

<h4>Edit Surat Masuk</h4>

</div>

<div class="card-body">

<form action="{{ route('surat_masuk.update',$surat->id) }}"
method="POST"
enctype="multipart/form-data">

@csrf
@method('PUT')

<div class="row">

<div class="col-md-6 mb-3">
<label>Nomor Agenda</label>
<input type="text" name="nomor_agenda" class="form-control"
value="{{ $surat->nomor_agenda }}">
</div>

<div class="col-md-6 mb-3">
<label>Nomor Surat</label>
<input type="text" name="nomor_surat" class="form-control"
value="{{ $surat->nomor_surat }}">
</div>

<div class="col-md-6 mb-3">
<label>Tanggal Surat</label>
<input type="date" name="tanggal_surat" class="form-control"
value="{{ $surat->tanggal_surat }}">
</div>

<div class="col-md-6 mb-3">
<label>Tanggal Terima</label>
<input type="date" name="tanggal_terima" class="form-control"
value="{{ $surat->tanggal_terima }}">
</div>

<div class="col-md-6 mb-3">
<label>Pengirim</label>
<input type="text" name="pengirim" class="form-control"
value="{{ $surat->pengirim }}">
</div>

<div class="col-md-6 mb-3">
<label>Perihal</label>
<input type="text" name="perihal" class="form-control"
value="{{ $surat->perihal }}">
</div>

<div class="col-md-12 mb-3">
<label>Isi Ringkas</label>

<textarea name="isi_ringkas" rows="5"
class="form-control">{{ $surat->isi_ringkas }}</textarea>

</div>

<div class="col-md-6 mb-3">

<label>Status</label>

<select name="status" class="form-select">

<option {{ $surat->status=='Baru'?'selected':'' }}>Baru</option>

<option {{ $surat->status=='Diproses'?'selected':'' }}>Diproses</option>

<option {{ $surat->status=='Selesai'?'selected':'' }}>Selesai</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Upload PDF Baru</label>

<input type="file"
name="file_surat"
class="form-control">

</div>

</div>

<button class="btn btn-warning">
Update
</button>

<a href="{{ route('surat_masuk.index') }}"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

@endsection
