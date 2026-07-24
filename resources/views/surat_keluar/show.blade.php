@extends('layouts.app')

@section('title','Detail Surat Keluar')

@section('content')

<div class="container-fluid">

<div class="card shadow-sm border-0">

<div class="card-header bg-success text-white">

<h4>

Detail Surat Keluar

</h4>

</div>

<div class="card-body">

<table class="table">

<tr>

<th width="200">Nomor Surat</th>

<td>002/MI/VII/2026</td>

</tr>

<tr>

<th>Perihal</th>

<td>Undangan Rapat</td>

</tr>

<tr>

<th>Tujuan</th>

<td>PT ABC</td>

</tr>

<tr>

<th>Tanggal</th>

<td>24 Juli 2026</td>

</tr>

<tr>

<th>File</th>

<td>

<a href="#" class="btn btn-primary btn-sm">

Download PDF

</a>

</td>

</tr>

</table>

<a href="{{ route('surat_keluar.index') }}" class="btn btn-secondary">

Kembali

</a>

</div>

</div>

</div>

@endsection
