@extends('layouts.app')

@section('title','Detail Surat Masuk')

@section('content')

<div class="container-fluid">

<div class="card shadow-sm border-0">

<div class="card-header bg-success text-white">

<h4>Detail Surat Masuk</h4>

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>
<th width="220">Nomor Agenda</th>
<td>{{ $surat->nomor_agenda }}</td>
</tr>

<tr>
<th>Nomor Surat</th>
<td>{{ $surat->nomor_surat }}</td>
</tr>

<tr>
<th>Tanggal Surat</th>
<td>{{ $surat->tanggal_surat }}</td>
</tr>

<tr>
<th>Tanggal Terima</th>
<td>{{ $surat->tanggal_terima }}</td>
</tr>

<tr>
<th>Pengirim</th>
<td>{{ $surat->pengirim }}</td>
</tr>

<tr>
<th>Perihal</th>
<td>{{ $surat->perihal }}</td>
</tr>

<tr>
<th>Isi Ringkas</th>
<td>{{ $surat->isi_ringkas }}</td>
</tr>

<tr>
<th>Status</th>
<td>

<span class="badge bg-success">

{{ $surat->status }}

</span>

</td>

</tr>

<tr>

<th>File Surat</th>

<td>

@if($surat->file_surat)

<a href="{{ asset('storage/surat_masuk/'.$surat->file_surat) }}"
target="_blank"
class="btn btn-primary">

<i class="bi bi-file-earmark-pdf"></i>

Lihat PDF

</a>

@else

Tidak ada file

@endif

</td>

</tr>

</table>

<a href="{{ route('surat_masuk.index') }}"
class="btn btn-secondary">

Kembali

</a>

</div>

</div>

</div>

@endsection
