@extends('layouts.app')

@section('title', 'Surat Masuk')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-xl shadow-xl">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-semibold uppercase tracking-wider">
                    <i class="fa-solid fa-inbox"></i>
                    <span>Manajemen Surat</span>
                </span>
            </div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight mt-1">
                Data Surat Masuk
            </h1>
            <p class="text-slate-400 text-sm">
                Kelola dan catat seluruh arsip surat masuk perusahaan secara terorganisir.
            </p>
        </div>

        <div>
            <a href="{{ route('surat_masuk.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm shadow-lg shadow-indigo-600/30 transition-all duration-200">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Tambah Surat Masuk</span>
            </a>
        </div>
    </div>

    <!-- Table Container -->
    <div class="p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-xl shadow-xl space-y-4">
        
        <!-- Search & Filter Bar -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pb-4 border-b border-slate-800/80">
            <h2 class="text-base font-bold text-white tracking-tight">Daftar Surat Masuk</h2>
            
            <div class="w-full sm:w-auto flex items-center gap-2">
                <div class="relative w-full sm:w-64">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
                    <input type="text" placeholder="Cari surat..." class="w-full pl-9 pr-4 py-2 rounded-xl bg-slate-950/80 border border-slate-800 text-slate-200 text-xs placeholder:text-slate-500 focus:outline-none focus:border-indigo-500 transition">
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="text-xs uppercase bg-slate-950/80 text-slate-400 border-b border-slate-800">
                    <tr>
                        <th scope="col" class="px-4 py-3.5 font-semibold rounded-l-xl w-12 text-center">No</th>
                        <th scope="col" class="px-4 py-3.5 font-semibold">No. Agenda</th>
                        <th scope="col" class="px-4 py-3.5 font-semibold">No. Surat</th>
                        <th scope="col" class="px-4 py-3.5 font-semibold">Pengirim</th>
                        <th scope="col" class="px-4 py-3.5 font-semibold">Perihal</th>
                        <th scope="col" class="px-4 py-3.5 font-semibold">Tgl Terima</th>
                        <th scope="col" class="px-4 py-3.5 font-semibold text-center">Status</th>
                        <th scope="col" class="px-4 py-3.5 font-semibold text-center rounded-r-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse ($surat as $index => $item)
                        <tr class="hover:bg-slate-800/40 transition-colors">
                            <!-- Index / Numbering dengan Support Pagination -->
                            <td class="px-4 py-4 font-medium text-slate-400 text-center">
                                {{ $surat->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-4 font-semibold text-indigo-400">
                                {{ $item->nomor_agenda }}
                            </td>
                            <td class="px-4 py-4 font-medium text-slate-200">
                                {{ $item->nomor_surat }}
                            </td>
                            <td class="px-4 py-4 text-slate-300">
                                {{ $item->pengirim }}
                            </td>
                            <td class="px-4 py-4 text-slate-300 max-w-xs truncate" title="{{ $item->perihal }}">
                                {{ $item->perihal }}
                            </td>
                            <td class="px-4 py-4 text-slate-400 text-xs">
                                {{ \Carbon\Carbon::parse($item->tanggal_terima)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Detail -->
                                    <a href="{{ route('surat_masuk.show', $item->id) }}" 
                                       title="Lihat Detail" 
                                       class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-indigo-600/20 border border-slate-700/50 hover:border-indigo-500/40 text-slate-300 hover:text-indigo-400 flex items-center justify-center transition">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('surat_masuk.edit', $item->id) }}" 
                                       title="Edit Surat" 
                                       class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-amber-600/20 border border-slate-700/50 hover:border-amber-500/40 text-slate-300 hover:text-amber-400 flex items-center justify-center transition">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('surat_masuk.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                title="Hapus Surat" 
                                                class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-rose-600/20 border border-slate-700/50 hover:border-rose-500/40 text-slate-300 hover:text-rose-400 flex items-center justify-center transition">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-800/80 border border-slate-700/50 flex items-center justify-center text-slate-500">
                                        <i class="fa-solid fa-inbox text-xl"></i>
                                    </div>
                                    <div class="space-y-1">
                                        <p class="text-slate-300 font-semibold text-sm">Belum ada data surat masuk</p>
                                        <p class="text-slate-500 text-xs">Silakan klik tombol "Tambah Surat Masuk" di atas untuk menambahkan data baru.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="pt-4 border-t border-slate-800/80">
            {{ $surat->links() }}
        </div>

    </div>

</div>
@endsection