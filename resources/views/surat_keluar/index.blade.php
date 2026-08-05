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
                        placeholder="Cari nomor surat, tujuan atau perihal..."
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
                Ada <span class="font-semibold">{{ $jumlahDihapus }} surat keluar</span> yang sudah dihapus dan menunggu di tempat sampah.
            </p>
        </div>
        <a href="{{ route('recycle-bin.index') }}"
           class="text-sm font-semibold text-amber-400 hover:text-amber-300 whitespace-nowrap">
            Lihat Tempat Sampah →
        </a>
    </div>
    @endif
    
    {{-- Tabel --}}
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-800">

                    <tr class="text-left text-slate-300">

                        <th class="px-6 py-4">No</th>

                        <th class="px-6 py-4">Nomor Surat</th>

                        <th class="px-6 py-4">Tanggal</th>

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

                        <td class="px-6 py-4 text-slate-300">

                            {{ $loop->iteration + ($surat->currentPage()-1) * $surat->perPage() }}

                        </td>

                        <td class="px-6 py-4 font-semibold text-white">

                            {{ $item->nomor_surat }}

                        </td>

                        <td class="px-6 py-4 text-slate-300">

                            {{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d-m-Y') }}

                        </td>

                        <td class="px-6 py-4 text-slate-300">

                            {{ $item->jenis_surat }}

                        </td>

                        <td class="px-6 py-4 text-slate-300">

                            {{ Str::limit($item->tujuan,30) }}

                        </td>

                        <td class="px-6 py-4 text-slate-300">

                            {{ Str::limit($item->perihal,35) }}

                        </td>

                        <td class="px-6 py-4">

                            @if($item->status=='Draft')

                                <span class="px-3 py-1 rounded-full text-xs bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">

                                    Draft

                                </span>

                            @elseif($item->status=='Dikirim')

                                <span class="px-3 py-1 rounded-full text-xs bg-blue-500/20 text-blue-400 border border-blue-500/30">

                                    Dikirim

                                </span>

                            @else

                                <span class="px-3 py-1 rounded-full text-xs bg-green-500/20 text-green-400 border border-green-500/30">

                                    Selesai

                                </span>

                            @endif

                        </td>

                        <td class="px-6 py-4">

                            <div class="flex justify-center gap-2">

                                <a href="{{ route('surat_keluar.show',$item->id) }}"
                                   class="w-9 h-9 rounded-lg bg-cyan-600 hover:bg-cyan-700 flex items-center justify-center">

                                    <i class="fa-solid fa-eye text-white text-sm"></i>

                                </a>

                              
                                <a href="{{ route('surat_keluar.preview',$item->id) }}"
                                   class="w-9 h-9 rounded-lg bg-indigo-600 hover:bg-indigo-700 flex items-center justify-center">

                                    <i class="fa-solid fa-file-lines text-white text-sm"></i>

                                </a>

                                 {{-- Tombol Ekspor (baru) --}}
                                  <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                                  <button type="button" @click="open = !open"
                                   class="w-9 h-9 rounded-lg bg-violet-600 hover:bg-violet-700 flex items-center justify-center">
                                  <i class="fa-solid fa-share-nodes text-white text-sm"></i>
                                  </button>

                                   <div x-show="open" x-cloak
                                     class="absolute right-0 mt-2 w-48 bg-slate-900 border border-slate-800 rounded-xl shadow-lg z-20 overflow-hidden py-1">

                                   <button type="button" @click="$dispatch('open-modal-email-surat-{{ $item->id }}'); open = false"
                                   class="flex items-center gap-2 w-full text-left px-4 py-2.5 text-sm text-slate-300 hover:bg-slate-800">
                                    <i class="fa-solid fa-envelope text-slate-500 w-4"></i>
                                    Kirim ke Email
                                    </button>
                                  <button type="button" @click="$dispatch('open-modal-wa-surat-{{ $item->id }}'); open = false"
                                    class="flex items-center gap-2 w-full text-left px-4 py-2.5 text-sm text-slate-300 hover:bg-slate-800">
                                    <i class="fa-brands fa-whatsapp text-slate-500 w-4"></i>
                                    Kirim ke WhatsApp
                                 </button>
                          </div>
                     </div>

                                <form
                                    action="{{ route('surat_keluar.destroy',$item->id) }}"
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

                     {{-- Modal Ekspor untuk surat ini --}}
                    <div x-data="{ show: false }"
                        @open-modal-email-surat-{{ $item->id }}.window="show = true"
                        x-show="show" x-cloak
                        class="fixed inset-0 z-50 flex items-center justify-center p-4">

                        <div class="absolute inset-0 bg-black/60" @click="show = false"></div>

                        <div class="relative bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-sm p-6">
                            <h3 class="text-base font-semibold text-white mb-1">Kirim Surat via Email</h3>
                            <p class="text-sm text-slate-400 mb-4">
                                Masukkan alamat email tujuan, surat ini akan langsung dikirim beserta lampiran PDF-nya.
                            </p>

                            <form action="{{ route('surat_keluar.send.email', $item->id) }}" method="POST">
                                @csrf

                                <label class="block text-sm font-medium text-slate-300 mb-1">Alamat Email</label>
                                <input type="email" name="email" required placeholder="nama@contoh.com"
                                    class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 mb-4">

                                <p class="text-xs text-slate-500 mb-4">
                                    <i class="fa-solid fa-paperclip mr-1"></i>
                                    File PDF surat ini akan otomatis dilampirkan.
                                    <a href="{{ URL::temporarySignedRoute('surat_keluar.download.public', now()->addHours(24), ['id' => $item->id]) }}"
                                       target="_blank"
                                       class="text-indigo-400 hover:text-indigo-300 underline font-medium">
                                        Lihat file PDF
                                    </a>
                                </p>

                                <div class="flex justify-end gap-2 mt-2">
                                    <button type="button" @click="show = false"
                                        class="px-4 py-2 rounded-xl text-sm text-slate-400 hover:bg-slate-800 transition">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition">
                                        Kirim
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                   <div x-data="{ show: false }"
    @open-modal-wa-surat-{{ $item->id }}.window="show = true"
    x-show="show" x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <div class="absolute inset-0 bg-black/60" @click="show = false"></div>

    <div class="relative bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-sm p-6">
        <h3 class="text-base font-semibold text-white mb-1">Kirim Surat ke WhatsApp</h3>
        <p class="text-sm text-slate-400 mb-4">
            Surat akan langsung dikirim otomatis beserta file PDF-nya.
        </p>

        <form action="{{ route('surat_keluar.send.whatsapp', $item->id) }}" method="POST">
            @csrf

            <label class="block text-sm font-medium text-slate-300 mb-1">Nomor WhatsApp</label>
            <input type="text" name="nomor_wa" required placeholder="08xxxxxxxxxx"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 mb-4">

            <div class="flex justify-end gap-2">
                <button type="button" @click="show = false"
                    class="px-4 py-2 rounded-xl text-sm text-slate-400 hover:bg-slate-800 transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 transition">
                    Kirim
                </button>
            </div>
        </form>
    </div>
</div>

                @empty

                    <tr>

                        <td colspan="8"
                            class="text-center py-12 text-slate-400">

                            <i class="fa-regular fa-folder-open text-5xl mb-4 block"></i>

                            Belum ada data surat keluar.

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
