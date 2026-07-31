@extends('layouts.app')

@section('title', 'Laporan')

@section('content')

{{-- Style khusus untuk Glassmorphism, Input Custom, & Icon Invert --}}
<style>
    /* Invert warna icon calendar bawaan HTML */
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1) brightness(2) !important;
        cursor: pointer !important;
        opacity: 0.8 !important;
    }

    /* Glassmorphism Panel Effect */
    .glass-card {
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.07);
    }
    .glass-card:hover {
        border-color: rgba(168, 85, 247, 0.25);
    }

    /* Glowing Gradient Button */
    .btn-gradient-glow {
        background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%);
        box-shadow: 0 0 15px rgba(168, 85, 247, 0.35);
    }
    .btn-gradient-glow:hover {
        box-shadow: 0 0 25px rgba(236, 72, 153, 0.55);
    }
</style>

<div class="max-w-7xl mx-auto space-y-6">

    {{-- ======================= BREADCRUMB ======================= --}}
    <nav class="flex items-center gap-2 text-xs font-medium text-slate-400">
        <a href="{{ route('laporan.index') }}" class="hover:text-purple-400 transition-colors">Laporan</a>
        <span class="text-slate-600">/</span>
        <span class="text-slate-200">Dashboard</span>
    </nav>

    {{-- ======================= HEADER + AKSI ======================= --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Laporan & Analitik</h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">Ringkasan dan laporan aktivitas persuratan terpadu.</p>
        </div>

        <div class="flex items-center gap-3">
            {{-- Tombol Ekspor --}}
            <button type="button"
                onclick="alert('Fitur Ekspor Laporan belum tersedia.')"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-white/10 bg-slate-900/60 text-slate-200 text-xs font-semibold hover:bg-slate-800/80 hover:border-purple-500/30 transition-all backdrop-blur-md">
                <svg class="w-4 h-4 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3" />
                </svg>
                Ekspor Laporan
            </button>

            {{-- Dropdown Cetak (Alpine.js) --}}
            <div class="relative" x-data="{ open: false }">
                <button type="button" @click="open = !open"
                    class="btn-gradient-glow inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-white text-xs font-bold transition-all transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.32 0a42.32 42.32 0 00-11.32 0m11.32 0l1.005-1.116a1.125 1.125 0 00-.84-1.884H5.515a1.125 1.125 0 00-.84 1.884L5.68 18" />
                    </svg>
                    Cetak
                </button>
                
                <div x-show="open" @click.outside="open = false" x-cloak
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="absolute right-0 mt-2 w-48 glass-card rounded-xl shadow-2xl z-30 py-1.5 border border-white/10">
                    <a href="{{ route('laporan.export.pdf', request()->query()) }}"
                        class="flex items-center gap-2 px-4 py-2 text-xs text-slate-200 hover:bg-purple-600/20 hover:text-purple-300 transition-all">
                        <svg class="w-4 h-4 text-red-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9v-2h2v2zm0-4H9V7h2v5z"/></svg>
                        Cetak PDF
                    </a>
                    <a href="{{ route('laporan.export.excel', request()->query()) }}"
                        class="flex items-center gap-2 px-4 py-2 text-xs text-slate-200 hover:bg-emerald-600/20 hover:text-emerald-300 transition-all">
                        <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                        Cetak Excel
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================= FILTER PANEL ======================= --}}
    <form method="GET" action="{{ route('laporan.index') }}"
        class="glass-card p-4 sm:p-5 rounded-2xl flex flex-wrap items-center gap-3">

        <div class="flex items-center gap-2 w-full sm:w-auto flex-1">
            <input type="date" name="dari" value="{{ request('dari', now()->startOfMonth()->format('Y-m-d')) }}"
                class="w-full px-3.5 py-2 bg-slate-950/60 border border-white/10 rounded-xl text-xs text-slate-100 focus:border-purple-500 outline-none transition">

            <span class="text-xs text-slate-400 font-medium">s/d</span>

            <input type="date" name="sampai" value="{{ request('sampai', now()->endOfMonth()->format('Y-m-d')) }}"
                class="w-full px-3.5 py-2 bg-slate-950/60 border border-white/10 rounded-xl text-xs text-slate-100 focus:border-purple-500 outline-none transition">
        </div>

        <select name="jenis" class="w-full sm:w-auto px-3.5 py-2 bg-slate-950/60 border border-white/10 rounded-xl text-xs text-slate-100 focus:border-purple-500 outline-none transition">
            <option value="" class="bg-slate-900">Semua Jenis</option>
            <option value="masuk" @selected(request('jenis') === 'masuk') class="bg-slate-900">Surat Masuk</option>
            <option value="keluar" @selected(request('jenis') === 'keluar') class="bg-slate-900">Surat Keluar</option>
        </select>

        <select name="status" class="w-full sm:w-auto px-3.5 py-2 bg-slate-950/60 border border-white/10 rounded-xl text-xs text-slate-100 focus:border-purple-500 outline-none transition">
            <option value="" class="bg-slate-900">Semua Status</option>
            <option value="selesai" @selected(request('status') === 'selesai') class="bg-slate-900">Selesai</option>
            <option value="proses" @selected(request('status') === 'proses') class="bg-slate-900">Dalam Proses</option>
            <option value="menunggu" @selected(request('status') === 'menunggu') class="bg-slate-900">Menunggu</option>
        </select>

        <button type="submit"
            class="w-full sm:w-auto px-5 py-2 rounded-xl bg-purple-600/30 hover:bg-purple-600/50 border border-purple-500/40 text-purple-200 text-xs font-bold transition-all">
            Filter Data
        </button>
    </form>

    {{-- ======================= STAT CARDS ======================= --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">

        @php
            $stats = [
                ['label' => 'Total Surat', 'value' => $totalSurat, 'color' => 'text-purple-400', 'bg' => 'bg-purple-500/10', 'border' => 'border-purple-500/20', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
                ['label' => 'Surat Masuk', 'value' => $suratMasuk, 'color' => 'text-blue-400', 'bg' => 'bg-blue-500/10', 'border' => 'border-blue-500/20', 'icon' => 'M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4'],
                ['label' => 'Surat Keluar', 'value' => $suratKeluar, 'color' => 'text-emerald-400', 'bg' => 'bg-emerald-500/10', 'border' => 'border-emerald-500/20', 'icon' => 'M12 19l9 2-9-18-9 18 9-2zm0 0v-8'],
                ['label' => 'Arsip', 'value' => $arsip, 'color' => 'text-pink-400', 'bg' => 'bg-pink-500/10', 'border' => 'border-pink-500/20', 'icon' => 'M5 8h14M5 8a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v1a2 2 0 01-2 2M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4'],
                ['label' => 'Disposisi', 'value' => $disposisi, 'color' => 'text-amber-400', 'bg' => 'bg-amber-500/10', 'border' => 'border-amber-500/20', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
            ];
        @endphp

        @foreach ($stats as $stat)
            <div class="glass-card p-5 rounded-2xl relative overflow-hidden group">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-semibold text-slate-400">{{ $stat['label'] }}</span>
                    <div class="w-8 h-8 rounded-lg {{ $stat['bg'] }} border {{ $stat['border'] }} {{ $stat['color'] }} flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-extrabold {{ $stat['color'] }} tracking-tight">{{ $stat['value'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- ======================= CHARTS ======================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- Tren Surat (line chart) --}}
        <div class="lg:col-span-6 glass-card p-5 rounded-2xl flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-white tracking-wide">Tren Surat</h3>
                <span class="text-[10px] px-2.5 py-0.5 rounded-full bg-purple-500/10 border border-purple-500/20 text-purple-300">Grafik Harian</span>
            </div>
            <div class="relative h-56 w-full">
                <canvas id="chartTren"></canvas>
            </div>
        </div>

        {{-- Surat Berdasarkan Jenis (donut) --}}
        <div class="lg:col-span-3 glass-card p-5 rounded-2xl flex flex-col justify-between">
            <h3 class="text-sm font-bold text-white tracking-wide mb-2">Berdasarkan Jenis</h3>
            <div class="relative h-48 w-full flex items-center justify-center">
                <canvas id="chartJenis"></canvas>
            </div>
        </div>

        {{-- Surat Berdasarkan Status (donut) --}}
        <div class="lg:col-span-3 glass-card p-5 rounded-2xl flex flex-col justify-between">
            <h3 class="text-sm font-bold text-white tracking-wide mb-2">Berdasarkan Status</h3>
            <div class="relative h-48 w-full flex items-center justify-center">
                <canvas id="chartStatus"></canvas>
            </div>
        </div>
    </div>

    {{-- ======================= FOOTER INFO ======================= --}}
    <div class="pt-2 border-t border-white/5 flex items-center justify-between text-xs text-slate-500">
        <span class="flex items-center gap-1.5">
            <svg class="w-4 h-4 text-purple-400 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
            </svg>
            Data diperbarui pada {{ $updatedAt }}
        </span>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // Konfigurasi Chart.js Tema Dark Modern
        Chart.defaults.color = '#94a3b8';
        Chart.defaults.font.family = 'Plus Jakarta Sans, sans-serif';

        // 1. Line chart: Tren Surat
        new Chart(document.getElementById('chartTren'), {
            type: 'line',
            data: {
                labels: @json($labelTrenChart),
                datasets: [
                    {
                        label: 'Surat Masuk',
                        data: @json($dataTrenMasuk),
                        borderColor: '#818cf8', // Soft Indigo
                        backgroundColor: 'rgba(129, 140, 248, 0.15)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Surat Keluar',
                        data: @json($dataTrenKeluar),
                        borderColor: '#34d399', // Soft Emerald
                        backgroundColor: 'rgba(52, 211, 153, 0.15)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: { boxWidth: 8, usePointStyle: true, color: '#cbd5e1' }
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgba(255, 255, 255, 0.04)' },
                        ticks: { color: '#94a3b8' }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(255, 255, 255, 0.04)' },
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
                    backgroundColor: ['#818cf8', '#34d399', '#c084fc'],
                    borderWidth: 0,
                    hoverOffset: 4
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 8, usePointStyle: true, color: '#cbd5e1', padding: 12 }
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
                    backgroundColor: ['#34d399', '#fbbf24', '#f87171'],
                    borderWidth: 0,
                    hoverOffset: 4
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 8, usePointStyle: true, color: '#cbd5e1', padding: 12 }
                    }
                },
            },
        });
    });
</script>
@endpush