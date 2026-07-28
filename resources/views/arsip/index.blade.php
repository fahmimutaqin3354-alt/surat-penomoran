@extends('layouts.app')

@section('title', 'Arsip Surat')

@section('content')

<div class="px-4 py-6">

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h4 class="text-xl font-semibold text-gray-800">Arsip Surat</h4>
            <p class="text-sm text-gray-500">Daftar seluruh arsip surat masuk dan surat keluar</p>
        </div>
        <div class="flex gap-2">
            <button class="inline-flex items-center gap-1 px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                Ekspor
            </button>
            <a href="{{ route('arsip.create') }}" class="inline-flex items-center gap-1 px-3 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Arsip
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-4">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">

            <div class="md:col-span-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                <input type="text"
                       name="q"
                       value="{{ request('q') }}"
                       placeholder="Cari nomor surat, judul, pengirim/penerima..."
                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis</label>
                <select name="jenis" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Jenis</option>
                    <option value="masuk" @selected(request('jenis')=='masuk')>Surat Masuk</option>
                    <option value="keluar" @selected(request('jenis')=='keluar')>Surat Keluar</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="kategori" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriList ?? [] as $kategori)
                        <option value="{{ $kategori }}" @selected(request('kategori')==$kategori)>{{ $kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                <select name="tahun" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Tahun</option>
                    @foreach($tahunList ?? [] as $tahun)
                        <option value="{{ $tahun }}" @selected(request('tahun')==$tahun)>{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2">
                <button type="submit" class="w-full inline-flex items-center justify-center gap-1 px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition">
                    <i class="bi bi-funnel"></i> Filter
                </button>
            </div>

        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3">

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left align-middle">
                <thead>
                    <tr class="border-b border-gray-200 text-gray-500 text-xs uppercase tracking-wide">
                        <th class="w-8 px-3 py-3"><input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"></th>
                        <th class="px-3 py-3">No. Surat</th>
                        <th class="px-3 py-3">Jenis</th>
                        <th class="px-3 py-3">Judul Surat</th>
                        <th class="px-3 py-3">Pengirim / Penerima</th>
                        <th class="px-3 py-3">Tanggal Surat</th>
                        <th class="px-3 py-3">Tahun</th>
                        <th class="px-3 py-3">Status</th>
                        <th class="px-3 py-3">Arsip Oleh</th>
                        <th class="px-3 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($arsipSurat as $surat)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-3"><input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"></td>
                            <td class="px-3 py-3 font-semibold text-gray-800">{{ $surat->no_surat }}</td>
                            <td class="px-3 py-3 text-gray-600">{{ $surat->jenis === 'masuk' ? 'Surat Masuk' : 'Surat Keluar' }}</td>
                            <td class="px-3 py-3 text-gray-600">{{ $surat->judul }}</td>
                            <td class="px-3 py-3 text-gray-600">{{ $surat->pengirim_penerima }}</td>
                            <td class="px-3 py-3 text-gray-600">{{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d M Y') }}</td>
                            <td class="px-3 py-3 text-gray-600">{{ $surat->tahun }}</td>
                            <td class="px-3 py-3">
                                <span class="inline-block rounded-full bg-green-100 text-green-700 text-xs font-medium px-3 py-1">
                                    {{ $surat->status }}
                                </span>
                            </td>
                            <td class="px-3 py-3 text-gray-600">{{ $surat->arsip_oleh }}</td>
                            <td class="px-3 py-3">
                                <details class="relative">
                                    <summary class="list-none cursor-pointer inline-flex items-center justify-center w-8 h-8 rounded-md hover:bg-gray-100 text-gray-600">
                                        <i class="bi bi-three-dots"></i>
                                    </summary>
                                    <ul class="absolute right-0 z-10 mt-1 w-40 bg-white border border-gray-200 rounded-lg shadow-lg py-1 text-sm">
                                        <li>
                                            <a class="flex items-center gap-2 px-3 py-2 text-gray-700 hover:bg-gray-50" href="{{ route('arsip.show', $surat->id) }}">
                                                <i class="bi bi-eye"></i>Lihat
                                            </a>
                                        </li>
                                        <li>
                                            <a class="flex items-center gap-2 px-3 py-2 text-gray-700 hover:bg-gray-50" href="{{ route('arsip.edit', $surat->id) }}">
                                                <i class="bi bi-pencil"></i>Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('arsip.destroy', $surat->id) }}" method="POST" onsubmit="return confirm('Hapus arsip ini?')">
                                                @csrf @method('DELETE')
                                                <button class="w-full flex items-center gap-2 px-3 py-2 text-red-600 hover:bg-red-50">
                                                    <i class="bi bi-trash"></i>Hapus
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </details>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-gray-400 py-6">Belum ada data arsip surat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between mt-4 px-1">
            <small class="text-gray-500">
                Menampilkan {{ $arsipSurat->firstItem() ?? 0 }} sampai {{ $arsipSurat->lastItem() ?? 0 }} dari {{ $arsipSurat->total() ?? 0 }} data
            </small>
            {{ $arsipSurat->links() }}
        </div>

    </div>

</div>

@endsection