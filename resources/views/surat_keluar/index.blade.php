@extends('layouts.app')

@section('title', 'Data Surat Keluar')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-3xl font-bold text-white">
                Data Surat Keluar
            </h1>

            <p class="text-slate-400 mt-1">
                Kelola seluruh data surat keluar PT Microdata Indonesia.
            </p>
        </div>

        <a href="{{ route('surat_keluar.create') }}"
           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl font-semibold transition">
            <i class="fa-solid fa-plus"></i>
            Tambah Surat
        </a>

    </div>


    {{-- Tabel --}}
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">

        <div class="overflow-x-auto">

            <table id="tableSuratKeluar"
       class="w-full text-sm border-collapse">

                <thead class="bg-slate-800">
                    <tr class="text-left text-slate-300">
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Nomor Surat</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Instansi</th>
                        <th class="px-6 py-4">Jenis Surat</th>
                        <th class="px-6 py-4">Tujuan</th>
                        <th class="px-6 py-4">Perihal</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($surat as $item)

                    <tr class="border-t border-slate-800 hover:bg-slate-800/40 transition">

                        {{-- 1. No --}}
                        <td class="px-6 py-4 text-slate-300">
                            {{ $loop->iteration }}
                        </td>

                        {{-- 2. Nomor Surat --}}
                        <td class="px-6 py-4 font-semibold text-white">
                            {{ $item->nomor_surat }}
                        </td>

                        {{-- 3. Tanggal --}}
                        <td class="px-6 py-4 text-slate-300">
                            {{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d-m-Y') }}
                        </td>

                        {{-- 4. Instansi (Mencoba ambil dari relasi instansi, jika tidak ada fallback ke kolom instansi biasa) --}}
                        <td class="px-6 py-4 text-slate-300">
    {{ Str::limit($item->instansi->nama_instansi ?? '-',30) }}
</td>
                        {{-- 5. Jenis Surat --}}
                        <td class="px-6 py-4 text-slate-300">
                            {{ $item->jenis_surat }}
                        </td>

                        {{-- 6. Tujuan --}}
                        <td class="px-6 py-4 text-slate-300">
                            {{ $item->tujuan }}
                        </td>

                        {{-- 7. Perihal --}}
                        <td class="px-6 py-4 text-slate-300">
                            {{ $item->perihal }}
                        </td>

                        {{-- 8. Status --}}
                        <td class="px-6 py-4">

                            @if($item->status == 'Draft')
                                <span class="px-3 py-1 rounded-full text-xs bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                    Draft
                                </span>
                            @elseif($item->status == 'Dikirim')
                                <span class="px-3 py-1 rounded-full text-xs bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                    Dikirim
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs bg-green-500/20 text-green-400 border border-green-500/30">
                                    Selesai
                                </span>
                            @endif

                        </td>

                        {{-- 9. Aksi --}}
                        <td class="px-6 py-4">

                            <div class="flex justify-center items-center gap-2">

                                <a href="{{ route('surat_keluar.show', $item->id) }}"
                                   title="Detail"
                                   class="w-9 h-9 rounded-lg bg-cyan-600 hover:bg-cyan-700 flex items-center justify-center transition">
                                    <i class="fa-solid fa-eye text-white text-sm"></i>
                                </a>

                                <a href="{{ route('surat_keluar.edit', $item->id) }}"
                                   title="Edit"
                                   class="w-9 h-9 rounded-lg bg-amber-500 hover:bg-amber-600 flex items-center justify-center transition">
                                    <i class="fa-solid fa-pen text-white text-sm"></i>
                                </a>

                                <a href="{{ route('surat_keluar.preview', $item->id) }}"
                                   title="Preview"
                                   class="w-9 h-9 rounded-lg bg-indigo-600 hover:bg-indigo-700 flex items-center justify-center transition">
                                    <i class="fa-solid fa-file-lines text-white text-sm"></i>
                                </a>

                                <form action="{{ route('surat_keluar.destroy', $item->id) }}"
                                      method="POST"
                                      class="deleteForm">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            title="Hapus"
                                            class="w-9 h-9 rounded-lg bg-rose-600 hover:bg-rose-700 flex items-center justify-center transition">
                                        <i class="fa-solid fa-trash text-white text-sm"></i>
                                    </button>
                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="9" class="text-center py-12 text-slate-400">
                            <i class="fa-regular fa-folder-open text-5xl mb-4 block"></i>
                            Belum ada data surat keluar.
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>



</div>

@endsection

@push('scripts')

<script>

document.querySelectorAll('.deleteForm').forEach(form => {

    form.addEventListener('submit', function(e){

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

new DataTable('#tableSuratKeluar',{

    pageLength:10,
    responsive:true,
    autoWidth:false,
    ordering:true,
    searching:true,
    info:true,

    language:{
        search:"🔍 Cari :",
        lengthMenu:"Tampilkan _MENU_ data",
        info:"Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        zeroRecords:"Data tidak ditemukan",
        paginate:{
            previous:"❮",
            next:"❯"
        }
    }

});

</script>

@endpush
