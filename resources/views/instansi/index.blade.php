@extends('layouts.app')

@section('title', 'Data Instansi')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-xl shadow-xl">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Data Instansi</h1>
            <p class="text-slate-400 text-sm mt-1">Kelola data instansi/pengirim surat pada sistem.</p>
        </div>
        <a href="{{ route('instansi.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold shadow-lg shadow-indigo-500/20 transition duration-200">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Tambah Instansi</span>
        </a>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Search Bar & Tabel Data -->
    <div class="p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-xl shadow-xl space-y-4">
        
        <!-- Form Search (Filter) -->
        <div class="flex items-center justify-between gap-4">
            <form action="{{ route('instansi.index') }}" method="GET" class="w-full sm:w-72">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari instansi, telepon..." class="w-full pl-10 pr-4 py-2 rounded-xl bg-slate-950/60 border border-slate-800 text-slate-200 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="text-xs uppercase bg-slate-950/60 text-slate-400 border-b border-slate-800">
                    <tr>
                        <th scope="col" class="px-4 py-3.5 font-semibold rounded-l-xl">No</th>
                        <th scope="col" class="px-4 py-3.5 font-semibold">Kode Instansi</th>
                        <th scope="col" class="px-4 py-3.5 font-semibold">Nama Instansi</th>
                        <th scope="col" class="px-4 py-3.5 font-semibold">Telepon</th>
                        <th scope="col" class="px-4 py-3.5 font-semibold">Alamat</th>
                        <th scope="col" class="px-4 py-3.5 font-semibold text-center rounded-r-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($instansi as $item)
                        <tr class="hover:bg-slate-800/30 transition-colors">
                            {{-- Penomoran berlanjut untuk pagination --}}
                            <td class="px-4 py-4 font-medium text-slate-400">
                                {{ $instansi->firstItem() + $loop->index }}
                            </td>
                            <td class="px-4 py-4 font-semibold text-indigo-400">{{ $item->kode_instansi }}</td>
                            <td class="px-4 py-4 text-slate-200 font-medium">{{ $item->nama_instansi }}</td>
                            <td class="px-4 py-4 text-slate-400">{{ $item->telepon ?? '-' }}</td>
                            <td class="px-4 py-4 text-slate-400 max-w-xs truncate" title="{{ $item->alamat }}">
                                {{ $item->alamat ?? '-' }}
                            </td>
                            <td class="px-4 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('instansi.edit', $item->id) }}" class="w-8 h-8 rounded-lg bg-amber-500/10 border border-amber-500/20 text-amber-400 hover:bg-amber-500 hover:text-white flex items-center justify-center transition" title="Edit">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>
                                    <form action="{{ route('instansi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus instansi ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-rose-500/10 border border-rose-500/20 text-rose-400 hover:bg-rose-500 hover:text-white flex items-center justify-center transition" title="Hapus">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-500">
                                <i class="fa-regular fa-building text-2xl mb-2 block"></i>
                                Belum ada data instansi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pt-2">
            {{ $instansi->links() }}
        </div>
    </div>

</div>
@endsection