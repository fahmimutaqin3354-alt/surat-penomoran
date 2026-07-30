@extends('layouts.app')

@section('title', 'Laporan')

@section('content')

{{-- Style khusus untuk mengubah warna ikon kalender input tanggal menjadi putih --}}
<style>
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1) brightness(2) !important;
        cursor: pointer !important;
        opacity: 0.9 !important;
    }
</style>

<div class="max-w-7xl mx-auto">

    {{-- ======================= BREADCRUMB ======================= --}}
    <nav class="flex items-center gap-2 text-sm text-slate-400 mb-4">
        <a href="{{ route('laporan.index') }}" class="hover:text-white transition">Laporan</a>
        <span>/</span>
        <span class="text-white font-medium">Dashboard</span>
    </nav>

    {{-- ======================= HEADER + AKSI ======================= --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-white">Laporan</h1>
            <p class="text-slate-400 mt-1">Ringkasan dan laporan aktivitas persuratan</p>
        </div>

        <div class="flex items-center gap-3">
            <button type="button"
                onclick="alert('Fitur Ekspor Laporan belum tersedia.')"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-700 bg-slate-800 text-slate-200 text-sm font-semibold hover:bg-slate-700 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3" />
                </svg>
                Ekspor Laporan
            </button>

            <div class="relative" x-data="{ open: false }">
                <button type="button" @click="open = !open"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.32 0a42.32 42.32 0 00-11.32 0m11.32 0l1.005-1.116a1.125 1.125 0 00-.84-1.884H5.515a1.125 1.125 0 00-.84 1.884L5.68 18" />
                    </svg>
                    Cetak
                </button>
                <div x-show="open" @click.outside="open = false" x-cloak
                    class="absolute right-0 mt-2 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-xl z-20 py-1">
                    <a href="{{ route('laporan.export.pdf', request()->query()) }}"
                        class="block px-4 py-2.5 text-sm text-slate-200 hover:bg-slate-700/50 hover:text-white transition">
                        Cetak PDF
                    </a>
                    <a href="{{ route('laporan.export.excel', request()->query()) }}"
                        class="block px-4 py-2.5 text-sm text-slate-200 hover:bg-slate-700/50 hover:text-white transition">
                        Cetak Excel
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================= FILTER ======================= --}}
    <form method="GET" action="{{ route('laporan.index') }}"
        class="flex flex-wrap items-center gap-3 mb-6 bg-slate-900 border border-slate-800 p-4 rounded-2xl shadow-lg">

        <input type="date" name="dari" value="{{ request('dari', now()->startOfMonth()->format('Y-m-d')) }}"
            class="px-4 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-sm text-white focus:ring-2 focus:ring-indigo-500 outline-none">

        <span class="text-sm text-slate-400">s/d</span>

        <input type="date" name="sampai" value="{{ request('sampai', now()->endOfMonth()->format('Y-m-d')) }}"
            class="px-4 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-sm text-white focus:ring-2 focus:ring-indigo-500 outline-none">

        <select name="jenis" class="px-4 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-sm text-white focus:ring-2 focus:ring-indigo-500 outline-none">
            <option value="">Semua Jenis</option>
            <option value="masuk" @selected(request('jenis') === 'masuk')>Surat Masuk</option>
            <option value="keluar" @selected(request('jenis') === 'keluar')>Surat Keluar</option>
        </select>

        <select name="status" class="px-4 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-sm text-white focus:ring-2 focus:ring-indigo-500 outline-none">
            <option value="">Semua Status</option>
            <option value="selesai" @selected(request('status') === 'selesai')>Selesai</option>
            <option value="proses" @selected(request('status') === 'proses')>Dalam Proses</option>
            <option value="menunggu" @selected(request('status') === 'menunggu')>Menunggu</option>
        </select>

        <button type="submit"
            class="px-5 py-2.5 rounded-xl bg-slate-700 hover:bg-slate-600 text-white text-sm font-semibold transition">
            Filter
        </button>
    </form>

    {{-- ======================= STAT CARDS ======================= --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">

        @php
            $stats = [
                ['label' => 'Total Surat', 'value' => $totalSurat, 'color' => 'text-indigo-400'],
                ['label' => 'Surat Masuk', 'value' => $suratMasuk, 'color' => 'text-blue-400'],
                ['label' => 'Surat Keluar', 'value' => $suratKeluar, 'color' => 'text-emerald-400'],
                ['label' => 'Arsip', 'value' => $arsip, 'color' => 'text-purple-400'],
                ['label' => 'Disposisi', 'value' => $disposisi, 'color' => 'text-amber-400'],
            ];
        @endphp

        @foreach ($stats as $stat)
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-lg">
                <p class="text-sm font-medium text-slate-400 mb-2">{{ $stat['label'] }}</p>
                <p class="text-3xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- ======================= CHARTS ======================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

        {{-- Tren Surat (line chart) --}}
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-lg">
            <h3 class="text-base font-semibold text-white mb-4">Tren Surat</h3>
            <canvas id="chartTren" height="180"></canvas>
        </div>

        {{-- Surat Berdasarkan Jenis (donut) --}}
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-lg">
            <h3 class="text-base font-semibold text-white mb-4">Surat Berdasarkan Jenis</h3>
            <canvas id="chartJenis" height="180"></canvas>
        </div>

        {{-- Surat Berdasarkan Status (donut) --}}
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-lg">
            <h3 class="text-base font-semibold text-white mb-4">Surat Berdasarkan Status</h3>
            <canvas id="chartStatus" height="180"></canvas>
        </div>
    </div>

    {{-- ======================= FOOTER INFO ======================= --}}
    <p class="text-xs text-slate-500 flex items-center gap-1.5">
        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
        </svg>
        Data diperbarui pada {{ $updatedAt }}
    </p>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // Konfigurasi warna teks default Chart.js untuk tema gelap
        Chart.defaults.color = '#94a3b8'; // text-slate-400
        Chart.defaults.font.family = 'sans-serif';

        // 1. Line chart: Tren Surat
        new Chart(document.getElementById('chartTren'), {
            type: 'line',
            data: {
                labels: @json($labelTrenChart),
                datasets: [
                    {
                        label: 'Surat Masuk',
                        data: @json($dataTrenMasuk),
                        borderColor: '#6366f1', // Indigo
                        backgroundColor: '#6366f1',
                        tension: 0.35,
                        pointRadius: 3,
                    },
                    {
                        label: 'Surat Keluar',
                        data: @json($dataTrenKeluar),
                        borderColor: '#10b981', // Emerald
                        backgroundColor: '#10b981',
                        tension: 0.35,
                        pointRadius: 3,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'start',
                        labels: { boxWidth: 8, usePointStyle: true, color: '#cbd5e1' }
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgba(255, 255, 255, 0.05)' },
                        ticks: { color: '#94a3b8' }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(255, 255, 255, 0.05)' },
                        ticks: { color: '#94a3b8' }
                    }
                },
            },
        });

        // 2. Donut chart: Surat Berdasarkan Jenis
        new Chart(document.getElementById('chartJenis'), {
            type: 'doughnut',
            data: {
                labels: ['Surat Masuk', 'Surat Keluar', 'Disposisi'],
                datasets: [{
                    data: [{{ $suratMasuk }}, {{ $suratKeluar }}, {{ $disposisi }}],
                    backgroundColor: ['#6366f1', '#10b981', '#a855f7'],
                    borderWidth: 0,
                }],
            },
            options: {
                responsive: true,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { boxWidth: 8, usePointStyle: true, color: '#cbd5e1' }
                    }
                },
            },
        });

        // 3. Donut chart: Surat Berdasarkan Status
        new Chart(document.getElementById('chartStatus'), {
            type: 'doughnut',
            data: {
                labels: ['Selesai', 'Dalam Proses', 'Menunggu'],
                datasets: [{
                    data: [{{ $selesai }}, {{ $dalamProses }}, {{ $menunggu }}],
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                    borderWidth: 0,
                }],
            },
            options: {
                responsive: true,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { boxWidth: 8, usePointStyle: true, color: '#cbd5e1' }
                    }
                },
            },
        });
    });
</script>
@endpush