@extends('layouts.app')

@section('title', 'Surat Keluar')

@section('content')

<div class="px-4">

    <div class="flex justify-between items-center mb-4">

        <div>
            <h2 class="text-2xl font-bold text-gray-800">Surat Keluar</h2>
            <p class="text-sm text-gray-500">
                Kelola seluruh data surat keluar perusahaan.
            </p>
        </div>

        <a href="{{ route('surat_keluar.create') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Surat
        </a>

    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

        <div class="p-5">

            <div class="mb-4">

                <div class="w-full md:w-1/3">

                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Cari nomor atau perihal surat">

                </div>

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead>

                        <tr class="bg-blue-50 text-left text-gray-600">

                            <th class="px-4 py-3 font-medium">No</th>
                            <th class="px-4 py-3 font-medium">Nomor Surat</th>
                            <th class="px-4 py-3 font-medium">Perihal</th>
                            <th class="px-4 py-3 font-medium">Tujuan</th>
                            <th class="px-4 py-3 font-medium">Tanggal</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                            <th class="px-4 py-3 font-medium text-center">Aksi</th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse($surat as $item)

                            <tr class="hover:bg-gray-50">

                                <td class="px-4 py-3 text-gray-500">{{ $loop->iteration }}</td>

                                <td class="px-4 py-3 text-gray-800 font-medium">{{ $item->nomor_surat }}</td>

                                <td class="px-4 py-3 text-gray-600">{{ $item->perihal }}</td>

                                <td class="px-4 py-3 text-gray-600">{{ $item->tujuan }}</td>

                                <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d-m-Y') }}</td>

                                <td class="px-4 py-3">

                                    @if($item->status == 'Draft')
                                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">{{ $item->status }}</span>
                                    @elseif($item->status == 'Dikirim')
                                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">{{ $item->status }}</span>
                                    @else
                                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">{{ $item->status }}</span>
                                    @endif

                                </td>

                                <td class="px-4 py-3 text-center">

                                    <div class="flex items-center justify-center gap-1">

                                        <a href="{{ route('surat_keluar.show', $item->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded bg-cyan-500 text-white hover:bg-cyan-600 transition" title="Detail">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </a>

                                        <a href="{{ route('surat_keluar.edit', $item->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded bg-yellow-400 text-white hover:bg-yellow-500 transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('surat_keluar.destroy', $item->id) }}" method="POST" class="inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded bg-red-500 text-white hover:bg-red-600 transition" onclick="return confirm('Yakin ingin menghapus surat ini?')" title="Hapus">
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

                                <td colspan="7" class="text-center text-gray-400 py-8">Belum ada data surat keluar.</td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-4">
                {{ $surat->links() }}
            </div>

    </div>

@endsection
