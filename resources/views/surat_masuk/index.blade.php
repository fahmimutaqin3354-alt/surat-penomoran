@extends('layouts.app')

@section('title','Surat Masuk')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between mb-4">

<div>

<h2 class="fw-bold">

Surat Masuk

</h2>

<p class="text-muted">

Kelola seluruh surat masuk perusahaan.

</p>

</div>

<a href="{{ route('surat_masuk.create') }}"
class="btn btn-primary">

<i class="bi bi-plus-circle"></i>

Tambah Surat

</a>

</div>

<div class="card shadow-sm border-0">

<div class="card-body">

<table class="table table-bordered table-hover">

<thead class="table-primary">

<tr>

<th>No</th>

<th>No Agenda</th>

<th>No Surat</th>

<th>Pengirim</th>

<th>Perihal</th>

<th>Tanggal Terima</th>

<th>Status</th>

<th>Aksi</th>

</tr>

</thead>

<tbody>

@forelse($surat as $item)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $item->nomor_agenda }}</td>

<td>{{ $item->nomor_surat }}</td>

<td>{{ $item->pengirim }}</td>

<td>{{ $item->perihal }}</td>

<td>{{ $item->tanggal_terima }}</td>

<td>

<span class="badge bg-success">

{{ $item->status }}

</span>

</td>

<td>

<a href="{{ route('surat_masuk.show',$item->id) }}"
class="btn btn-info btn-sm">

<i class="bi bi-eye"></i>

</a>

<a href="{{ route('surat_masuk.edit',$item->id) }}"
class="btn btn-warning btn-sm">

<i class="bi bi-pencil"></i>

</a>

</td>

</tr>

@empty

<tr>

<td colspan="8" class="text-center">

Belum ada data surat masuk.

</td>

</tr>

@endforelse

</tbody>

</table>

{{ $surat->links() }}

</div>

</div>

</div>

@endsection
