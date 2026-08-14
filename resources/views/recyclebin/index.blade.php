@extends('layouts.app')

@section('title', 'Tempat Sampah')

@section('content')
<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-white flex items-center gap-3">
            <span class="w-9 h-9 rounded-xl bg-rose-600/20 border border-rose-500/30 flex items-center justify-center">
                <i class="fa-solid fa-trash-can text-rose-400 text-sm"></i>
            </span>
            Tempat Sampah
        </h1>
        <p class="text-slate-400 mt-1 ml-12">Data yang sudah dihapus sementara dapat dipulihkan kembali dari sini.</p>
    </div>

    {{-- Data Instansi --}}
    <div>
        <h2 class="text-lg font-semibold text-white mb-3 flex items-center gap-2">
            <i class="fa-solid fa-building text-indigo-400 text-sm"></i>
            Data Instansi
        </h2>

        <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-lg">
            <table class="w-full text-sm">
                <thead class="bg-slate-800/80">
                    <tr class="text-left text-slate-300">
                        <th class="px-6 py-3">Kode Instansi</th>
                        <th class="px-6 py-3">Nama Instansi</th>
                        <th class="px-6 py-3">Dihapus Pada</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($instansi as $item)
                    <tr class="border-t border-slate-800/80 hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-4 font-mono font-semibold text-indigo-400">{{ $item->kode_instansi }}</td>
                        <td class="px-6 py-4 text-white font-medium">{{ $item->nama_instansi }}</td>
                        <td class="px-6 py-4 text-slate-400">{{ $item->deleted_at->format('d-m-Y H:i') }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('recycle-bin.restore.instansi', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-medium transition-all">
                                        Pulihkan
                                    </button>
                                </form>
                                <form action="{{ route('recycle-bin.force.instansi', $item->id) }}" method="POST" class="inline deleteForm">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-500 text-white text-xs font-medium transition-all">
                                        Hapus Permanen
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-8 text-slate-400 text-sm">
                            Tidak ada data instansi di tempat sampah.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Data Jenis Surat --}}
    <div>
        <h2 class="text-lg font-semibold text-white mb-3 flex items-center gap-2">
            <i class="fa-solid fa-tags text-indigo-400 text-sm"></i>
            Data Jenis Surat
        </h2>

        <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-lg">
            <table class="w-full text-sm">
                <thead class="bg-slate-800/80">
                    <tr class="text-left text-slate-300">
                        <th class="px-6 py-3">Kode Surat</th>
                        <th class="px-6 py-3">Nama Jenis Surat</th>
                        <th class="px-6 py-3">Dihapus Pada</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jenisSurat as $item)
                    <tr class="border-t border-slate-800/80 hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-4 font-mono font-semibold text-indigo-400">{{ $item->kode_surat }}</td>
                        <td class="px-6 py-4 text-white font-medium">{{ $item->nama }}</td>
                        <td class="px-6 py-4 text-slate-400">{{ $item->deleted_at->format('d-m-Y H:i') }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('recycle-bin.restore.jenis_surat', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-medium transition-all">
                                        Pulihkan
                                    </button>
                                </form>
                                <form action="{{ route('recycle-bin.force.jenis_surat', $item->id) }}" method="POST" class="inline deleteForm">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-500 text-white text-xs font-medium transition-all">
                                        Hapus Permanen
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-8 text-slate-400 text-sm">
                            Tidak ada data jenis surat di tempat sampah.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Surat Keluar --}}
    <div>
        <h2 class="text-lg font-semibold text-white mb-3 flex items-center gap-2">
            <i class="fa-solid fa-paper-plane text-indigo-400 text-sm"></i>
            Surat Keluar
        </h2>

        <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-lg">
            <table class="w-full text-sm">
                <thead class="bg-slate-800/80">
                    <tr class="text-left text-slate-300">
                        <th class="px-6 py-3">Nomor Surat</th>
                        <th class="px-6 py-3">Perihal</th>
                        <th class="px-6 py-3">Dihapus Pada</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suratKeluar as $item)
                    <tr class="border-t border-slate-800/80 hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-4 text-white font-medium">{{ $item->nomor_surat }}</td>
                        <td class="px-6 py-4 text-slate-300">{{ $item->perihal }}</td>
                        <td class="px-6 py-4 text-slate-400">{{ $item->deleted_at->format('d-m-Y H:i') }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('recycle-bin.restore.keluar', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-medium transition-all">
                                        Pulihkan
                                    </button>
                                </form>
                                <form action="{{ route('recycle-bin.force.keluar', $item->id) }}" method="POST" class="inline deleteForm">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-500 text-white text-xs font-medium transition-all">
                                        Hapus Permanen
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-8 text-slate-400 text-sm">
                            Tidak ada surat keluar di tempat sampah.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Surat Masuk --}}
    <div>
        <h2 class="text-lg font-semibold text-white mb-3 flex items-center gap-2">
            <i class="fa-solid fa-inbox text-indigo-400 text-sm"></i>
            Surat Masuk
        </h2>

        <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-lg">
            <table class="w-full text-sm">
                <thead class="bg-slate-800/80">
                    <tr class="text-left text-slate-300">
                        <th class="px-6 py-3">Nomor Surat</th>
                        <th class="px-6 py-3">Perihal</th>
                        <th class="px-6 py-3">Dihapus Pada</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suratMasuk as $item)
                    <tr class="border-t border-slate-800/80 hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-4 text-white font-medium">{{ $item->nomor_surat }}</td>
                        <td class="px-6 py-4 text-slate-300">{{ $item->perihal }}</td>
                        <td class="px-6 py-4 text-slate-400">{{ $item->deleted_at->format('d-m-Y H:i') }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('recycle-bin.restore.masuk', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-medium transition-all">
                                        Pulihkan
                                    </button>
                                </form>
                                <form action="{{ route('recycle-bin.force.masuk', $item->id) }}" method="POST" class="inline deleteForm">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-500 text-white text-xs font-medium transition-all">
                                        Hapus Permanen
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-8 text-slate-400 text-sm">
                            Tidak ada surat masuk di tempat sampah.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Arsip --}}
    <div>
        <h2 class="text-lg font-semibold text-white mb-3 flex items-center gap-2">
            <i class="fa-solid fa-box-archive text-indigo-400 text-sm"></i>
            Arsip
        </h2>

        <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-lg">
            <table class="w-full text-sm">
                <thead class="bg-slate-800/80">
                    <tr class="text-left text-slate-300">
                        <th class="px-6 py-3">Nomor Surat</th>
                        <th class="px-6 py-3">Perihal</th>
                        <th class="px-6 py-3">Dihapus Pada</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($arsip as $item)
                    <tr class="border-t border-slate-800/80 hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-4 text-white font-medium">{{ $item->nomor_surat }}</td>
                        <td class="px-6 py-4 text-slate-300">{{ $item->perihal }}</td>
                        <td class="px-6 py-4 text-slate-400">{{ $item->deleted_at->format('d-m-Y H:i') }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('recycle-bin.restore.arsip', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-medium transition-all">
                                        Pulihkan
                                    </button>
                                </form>
                                <form action="{{ route('recycle-bin.force.arsip', $item->id) }}" method="POST" class="inline deleteForm">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-500 text-white text-xs font-medium transition-all">
                                        Hapus Permanen
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-8 text-slate-400 text-sm">
                            Tidak ada arsip di tempat sampah.
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
    const btn = form.querySelector('button[type="button"]');

    btn.addEventListener('click', function () {
        Swal.fire({
            title: 'Hapus permanen?',
            text: 'Data dan file ini akan hilang selamanya, tidak bisa dipulihkan lagi.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#6366f1',
            confirmButtonText: 'Ya, Hapus Permanen',
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
</script>
@endpush