{{--
    resources/views/laporan/index.blade.php

    Halaman ini HANYA berisi konten utama (bukan sidebar).
    Sidebar "Persuratan" diasumsikan sudah ada di layouts/app.blade.php,
    jadi halaman ini tinggal @extends layout itu dan isi @section('content').

    Kalau kamu belum punya layouts/app.blade.php, beri tahu saya,
    nanti saya bantu buatkan juga.
--}}
@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="p-6 bg-slate-50 min-h-screen">

    {{-- ======================= BREADCRUMB ======================= --}}
    <nav class="flex items-center gap-2 text-sm text-slate-500 mb-4">
        <a href="{{ route('laporan.index') }}" class="hover:text-slate-700">Laporan</a>
        <span>/</span>
        <span class="text-slate-700 font-medium">Dashboard</span>
    </nav>

    {{-- ======================= HEADER + AKSI ======================= --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">Laporan</h1>
            <p class="text-sm text-slate-500 mt-1">Ringkasan dan laporan aktivitas persuratan</p>
        </div>

        <div class="flex items-center gap-3">
            <button type="button"
                onclick="alert('Fitur Ekspor Laporan belum tersedia.')"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-300 bg-white text-slate-700 text-sm font-medium hover:bg-slate-50 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3" />
                </svg>
                Ekspor Laporan
            </button>

            <div class="relative" x-data="{ open: false }">
                <button type="button" @click="open = !open"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.32 0a42.32 42.32 0 00-11.32 0m11.32 0l1.005-1.116a1.125 1.125 0 00-.84-1.884H5.515a1.125 1.125 0 00-.84 1.884L5.68 18" />
                    </svg>
                    Cetak
                </button>
                <div x-show="open" @click.outside="open = false" x-cloak
                    class="absolute right-0 mt-2 w-40 bg-white border border-slate-200 rounded-lg shadow-lg z-10">
                   <a href="{{ route('laporan.export.pdf', request()->query()) }}"
    class="block w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
    Cetak PDF
</a>
<a href="{{ route('laporan.export.excel', request()->query()) }}"
    class="block w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
    Cetak Excel
</a>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================= FILTER ======================= --}}
    <form method="GET" action="{{ route('laporan.index') }}"
        class="flex flex-wrap items-center gap-3 mb-6">

        <input type="date" name="dari" value="{{ request('dari', now()->startOfMonth()->format('Y-m-d')) }}"
            class="px-3 py-2 border border-slate-300 rounded-lg text-sm text-slate-600 focus:ring-2 focus:ring-blue-500 focus:outline-none">

        <span class="text-sm text-slate-500">s/d</span>

        <input type="date" name="sampai" value="{{ request('sampai', now()->endOfMonth()->format('Y-m-d')) }}"
            class="px-3 py-2 border border-slate-300 rounded-lg text-sm text-slate-600 focus:ring-2 focus:ring-blue-500 focus:outline-none">

        <select name="jenis" class="px-3 py-2 border border-slate-300 rounded-lg text-sm text-slate-600 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <option value="">Semua Jenis</option>
            <option value="masuk" @selected(request('jenis') === 'masuk')>Surat Masuk</option>
            <option value="keluar" @selected(request('jenis') === 'keluar')>Surat Keluar</option>
        </select>

        <select name="status" class="px-3 py-2 border border-slate-300 rounded-lg text-sm text-slate-600 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <option value="">Semua Status</option>
            <option value="selesai" @selected(request('status') === 'selesai')>Selesai</option>
            <option value="proses" @selected(request('status') === 'proses')>Dalam Proses</option>
            <option value="menunggu" @selected(request('status') === 'menunggu')>Menunggu</option>
        </select>

        <button type="submit"
            class="px-4 py-2 rounded-lg bg-slate-800 text-white text-sm font-medium hover:bg-slate-900 transition">
            Filter
        </button>
    </form>

    {{-- ======================= STAT CARDS ======================= --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">

        @php
            // Semua nilai di bawah ini datang dari LaporanController (data asli).
            // "delta" (perbandingan dengan periode sebelumnya) belum dihitung
            // Controller-nya, jadi baris itu untuk sekarang tidak ditampilkan
            // supaya tidak mengarang angka.
            $stats = [
                ['label' => 'Total Surat', 'value' => $totalSurat, 'color' => 'text-blue-600'],
                ['label' => 'Surat Masuk', 'value' => $suratMasuk, 'color' => 'text-blue-600'],
                ['label' => 'Surat Keluar', 'value' => $suratKeluar, 'color' => 'text-green-600'],
                ['label' => 'Arsip', 'value' => $arsip, 'color' => 'text-purple-600'],
                ['label' => 'Disposisi', 'value' => $disposisi, 'color' => 'text-orange-600'],
            ];
        @endphp

        @foreach ($stats as $stat)
            <div class="bg-white border border-slate-200 rounded-xl p-4">
                <p class="text-sm text-slate-500 mb-2">{{ $stat['label'] }}</p>
                <p class="text-2xl font-semibold text-slate-800">{{ $stat['value'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- ======================= CHARTS ======================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">

        {{-- Tren Surat (line chart) --}}
        <div class="bg-white border border-slate-200 rounded-xl p-4 lg:col-span-1">
            <p class="text-sm font-medium text-slate-700 mb-3">Tren Surat</p>
            <canvas id="chartTren" height="180"></canvas>
        </div>

        {{-- Surat Berdasarkan Jenis (donut) --}}
        <div class="bg-white border border-slate-200 rounded-xl p-4">
            <p class="text-sm font-medium text-slate-700 mb-3">Surat Berdasarkan Jenis</p>
            <canvas id="chartJenis" height="180"></canvas>
        </div>

        {{-- Surat Berdasarkan Status (donut) --}}
        <div class="bg-white border border-slate-200 rounded-xl p-4">
            <p class="text-sm font-medium text-slate-700 mb-3">Surat Berdasarkan Status</p>
            <canvas id="chartStatus" height="180"></canvas>
        </div>
    </div>

    {{-- ======================= FOOTER INFO ======================= --}}
    <p class="text-xs text-slate-400 flex items-center gap-1">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
        </svg>
        Data diperbarui pada {{ $updatedAt }}
    </p>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
   // Data dummy — nanti ganti dengan data asli dari Controller,
//    {{-- misal di-passing lewat @json($dataTren) dsb.  --}}
    document.addEventListener('DOMContentLoaded', function () {

        // 1. Line chart: Tren Surat — data asli dari LaporanController
        new Chart(document.getElementById('chartTren'), {
            type: 'line',
            data: {
                labels: @json($labelTrenChart),
                datasets: [
                    {
                        label: 'Surat Masuk',
                        data: @json($dataTrenMasuk),
                        borderColor: '#2563eb',
                        backgroundColor: '#2563eb',
                        tension: 0.35,
                        pointRadius: 3,
                    },
                    {
                        label: 'Surat Keluar',
                        data: @json($dataTrenKeluar),
                        borderColor: '#22c55e',
                        backgroundColor: '#22c55e',
                        tension: 0.35,
                        pointRadius: 3,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top', align: 'start', labels: { boxWidth: 8, usePointStyle: true } } },
                scales: { y: { beginAtZero: true } },
            },
        });

        // 2. Donut chart: Surat Berdasarkan Jenis
        new Chart(document.getElementById('chartJenis'), {
            type: 'doughnut',
            data: {
                labels: ['Surat Masuk', 'Surat Keluar', 'Disposisi'],
                datasets: [{
                    data: [{{ $suratMasuk }}, {{ $suratKeluar }}, {{ $disposisi }}],
                    backgroundColor: ['#2563eb', '#22c55e', '#8b5cf6'],
                    borderWidth: 0,
                }],
            },
            options: {
                responsive: true,
                cutout: '65%',
                plugins: { legend: { position: 'right', labels: { boxWidth: 8, usePointStyle: true } } },
            },
        });

        // 3. Donut chart: Surat Berdasarkan Status
        new Chart(document.getElementById('chartStatus'), {
            type: 'doughnut',
            data: {
                labels: ['Selesai', 'Dalam Proses', 'Menunggu'],
                datasets: [{
                    data: [{{ $selesai }}, {{ $dalamProses }}, {{ $menunggu }}],
                    backgroundColor: ['#22c55e', '#f59e0b', '#ef4444'],
                    borderWidth: 0,
                }],
            },
            options: {
                responsive: true,
                cutout: '65%',
                plugins: { legend: { position: 'right', labels: { boxWidth: 8, usePointStyle: true } } },
            },
        });
    });
</script>
@endpush