@extends('layouts.app')

@section('title', 'Data Surat Masuk')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-3xl font-bold text-white">
                Data Surat Masuk
            </h1>

            <p class="text-slate-400 mt-1">
                Kelola seluruh data surat masuk PT Microdata Indonesia.
            </p>
        </div>

        <a href="{{ route('surat_masuk.create') }}"
           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl font-semibold transition">

            <i class="fa-solid fa-plus"></i>

            Tambah Surat

        </a>

    </div>

    {{-- Search --}}
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5">

        <form method="GET">

            <div class="flex flex-col md:flex-row gap-3">

                <div class="relative flex-1">

                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-4 text-slate-500"></i>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nomor agenda, nomor surat atau perihal..."
                        class="w-full bg-slate-950 border border-slate-700 rounded-xl pl-11 pr-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">

                </div>

                <button
                    class="bg-indigo-600 hover:bg-indigo-700 px-6 rounded-xl font-semibold">

                    Cari

                </button>

            </div>

        </form>

    </div>

    {{-- Peringatan surat di tempat sampah --}}
    @if($jumlahDihapus > 0)
    <div class="bg-amber-500/10 border border-amber-500/30 rounded-2xl p-4 flex items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-trash-can text-amber-400"></i>
            <p class="text-sm text-amber-300">
                Ada <span class="font-semibold">{{ $jumlahDihapus }} surat masuk</span> yang sudah dihapus dan menunggu di tempat sampah.
            </p>
        </div>
        <a href="{{ route('recycle-bin.index') }}"
           class="text-sm font-semibold text-amber-400 hover:text-amber-300 whitespace-nowrap">
            Lihat Tempat Sampah →
        </a>
    </div>
    @endif

    {{-- Table --}}
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-800">

                    <tr class="text-left text-slate-300">

                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Nomor Surat</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Asal Surat</th>
                        <th class="px-6 py-4">Perihal</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($surat as $item)

                    <tr class="border-t border-slate-800 hover:bg-slate-800/40 transition">

                        <td class="px-6 py-4 text-slate-300">
                            {{ $loop->iteration + ($surat->currentPage()-1) * $surat->perPage() }}
                        </td>

                        <td class="px-6 py-4 text-slate-300">
                            {{ $item->nomor_surat }}
                        </td>

                        <td class="px-6 py-4 text-slate-300">
                            {{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d-m-Y') }}
                        </td>

                        <td class="px-6 py-4 text-slate-300">
                            {{ Str::limit($item->asal_surat,30) }}
                        </td>

                        <td class="px-6 py-4 text-slate-300">
                            {{ Str::limit($item->perihal,35) }}
                        </td>

                        <td class="px-6 py-4">

                            @if($item->status=='Baru')

                                <span class="px-3 py-1 rounded-full text-xs bg-blue-500/20 text-blue-400 border border-blue-500/30">

                                    Baru

                                </span>

                            @elseif($item->status=='Diproses')

                                <span class="px-3 py-1 rounded-full text-xs bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">

                                    Diproses

                                </span>

                            @else

                                <span class="px-3 py-1 rounded-full text-xs bg-green-500/20 text-green-400 border border-green-500/30">

                                    Selesai

                                </span>

                            @endif

                        </td>

                        <td class="px-6 py-4">

                            <div class="flex justify-center gap-2">

                                <a href="{{ route('surat_masuk.show',$item->id) }}"
                                   class="w-9 h-9 rounded-lg bg-cyan-600 hover:bg-cyan-700 flex items-center justify-center">

                                    <i class="fa-solid fa-eye text-white text-sm"></i>

                                </a>

                                <a href="{{ route('surat_masuk.edit',$item->id) }}"
                                   class="w-9 h-9 rounded-lg bg-amber-500 hover:bg-amber-600 flex items-center justify-center">

                                    <i class="fa-solid fa-pen text-white text-sm"></i>

                                </a>

                                <form
                                    action="{{ route('surat_masuk.destroy',$item->id) }}"
                                    method="POST"
                                    class="deleteForm">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="w-9 h-9 rounded-lg bg-rose-600 hover:bg-rose-700 flex items-center justify-center">

                                        <i class="fa-solid fa-trash text-white text-sm"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7"
                            class="text-center py-12 text-slate-400">

                            <i class="fa-regular fa-folder-open text-5xl mb-4 block"></i>

                            Belum ada data surat masuk.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- Pagination --}}
    <div>

        {{ $surat->links() }}

    </div>

</div>

@endsection

@push('scripts')

<script>

document.querySelectorAll('.deleteForm').forEach(form=>{

    form.addEventListener('submit',function(e){

        e.preventDefault();

        Swal.fire({

            title:'Hapus surat?',

            text:'Data tidak dapat dikembalikan.',

            icon:'warning',

            showCancelButton:true,

            confirmButtonColor:'#6366f1',

            cancelButtonColor:'#ef4444',

            confirmButtonText:'Ya, Hapus'

        }).then((result)=>{

            if(result.isConfirmed){

                form.submit();

            }

        });

    });

});

</script>

@endpush
