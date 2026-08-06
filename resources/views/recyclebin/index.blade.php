@extends('layouts.app')

@section('title', 'Tempat Sampah')

@section('content')
<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-white">Tempat Sampah</h1>
        <p class="text-slate-400 mt-1">Surat yang sudah dihapus, bisa dipulihkan kembali dari sini.</p>
    </div>

    {{-- Surat Keluar --}}
    <div>
        <h2 class="text-lg font-semibold text-white mb-3">Surat Keluar</h2>

        <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
            <table class="w-full">
                <thead class="bg-slate-800">
                    <tr class="text-left text-slate-300 text-sm">
                        <th class="px-6 py-3">Nomor Surat</th>
                        <th class="px-6 py-3">Perihal</th>
                        <th class="px-6 py-3">Dihapus Pada</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suratKeluar as $item)
                    <tr class="border-t border-slate-800">
                        <td class="px-6 py-4 text-white text-sm font-medium">{{ $item->nomor_surat }}</td>
                        <td class="px-6 py-4 text-slate-300 text-sm">{{ $item->perihal }}</td>
                        <td class="px-6 py-4 text-slate-400 text-sm">{{ $item->deleted_at->format('d-m-Y H:i') }}</td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('recycle-bin.restore.keluar', $item->id) }}" method="POST" class="inline">
                                @csrf
                                <button class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-medium">
                                    Pulihkan
                                </button>
                            </form>
                             <form action="{{ route('recycle-bin.force.keluar', $item->id) }}" method="POST" class="inline deleteForm">
                           @csrf
                             @method('DELETE')
                                  <button type="button" class="px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-xs font-medium">
                                       Hapus Permanen
                                  </button>
                            </form>
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
        <h2 class="text-lg font-semibold text-white mb-3">Surat Masuk</h2>

        <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
            <table class="w-full">
                <thead class="bg-slate-800">
                    <tr class="text-left text-slate-300 text-sm">
                        <th class="px-6 py-3">Nomor Surat</th>
                        <th class="px-6 py-3">Perihal</th>
                        <th class="px-6 py-3">Dihapus Pada</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suratMasuk as $item)
                    <tr class="border-t border-slate-800">
                        <td class="px-6 py-4 text-white text-sm font-medium">{{ $item->nomor_surat }}</td>
                        <td class="px-6 py-4 text-slate-300 text-sm">{{ $item->perihal }}</td>
                        <td class="px-6 py-4 text-slate-400 text-sm">{{ $item->deleted_at->format('d-m-Y H:i') }}</td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('recycle-bin.restore.masuk', $item->id) }}" method="POST" class="inline">
                                @csrf
                                <button class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-medium">
                                    Pulihkan
                                </button>
                            </form>

                             <form action="{{ route('recycle-bin.force.masuk', $item->id) }}" method="POST" class="inline deleteForm">
                                 @csrf
                                 @method('DELETE')
                                <button type="button" class="px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-xs font-medium">
                                    Hapus Permanen
                                </button>
                            </form>
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
        <h2 class="text-lg font-semibold text-white mb-3">Arsip</h2>

        <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
            <table class="w-full">
                <thead class="bg-slate-800">
                    <tr class="text-left text-slate-300 text-sm">
                        <th class="px-6 py-3">Nomor Surat</th>
                        <th class="px-6 py-3">Perihal</th>
                        <th class="px-6 py-3">Dihapus Pada</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($arsip as $item)
                    <tr class="border-t border-slate-800">
                        <td class="px-6 py-4 text-white text-sm font-medium">{{ $item->nomor_surat }}</td>
                        <td class="px-6 py-4 text-slate-300 text-sm">{{ $item->perihal }}</td>
                        <td class="px-6 py-4 text-slate-400 text-sm">{{ $item->deleted_at->format('d-m-Y H:i') }}</td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('recycle-bin.restore.arsip', $item->id) }}" method="POST" class="inline">
                                @csrf
                                <button class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-medium">
                                    Pulihkan
                                </button>
                            </form>
                            <form action="{{ route('recycle-bin.force.arsip', $item->id) }}" method="POST" class="inline deleteForm">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-xs font-medium">
                                    Hapus Permanen
                                </button>
                            </form>
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
            confirmButtonText: 'Ya, Hapus Permanen'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush