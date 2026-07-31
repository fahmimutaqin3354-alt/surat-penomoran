@extends('layouts.app')

@section('title', 'Arsip Surat')

@section('content')

<div class="px-4 py-6">

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">

        <div>

            <h4 class="text-2xl font-bold text-white">
                Arsip Surat
            </h4>

            <p class="text-sm text-slate-400 mt-1">
                Seluruh surat masuk dan surat keluar akan otomatis masuk ke arsip.
            </p>

        </div>

        <div
            class="px-4 py-2 rounded-lg bg-emerald-500/10 text-emerald-400 text-sm font-medium">

            Arsip Otomatis

        </div>

    </div>

    {{-- ================= ALERT ================= --}}

    @if(session('success'))

        <div
            class="mb-5 rounded-lg border border-emerald-500/20 bg-emerald-500/10 px-4 py-3 text-emerald-400">

            {{ session('success') }}

        </div>

    @endif

    {{-- ================= SEARCH ================= --}}

    <form
        method="GET"
        action="{{ route('arsip.index') }}"
        class="flex flex-wrap items-center gap-3 mb-5">

        <div class="relative flex-1 min-w-[260px]">

            <svg
                class="w-4 h-4 text-slate-500 absolute left-3 top-1/2 -translate-y-1/2"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />

            </svg>

            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Cari nomor surat, perihal atau pengirim/penerima..."

                class="w-full
                bg-slate-900
                border
                border-slate-800
                rounded-lg
                pl-10
                pr-3
                py-2.5
                text-sm
                text-slate-100
                placeholder-slate-500
                focus:outline-none
                focus:ring-2
                focus:ring-indigo-500">

        </div>

        {{-- Filter Jenis --}}

        <select
            name="jenis"

            class="bg-slate-900
            border
            border-slate-800
            rounded-lg
            px-3
            py-2.5
            text-sm
            text-slate-300">

            <option value="">Semua Jenis</option>

            <option
                value="Surat Masuk"
                @selected(request('jenis')=='Surat Masuk')>

                Surat Masuk

            </option>

            <option
                value="Surat Keluar"
                @selected(request('jenis')=='Surat Keluar')>

                Surat Keluar

            </option>

        </select>

        {{-- Filter Status --}}

        <select
            name="status"

            class="bg-slate-900
            border
            border-slate-800
            rounded-lg
            px-3
            py-2.5
            text-sm
            text-slate-300">

            <option value="">Semua Status</option>

            <option value="Baru"
                @selected(request('status')=='Baru')>
                Baru
            </option>

            <option value="Diproses"
                @selected(request('status')=='Diproses')>
                Diproses
            </option>

            <option value="Draft"
                @selected(request('status')=='Draft')>
                Draft
            </option>

            <option value="Dikirim"
                @selected(request('status')=='Dikirim')>
                Dikirim
            </option>

            <option value="Selesai"
                @selected(request('status')=='Selesai')>
                Selesai
            </option>

        </select>

        <button
            type="submit"

            class="px-5
            py-2.5
            rounded-lg
            bg-indigo-600
            text-white
            text-sm
            hover:bg-indigo-700
            transition">

            Cari

        </button>

        <a
            href="{{ route('arsip.index') }}"

            class="px-5
            py-2.5
            rounded-lg
            bg-slate-700
            text-white
            text-sm
            hover:bg-slate-600
            transition">

            Reset

        </a>

    </form>

    {{-- ================= TABEL ================= --}}

    <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full text-sm text-left">

                <thead>

                    <tr class="border-b border-slate-800 text-slate-400 uppercase text-xs">

                        <th class="px-4 py-3">No</th>

                        <th class="px-4 py-3">Nomor Surat</th>

                        <th class="px-4 py-3">Jenis</th>

                        <th class="px-4 py-3">Perihal</th>

                        <th class="px-4 py-3">Pengirim / Penerima</th>

                        <th class="px-4 py-3">Tanggal</th>

                        <th class="px-4 py-3">Status</th>

                        <th class="px-4 py-3 text-right">Aksi</th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-800">
@forelse($arsipSurat as $i => $surat)

<tr class="hover:bg-slate-800/40 transition">

    <td class="px-4 py-3 text-slate-400">

        {{ $arsipSurat->firstItem() + $i }}

    </td>

    <td class="px-4 py-3 font-semibold text-white">

        {{ $surat->nomor_surat }}

    </td>

    <td class="px-4 py-3">

        @if($surat->jenis == 'Surat Masuk')

            <span
                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-400">

                Surat Masuk

            </span>

        @else

            <span
                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-500/20 text-emerald-400">

                Surat Keluar

            </span>

        @endif

    </td>

    <td class="px-4 py-3 text-slate-300">

        {{ $surat->perihal }}

    </td>

    <td class="px-4 py-3 text-slate-300">

        {{ $surat->pengirim_penerima }}

    </td>

    <td class="px-4 py-3 text-slate-400">

        {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d M Y') }}

    </td>

    <td class="px-4 py-3">

        @php

            $warna = match($surat->status){

                'Baru' => 'bg-sky-500/20 text-sky-400',

                'Diproses' => 'bg-yellow-500/20 text-yellow-400',

                'Draft' => 'bg-gray-500/20 text-gray-300',

                'Dikirim' => 'bg-indigo-500/20 text-indigo-400',

                'Selesai' => 'bg-emerald-500/20 text-emerald-400',

                default => 'bg-slate-500/20 text-slate-300'

            };

        @endphp

        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $warna }}">

            {{ $surat->status }}

        </span>

    </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">

                                    {{-- Lihat --}}
                                    <a href="{{ route('arsip.show', $surat->id) }}"
                                        class="p-2 rounded-lg bg-blue-500/10 text-blue-400 hover:bg-blue-500 hover:text-white transition"
                                        title="Lihat">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-4 h-4"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0" />

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />

                                        </svg>

                                    </a>

                                    {{-- Hapus --}}
                                    <form action="{{ route('arsip.destroy', $surat->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus arsip ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="p-2 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white transition"
                                            title="Hapus">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-4 h-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">

                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M19 7H5" />

                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M10 11V17" />

                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M14 11V17" />

                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M6 7L7 19a2 2 0 002 2h6a2 2 0 002-2l1-12" />

                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3" />

                                            </svg>

                                        </button>

                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" class="py-16">

                                <div class="flex flex-col items-center justify-center gap-3 text-slate-500">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-12 h-12"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z" />

                                    </svg>

                                    <p>Belum ada data arsip.</p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($arsipSurat->total() > 0)

            <div class="flex items-center justify-between px-5 py-4 border-t border-slate-800">

                <small class="text-slate-500">

                    Menampilkan
                    {{ $arsipSurat->firstItem() }}
                    -
                    {{ $arsipSurat->lastItem() }}
                    dari
                    {{ $arsipSurat->total() }}
                    data

                </small>

                {{ $arsipSurat->withQueryString()->links() }}

            </div>

        @endif

    </div>

</div>

@endsection
