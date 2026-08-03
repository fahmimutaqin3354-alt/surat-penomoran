@extends('layouts.app')

@section('title', 'Dashboard Utama')

@section('content')
<div class="space-y-8">

    <!-- Header & Welcome Banner -->
    <div class="relative overflow-hidden flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-xl shadow-xl">
        <!-- Subtle Glow Background -->
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="space-y-3 relative z-10">
            <div class="flex items-center gap-3 flex-wrap">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-semibold uppercase tracking-wider">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>Overview</span>
                </span>
            </div>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                Dashboard Utama
            </h1>
            <p class="text-slate-400 text-sm">
                Selamat datang kembali, <strong class="text-indigo-400 font-semibold">{{ Auth::user()->name ?? 'Pengguna' }}</strong>! Berikut adalah ringkasan sistem arsip hari ini.
            </p>
        </div>

        <div class="flex items-center gap-3 relative z-10">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-950/80 border border-slate-800 text-slate-300 text-sm font-medium shadow-inner">
                <i class="fa-regular fa-calendar-days text-indigo-400"></i>
                <span>{{ now()->translatedFormat('d M Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Statistik Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Card 1: Surat Masuk -->
        <div class="group relative p-5 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-xl hover:border-indigo-500/50 transition-all duration-300 shadow-lg hover:shadow-indigo-500/10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Surat Masuk</p>
                    <h3 class="text-3xl font-extrabold text-white mt-2 group-hover:text-indigo-400 transition-colors">
                        {{ number_format($totalSuratMasuk ?? 0) }}
                    </h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-inbox text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-800/60 flex items-center text-xs text-slate-500">
                <span class="text-indigo-400 font-medium">Total Terdata</span>
            </div>
        </div>

        <!-- Card 2: Surat Keluar -->
        <div class="group relative p-5 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-xl hover:border-purple-500/50 transition-all duration-300 shadow-lg hover:shadow-purple-500/10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Surat Keluar</p>
                    <h3 class="text-3xl font-extrabold text-white mt-2 group-hover:text-purple-400 transition-colors">
                        {{ number_format($totalSuratKeluar ?? 0) }}
                    </h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-paper-plane text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-800/60 flex items-center text-xs text-slate-500">
                <span class="text-purple-400 font-medium">Total Terkirim</span>
            </div>
        </div>

        <!-- Card 3: Arsip Surat -->
        <div class="group relative p-5 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-xl hover:border-amber-500/50 transition-all duration-300 shadow-lg hover:shadow-amber-500/10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Arsip Surat</p>
                    <h3 class="text-3xl font-extrabold text-white mt-2 group-hover:text-amber-400 transition-colors">
                        {{ number_format($totalArsip ?? 0) }}
                    </h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-box-archive text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-800/60 flex items-center text-xs text-slate-500">
                <span class="text-slate-400 font-medium">Total tersimpan di server</span>
            </div>
        </div>

        <!-- Card 4: Pengguna -->
        <div class="group relative p-5 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-xl hover:border-rose-500/50 transition-all duration-300 shadow-lg hover:shadow-rose-500/10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pengguna</p>
                    <h3 class="text-3xl font-extrabold text-white mt-2 group-hover:text-rose-400 transition-colors">
                        {{ number_format($totalPengguna ?? 0) }}
                    </h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-rose-500/10 border border-rose-500/20 flex items-center justify-center text-rose-400 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-users text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-800/60 flex items-center text-xs text-slate-500">
                <span class="text-emerald-400 font-medium flex items-center gap-1">
                    <i class="fa-solid fa-circle text-[8px]"></i> Active
                </span>
                <span class="ml-1.5">Semua pengguna aktif</span>
            </div>
        </div>

    </div>

    <!-- Grafik & Aktivitas Section -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Chart (8 cols) -->
        <div class="lg:col-span-8 p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-xl shadow-xl">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-800/80">
                <div>
                    <h2 class="text-lg font-bold text-white tracking-tight">Grafik Statistik Surat</h2>
                    <p class="text-xs text-slate-400">Aktivitas lalu lintas surat dalam 6 bulan terakhir</p>
                </div>
                <span class="text-xs bg-slate-800/80 text-slate-300 px-3 py-1.5 rounded-lg border border-slate-700/50 font-medium">
                    Tahun {{ now()->year }}
                </span>
            </div>
            <div class="relative w-full h-[280px]">
                <canvas id="suratChart"></canvas>
            </div>
        </div>

        <!-- Activity Timeline (4 cols) -->
        <div class="lg:col-span-4 p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-xl shadow-xl flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-800/80">
                    <h2 class="text-lg font-bold text-white tracking-tight">Aktivitas Hari Ini</h2>
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                    </span>
                </div>

                <div class="space-y-4">
                    <div class="flex items-start gap-3.5">
                        <div class="w-8 h-8 rounded-lg bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 shrink-0 mt-0.5">
                            <i class="fa-solid fa-server text-xs"></i>
                        </div>
                        <div class="space-y-0.5">
                            <p class="text-sm font-medium text-slate-200">Sistem Berjalan</p>
                            <p class="text-xs text-slate-500">Koneksi database aktif</p>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('laporan.index') }}" class="mt-6 block w-full text-center py-2.5 px-4 rounded-xl bg-slate-800/50 hover:bg-slate-800 border border-slate-700/50 text-xs font-semibold text-slate-300 hover:text-white transition duration-200">
                Lihat Laporan Aktivitas
            </a>
        </div>

    </div>

    <!-- Tabel Surat Masuk Terbaru -->
    <div class="p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-xl shadow-xl space-y-4">
        <div class="flex items-center justify-between pb-4 border-b border-slate-800/80">
            <div>
                <h2 class="text-lg font-bold text-white tracking-tight">Surat Masuk Terbaru</h2>
                <p class="text-xs text-slate-400">Daftar dokumen surat yang terakhir kali ditambahkan</p>
            </div>
            <a href="{{ route('surat_masuk.index') }}" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 flex items-center gap-1 transition">
                <span>Selengkapnya</span>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="text-xs uppercase bg-slate-950/60 text-slate-400 border-b border-slate-800">
                    <tr>
                        <th scope="col" class="px-4 py-3.5 font-semibold rounded-l-xl">No</th>
                        <th scope="col" class="px-4 py-3.5 font-semibold">Nomor Surat</th>
                        <th scope="col" class="px-4 py-3.5 font-semibold">Perihal</th>
                        <th scope="col" class="px-4 py-3.5 font-semibold">Tanggal Surat</th>
                        <th scope="col" class="px-4 py-3.5 font-semibold rounded-r-xl">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($suratTerbaru ?? [] as $index => $surat)
                        <tr class="hover:bg-slate-800/30 transition-colors">
                            <td class="px-4 py-4 font-medium text-slate-400">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4 font-semibold text-indigo-400">
                                {{ $surat->nomor_surat ?? $surat->no_surat ?? '-' }}
                            </td>
                            <td class="px-4 py-4 text-slate-200">
                                {{ $surat->perihal ?? '-' }}
                            </td>
                            <td class="px-4 py-4 text-slate-400">
                                @if(isset($surat->tanggal_surat))
                                    {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}
                                @else
                                    {{ $surat->created_at ? $surat->created_at->translatedFormat('d F Y') : '-' }}
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                    Tersimpan
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-slate-500">
                                <i class="fa-regular fa-folder-open text-2xl mb-2 block"></i>
                                Belum ada data surat masuk terbaru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const canvas = document.getElementById('suratChart');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(99, 102, 241, 0.8)'); 
    gradient.addColorStop(1, 'rgba(168, 85, 247, 0.1)'); 

    const chartLabels = {{ Illuminate\Support\Js::from($chartLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun']) }};
    const chartData = {{ Illuminate\Support\Js::from($chartData ?? [0, 0, 0, 0, 0, 0]) }};

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Jumlah Surat',
                data: chartData,
                backgroundColor: gradient,
                borderColor: '#6366f1',
                borderWidth: 1.5,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleColor: '#f8fafc',
                    bodyColor: '#cbd5e1',
                    borderColor: '#334155',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: false,
                    cornerRadius: 8
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#94a3b8', font: { family: 'Plus Jakarta Sans, sans-serif' } }
                },
                y: {
                    grid: { color: 'rgba(51, 65, 85, 0.4)', borderDash: [4, 4] },
                    ticks: { 
                        color: '#94a3b8', 
                        font: { family: 'Plus Jakarta Sans, sans-serif' },
                        precision: 0 
                    },
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endpush