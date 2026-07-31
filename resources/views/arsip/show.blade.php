@extends('layouts.app')

@section('title', 'Detail Arsip Surat')

@section('content')

<div class="px-4 py-6 max-w-3xl mx-auto">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h4 class="text-2xl font-bold text-white">Detail Arsip Surat</h4>
            <p class="text-sm text-slate-400 mt-1">Informasi lengkap arsip surat</p>
        </div>
        <a href="{{ route('arsip.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-800 bg-slate-900 text-slate-300 text-sm font-medium hover:bg-slate-800 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-xl p-6">

        <div class="flex items-center justify-between mb-6 pb-6 border-b border-slate-800">
            <div>
                <p class="text-xs text-slate-500 mb-1">Nomor Surat</p>
                <p class="text-lg font-semibold text-white">{{ $surat->no_surat }}</p>
            </div>
            <span class="inline-block rounded-full bg-emerald-500/10 text-emerald-400 text-xs font-medium px-3 py-1.5">
                {{ $surat->status }}
            </span>
        </div>

        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">

            <div>
                <dt class="text-xs text-slate-500 mb-1">Jenis Surat</dt>
                <dd class="text-sm text-slate-200">
                    <span class="inline-flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full {{ $surat->jenis === 'masuk' ? 'bg-blue-400' : 'bg-emerald-400' }}"></span>
                        {{ $surat->jenis === 'masuk' ? 'Surat Masuk' : 'Surat Keluar' }}
                    </span>
                </dd>
            </div>

            <div>
                <dt class="text-xs text-slate-500 mb-1">Tanggal Surat</dt>
                <dd class="text-sm text-slate-200">{{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d M Y') }}</dd>
            </div>

            <div class="md:col-span-2">
                <dt class="text-xs text-slate-500 mb-1">Judul Surat</dt>
                <dd class="text-sm text-slate-200">{{ $surat->judul }}</dd>
            </div>

            <div>
                <dt class="text-xs text-slate-500 mb-1">Pengirim / Penerima</dt>
                <dd class="text-sm text-slate-200">{{ $surat->pengirim_penerima }}</dd>
            </div>

            <div>
                <dt class="text-xs text-slate-500 mb-1">Tahun</dt>
                <dd class="text-sm text-slate-200">{{ $surat->tahun }}</dd>
            </div>

            @if($surat->kategori ?? null)
                <div>
                    <dt class="text-xs text-slate-500 mb-1">Kategori</dt>
                    <dd class="text-sm text-slate-200">{{ $surat->kategori }}</dd>
                </div>
            @endif

            <div>
                <dt class="text-xs text-slate-500 mb-1">Arsip Oleh</dt>
                <dd class="text-sm text-slate-200">{{ $surat->arsip_oleh }}</dd>
            </div>

            @if($surat->keterangan ?? null)
                <div class="md:col-span-2">
                    <dt class="text-xs text-slate-500 mb-1">Keterangan</dt>
                    <dd class="text-sm text-slate-200 whitespace-pre-line">{{ $surat->keterangan }}</dd>
                </div>
            @endif

        </dl>

        @if($surat->file_surat ?? null)
            <div class="mt-6 pt-6 border-t border-slate-800">
                <dt class="text-xs text-slate-500 mb-2">File Lampiran</dt>
                <a href="{{ asset('storage/arsip/' . $surat->file_surat) }}" target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-800 bg-slate-950 text-slate-300 text-sm hover:bg-slate-800 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    Lihat / Unduh File
                </a>
            </div>
        @endif

        <div class="mt-6 pt-6 border-t border-slate-800 flex items-center gap-2">
            <a href="{{ route('arsip.edit', $surat->id) }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                </svg>
                Edit
            </a>
            <form action="{{ route('arsip.destroy', $surat->id) }}" method="POST" onsubmit="return confirm('Hapus arsip ini?')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-800 bg-slate-900 text-red-400 text-sm font-medium hover:bg-slate-800 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    Hapus
                </button>
            </form>
        </div>

    </div>

</div>

@endsection