@extends('layouts.app')

@section('title', 'Data Surat Masuk')

@push('styles')
<style>
    /* Merapikan style bawaan DataTables agar menyatu dengan Tailwind Dark Mode */
    #tableSuratMasuk_wrapper .dataTables_length select,
    #tableSuratMasuk_wrapper .dataTables_filter input {
        background-color: #0f172a !important; /* slate-950 */
        border: 1px solid #334155 !important; /* slate-700 */
        color: #f8fafc !important;
        border-radius: 0.5rem;
        padding: 0.4rem 0.8rem;
    }
    #tableSuratMasuk_wrapper .dataTables_info,
    #tableSuratMasuk_wrapper .dataTables_length,
    #tableSuratMasuk_wrapper .dataTables_filter {
        color: #94a3b8 !important; /* slate-400 */
        margin-bottom: 1rem;
    }
    table.dataTable thead th, table.dataTable thead td {
        border-bottom: 1px solid #334155 !important;
    }
    table.dataTable.no-footer {
        border-bottom: none !important;
    }
</style>
@endpush

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

    {{-- Table Container --}}
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 overflow-hidden">
        <div class="overflow-x-auto">
            <table id="tableSuratMasuk" class="w-full text-sm border-collapse">
                <thead class="bg-slate-800 text-slate-300">
                    <tr>
                        <th class="px-4 py-3 text-center whitespace-nowrap" style="width: 5%;">No</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap" style="width: 20%;">Nomor Surat</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap" style="width: 15%;">Tanggal</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap" style="width: 20%;">Instansi</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap" style="width: 20%;">Perihal</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap" style="width: 10%;">Status</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap" style="width: 10%;">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-800">
                @forelse($surat as $item)
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="px-4 py-4 text-center text-slate-300 align-middle">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-4 py-4 font-semibold text-white align-middle whitespace-nowrap">
                            {{ $item->nomor_surat }}
                        </td>

                        <td class="px-4 py-4 text-slate-300 align-middle whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d-m-Y') }}
                        </td>

                        <td class="px-4 py-4 text-slate-300 align-middle">
                            {{ Str::limit($item->instansi->nama_instansi ?? '-', 30) }}
                        </td>

                        <td class="px-4 py-4 text-slate-300 align-middle">
                            {{ Str::limit($item->perihal, 30) }}
                        </td>

                        <td class="px-4 py-4 text-center align-middle whitespace-nowrap">
                            @if($item->status == 'Baru')
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                    Baru
                                </span>
                            @elseif($item->status == 'Diproses')
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                    Diproses
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                    Selesai
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-4 text-center align-middle whitespace-nowrap">
                            <div class="flex justify-center items-center gap-2">
                                <a href="{{ route('surat_masuk.show', $item->id) }}"
                                   class="w-8 h-8 rounded-lg bg-cyan-600 hover:bg-cyan-700 flex items-center justify-center transition"
                                   title="Lihat Detail">
                                    <i class="fa-solid fa-eye text-white text-xs"></i>
                                </a>

                                <a href="{{ route('surat_masuk.edit', $item->id) }}"
                                   class="w-8 h-8 rounded-lg bg-amber-500 hover:bg-amber-600 flex items-center justify-center transition"
                                   title="Edit Surat">
                                    <i class="fa-solid fa-pen text-white text-xs"></i>
                                </a>

                                <form action="{{ route('surat_masuk.destroy', $item->id) }}"
                                      method="POST"
                                      class="deleteForm inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-8 h-8 rounded-lg bg-rose-600 hover:bg-rose-700 flex items-center justify-center transition"
                                            title="Hapus Surat">
                                        <i class="fa-solid fa-trash text-white text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-12 text-slate-400">
                            <i class="fa-regular fa-folder-open text-5xl mb-4 block"></i>
                            Belum ada data surat masuk.
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
            title: 'Hapus surat?',
            text: 'Data tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#6366f1',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Hapus'
        }).then((result) => {
            if(result.isConfirmed){
                form.submit();
            }
        });
    });
});

$(document).ready(function() {
    $('#tableSuratMasuk').DataTable({
        pageLength: 10,
        responsive: true,
        autoWidth: false,
        ordering: true,
        searching: true,
        info: true,
        columnDefs: [
            { orderable: false, targets: [0, 6] }, // Nonaktifkan sorting di kolom No (0) dan Aksi (6)
            { className: "text-center", targets: [0, 5, 6] }, // Paksa Rata Tengah untuk No, Status, Aksi
            { className: "text-left", targets: [1, 2, 3, 4] } // Paksa Rata Kiri untuk data teks
        ],
        language: {
            search: "🔍 Cari :",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            zeroRecords: "Data tidak ditemukan",
            paginate: {
                previous: "❮",
                next: "❯"
            }
        }
    });
});
</script>
@endpush