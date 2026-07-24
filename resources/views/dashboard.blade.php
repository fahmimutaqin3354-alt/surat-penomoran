@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="row mb-4">

        <div class="col-md-8">

            <h2 class="fw-bold">
                Dashboard
            </h2>

            <p class="text-muted">
                Selamat datang,
                <strong>{{ Auth::user()->name }}</strong>
                di Sistem Arsip Surat PT Microdata Indonesia.
            </p>

        </div>

        <div class="col-md-4 text-end">

            <span class="badge bg-success fs-6">
                {{ now()->format('d M Y') }}
            </span>

        </div>

    </div>

    <!-- Statistik -->
    <div class="row g-4">

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Surat Masuk
                            </small>

                            <h2 class="fw-bold mt-2">
                                120
                            </h2>

                        </div>

                        <div class="text-primary">

                            <i class="bi bi-envelope-arrow-down fs-1"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Surat Keluar
                            </small>

                            <h2 class="fw-bold mt-2">
                                80
                            </h2>

                        </div>

                        <div class="text-success">

                            <i class="bi bi-envelope-arrow-up fs-1"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Arsip Surat
                            </small>

                            <h2 class="fw-bold mt-2">
                                230
                            </h2>

                        </div>

                        <div class="text-warning">

                            <i class="bi bi-folder-fill fs-1"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Pengguna
                            </small>

                            <h2 class="fw-bold mt-2">
                                5
                            </h2>

                        </div>

                        <div class="text-danger">

                            <i class="bi bi-people-fill fs-1"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Grafik & Aktivitas -->

    <div class="row mt-5">

        <div class="col-lg-8">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Grafik Surat
                    </h5>

                </div>

                <div class="card-body">

                    <canvas id="suratChart" height="100"></canvas>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Aktivitas Hari Ini

                    </h5>

                </div>

                <div class="card-body">

                    <ul class="list-group list-group-flush">

                        <li class="list-group-item">

                            📥 Surat masuk ditambahkan

                        </li>

                        <li class="list-group-item">

                            📤 Surat keluar dibuat

                        </li>

                        <li class="list-group-item">

                            🗂 Arsip diperbarui

                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

    <!-- Surat Terbaru -->

    <div class="card mt-5 shadow-sm border-0">

        <div class="card-header bg-white">

            <h5 class="mb-0">

                Surat Terbaru

            </h5>

        </div>

        <div class="card-body">

            <table class="table table-hover">

                <thead>

                <tr>

                    <th>No</th>

                    <th>Nomor Surat</th>

                    <th>Perihal</th>

                    <th>Tanggal</th>

                    <th>Status</th>

                </tr>

                </thead>

                <tbody>

                <tr>

                    <td>1</td>

                    <td>001/MI/VII/2026</td>

                    <td>Surat Undangan</td>

                    <td>24 Juli 2026</td>

                    <td>

                        <span class="badge bg-success">

                            Selesai

                        </span>

                    </td>

                </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx=document.getElementById('suratChart');

new Chart(ctx,{

type:'bar',

data:{

labels:['Jan','Feb','Mar','Apr','Mei','Jun'],

datasets:[{

label:'Jumlah Surat',

data:[12,19,10,17,20,15]

}]

},

options:{

responsive:true,

plugins:{

legend:{

display:false

}

}

}

});

</script>

@endpush
