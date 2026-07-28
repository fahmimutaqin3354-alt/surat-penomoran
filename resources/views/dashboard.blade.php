@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
            <p class="text-sm text-gray-500 mt-1">
                Selamat datang,
                <strong>{{ Auth::user()->name }}</strong>
                di Sistem Arsip Surat PT Microdata Indonesia.
            </p>
        </div>
        <span class="bg-green-100 text-green-700 px-4 py-2 rounded-lg text-sm font-medium">
            {{ now()->format('d M Y') }}
        </span>
    </div>

    {{-- Statistik Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">Surat Masuk</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">120</p>
                </div>
                <span class="text-blue-500">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75H6.912a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859" />
                    </svg>
                </span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">Surat Keluar</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">80</p>
                </div>
                <span class="text-green-500">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                </span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">Arsip Surat</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">230</p>
                </div>
                <span class="text-yellow-500">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                    </svg>
                </span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">Pengguna</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">5</p>
                </div>
                <span class="text-red-500">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </span>
            </div>
        </div>
    </div>

    {{-- Grafik & Aktivitas --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        {{-- Chart --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h5 class="font-semibold text-gray-800 mb-4">Grafik Surat</h5>
            <canvas id="suratChart" height="100"></canvas>
        </div>

        {{-- Aktivitas --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h5 class="font-semibold text-gray-800 mb-4">Aktivitas Hari Ini</h5>
            <ul class="space-y-3">
                <li class="flex items-center gap-3 text-sm text-gray-600">
                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                    Surat masuk ditambahkan
                </li>
                <li class="flex items-center gap-3 text-sm text-gray-600">
                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                    Surat keluar dibuat
                </li>
                <li class="flex items-center gap-3 text-sm text-gray-600">
                    <span class="w-2 h-2 bg-yellow-500 rounded-full"></span>
                    Arsip diperbarui
                </li>
            </ul>
        </div>
    </div>

    {{-- Surat Terbaru --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <h5 class="font-semibold text-gray-800 mb-4">Surat Terbaru</h5>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 text-left text-gray-500">
                        <th class="pb-3 font-medium">No</th>
                        <th class="pb-3 font-medium">Nomor Surat</th>
                        <th class="pb-3 font-medium">Perihal</th>
                        <th class="pb-3 font-medium">Tanggal</th>
                        <th class="pb-3 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-100">
                        <td class="py-3 text-gray-500">1</td>
                        <td class="py-3 text-gray-800">001/MI/VII/2026</td>
                        <td class="py-3 text-gray-600">Surat Undangan</td>
                        <td class="py-3 text-gray-600">24 Juli 2026</td>
                        <td class="py-3">
                            <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-medium">Selesai</span>
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
    const ctx = document.getElementById('suratChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [{
                label: 'Jumlah Surat',
                data: [12, 19, 10, 17, 20, 15],
                backgroundColor: '#3b82f6',
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true },
            }
        }
    });
</script>
@endpush