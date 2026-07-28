@extends('layouts.app')

@section('title','Detail Surat Keluar')

@section('content')

<div class="px-4">

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

        <div class="bg-green-600 text-white rounded-t-xl px-5 py-4">
            <h4 class="text-lg font-semibold">Detail Surat Keluar</h4>
        </div>

        <div class="p-5">

            <table class="w-full text-sm">
                <tbody>
                    <tr class="border-b border-gray-100">
                        <th class="py-3 pr-4 text-left text-gray-500 font-medium w-48">Nomor Surat</th>
                        <td class="py-3 text-gray-800">002/MI/VII/2026</td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <th class="py-3 pr-4 text-left text-gray-500 font-medium">Perihal</th>
                        <td class="py-3 text-gray-800">Undangan Rapat</td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <th class="py-3 pr-4 text-left text-gray-500 font-medium">Tujuan</th>
                        <td class="py-3 text-gray-800">PT ABC</td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <th class="py-3 pr-4 text-left text-gray-500 font-medium">Tanggal</th>
                        <td class="py-3 text-gray-800">24 Juli 2026</td>
                    </tr>
                    <tr>
                        <th class="py-3 pr-4 text-left text-gray-500 font-medium">File</th>
                        <td class="py-3">
                            <a href="#" class="inline-flex items-center gap-2 bg-blue-600 text-white px-3 py-1.5 rounded-lg text-sm hover:bg-blue-700 transition">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                Download PDF
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-6">
                <a href="{{ route('surat_keluar.index') }}" class="inline-flex items-center gap-2 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                    </svg>
                    Kembali
                </a>
            </div>

    </div>

@endsection
