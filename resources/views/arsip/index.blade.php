@extends('layouts.app')

@section('title', 'Arsip Surat')

@section('content')

<div class="px-4 py-6">

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h4 class="text-2xl font-bold text-white">Arsip Surat</h4>
            <p class="text-sm text-slate-400 mt-1">Kelola seluruh arsip surat masuk dan keluar PT Microdata Indonesia.</p>
        </div>
        <a href="{{ route('arsip.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Arsip
        </a>
    </div>

    {{-- ================= PENCARIAN ================= --}}
    <form method="GET" class="flex flex-wrap items-center gap-3 mb-5">

        <div class="relative flex-1 min-w-[240px]">
            <svg class="w-4 h-4 text-slate-500 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text"
                   name="q"
                   value="{{ request('q') }}"
                   placeholder="Cari nomor surat, judul, atau pengirim/penerima..."
                   class="w-full bg-slate-900 border border-slate-800 rounded-lg pl-10 pr-3 py-2.5 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <select name="jenis"
                class="bg-slate-900 border border-slate-800 rounded-lg px-3 py-2.5 text-sm text-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">Semua Jenis</option>
            <option value="masuk" @selected(request('jenis')=='masuk')>Surat Masuk</option>
            <option value="keluar" @selected(request('jenis')=='keluar')>Surat Keluar</option>
        </select>

        <select name="tahun"
                class="bg-slate-900 border border-slate-800 rounded-lg px-3 py-2.5 text-sm text-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">Semua Tahun</option>
            @foreach($tahunList ?? [] as $tahun)
                <option value="{{ $tahun }}" @selected(request('tahun')==$tahun)>{{ $tahun }}</option>
            @endforeach
        </select>

        <button type="submit"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
            Cari
        </button>

    </form>

    {{-- ================= TABEL ================= --}}
    <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden">

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-800 text-slate-400 text-xs uppercase tracking-wide">
                        <th class="px-4 py-3 font-semibold">No</th>
                        <th class="px-4 py-3 font-semibold">Nomor Surat</th>
                        <th class="px-4 py-3 font-semibold">Jenis</th>
                        <th class="px-4 py-3 font-semibold">Judul Surat</th>
                        <th class="px-4 py-3 font-semibold">Tanggal</th>
                        <th class="px-4 py-3 font-semibold">Status</th>
                        <th class="px-4 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($arsipSurat as $i => $surat)
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="px-4 py-3 text-slate-400">{{ $arsipSurat->firstItem() + $i }}</td>
                            <td class="px-4 py-3 font-medium text-white">{{ $surat->no_surat }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1.5 text-slate-300">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $surat->jenis === 'masuk' ? 'bg-blue-400' : 'bg-emerald-400' }}"></span>
                                    {{ $surat->jenis === 'masuk' ? 'Surat Masuk' : 'Surat Keluar' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-300">{{ $surat->judul }}</td>
                            <td class="px-4 py-3 text-slate-400">{{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d M Y') }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-block rounded-full bg-emerald-500/10 text-emerald-400 text-xs font-medium px-3 py-1">
                                    {{ $surat->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('arsip.show', $surat->id) }}"
                                       title="Lihat"
                                       class="p-2 rounded-md text-slate-400 hover:text-white hover:bg-slate-800 transition">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('arsip.edit', $surat->id) }}"
                                       title="Edit"
                                       class="p-2 rounded-md text-slate-400 hover:text-white hover:bg-slate-800 transition">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('arsip.destroy', $surat->id) }}" method="POST" onsubmit="return confirm('Hapus arsip ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                title="Hapus"
                                                class="p-2 rounded-md text-slate-400 hover:text-red-400 hover:bg-slate-800 transition">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-16">
                                <div class="flex flex-col items-center justify-center gap-3 text-slate-500">
                                    <svg class="w-14 h-14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-19.5 0v6a2.25 2.25 0 002.25 2.25h15a2.25 2.25 0 002.25-2.25v-6m-19.5 0h19.5M12 6.75V4.5m0 2.25a2.25 2.25 0 002.25-2.25M12 6.75a2.25 2.25 0 01-2.25-2.25" />
                                    </svg>
                                    <p class="text-sm">Belum ada data arsip surat.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(($arsipSurat->total() ?? 0) > 0)
            <div class="flex items-center justify-between px-4 py-3 border-t border-slate-800">
                <small class="text-slate-500">
                    Menampilkan {{ $arsipSurat->firstItem() }} sampai {{ $arsipSurat->lastItem() }} dari {{ $arsipSurat->total() }} data
                </small>
                {{ $arsipSurat->links() }}
            </div>
        @endif

    </div>

</div>

@endsection