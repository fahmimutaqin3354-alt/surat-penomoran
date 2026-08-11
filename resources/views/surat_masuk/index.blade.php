@extends('layouts.app')

@section('title', 'Data Surat Masuk')

@section('content')

<div class="space-y-4">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-5 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-xl shadow-xl">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight flex items-center gap-3">
                <span class="w-9 h-9 rounded-xl bg-cyan-600/20 border border-cyan-500/30 flex items-center justify-center">
                    <i class="fa-solid fa-inbox text-cyan-400 text-sm"></i>
                </span>
                Data Surat Masuk
            </h1>
            <p class="text-slate-400 text-sm mt-1 ml-12">Kelola seluruh data surat masuk PT Microdata Indonesia.</p>
        </div>
        <a href="{{ route('surat_masuk.create') }}"
           class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 text-white text-sm font-semibold shadow-lg shadow-indigo-500/25 transition-all duration-200 whitespace-nowrap">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Tambah Surat</span>
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
           class="text-sm font-semibold text-amber-400 hover:text-amber-300 whitespace-nowrap transition-colors">
            Lihat Tempat Sampah →
        </a>
    </div>
    @endif

    {{-- Table Card --}}
    <div class="rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-xl shadow-xl overflow-hidden">
        <div class="px-6 py-3.5 border-b border-slate-800/80 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-slate-300 flex items-center gap-2">
                <i class="fa-solid fa-table-list text-cyan-400"></i>
                Daftar Surat Masuk
            </h2>
            <span class="text-xs text-slate-500 bg-slate-800 px-3 py-1 rounded-full">
                Total: {{ count($surat) }} surat
            </span>
        </div>

        <div class="overflow-x-auto">
            <table id="tableSuratMasuk" class="w-full text-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Surat</th>
                        <th>Tanggal</th>
                        <th>Instansi</th>
                        <th>Perihal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($surat as $index => $item)
                    <tr>
                        <td class="text-center text-slate-500 font-medium">{{ $index + 1 }}</td>

                        <td class="font-mono font-semibold text-white">{{ $item->nomor_surat }}</td>

                        <td class="text-slate-400 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d-m-Y') }}
                        </td>

                        <td class="text-slate-300">
                            {{ Str::limit($item->instansi->nama_instansi ?? '-', 30) }}
                        </td>

                        <td class="text-slate-300">
                            <span title="{{ $item->perihal }}">{{ Str::limit($item->perihal, 35) }}</span>
                        </td>

                        <td class="text-center">
                            @if($item->status == 'Baru')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-500/15 text-blue-400 border border-blue-500/20">
                                    <i class="fa-solid fa-circle text-xs opacity-75"></i>
                                    Baru
                                </span>
                            @elseif($item->status == 'Diproses')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-500/15 text-yellow-400 border border-yellow-500/20">
                                    <i class="fa-solid fa-spinner text-xs"></i>
                                    Diproses
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/15 text-emerald-400 border border-emerald-500/20">
                                    <i class="fa-solid fa-check text-xs"></i>
                                    Selesai
                                </span>
                            @endif
                        </td>

                        <td class="text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('surat_masuk.show', $item->id) }}"
                                   class="w-8 h-8 rounded-lg bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 hover:bg-cyan-500 hover:text-white hover:border-cyan-500 flex items-center justify-center transition-all duration-150"
                                   title="Lihat Detail">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                </a>
                                <a href="{{ route('surat_masuk.edit', $item->id) }}"
                                   class="w-8 h-8 rounded-lg bg-amber-500/10 border border-amber-500/20 text-amber-400 hover:bg-amber-500 hover:text-white hover:border-amber-500 flex items-center justify-center transition-all duration-150"
                                   title="Edit Surat">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </a>
                                <form action="{{ route('surat_masuk.destroy', $item->id) }}"
                                      method="POST"
                                      class="deleteForm inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-8 h-8 rounded-lg bg-rose-500/10 border border-rose-500/20 text-rose-400 hover:bg-rose-500 hover:text-white hover:border-rose-500 flex items-center justify-center transition-all duration-150"
                                            title="Hapus Surat">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
// SweetAlert konfirmasi hapus surat masuk
document.querySelectorAll('.deleteForm').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Hapus Surat?',
            text: 'Surat akan dipindahkan ke tempat sampah.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#6366f1',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            background: '#0f172a',
            color: '#f8fafc',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});

$(document).ready(function () {
    $('#tableSuratMasuk').DataTable({
        pageLength: 10,
        responsive: true,
        autoWidth: false,
        ordering: true,
        searching: true,
        info: true,
        columnDefs: [
            { orderable: false, targets: [0, 6] },
            { className: 'text-center', targets: [0, 5, 6] },
            { className: 'text-left', targets: [1, 2, 3, 4] },
        ],
        language: {
            search: '🔍 Cari:',
            lengthMenu: 'Tampilkan _MENU_ data',
            info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ surat',
            infoEmpty: 'Tidak ada data',
            zeroRecords: 'Surat masuk tidak ditemukan',
            paginate: {
                previous: '‹',
                next: '›'
            }
        },
    });
});
</script>
@endpush