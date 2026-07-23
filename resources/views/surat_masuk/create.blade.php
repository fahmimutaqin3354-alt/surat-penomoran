<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Surat Masuk
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('surat-masuk.store') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Nomor Agenda --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Agenda</label>
                        <input type="text" name="nomor_agenda"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               placeholder="Otomatis / diisi sistem" readonly>
                    </div>

                    {{-- Tanggal Surat --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Surat</label>
                        <input type="date" name="tanggal_surat"
                               class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    {{-- Pengirim --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pengirim</label>
                        <input type="text" name="pengirim"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               placeholder="Nama instansi/orang pengirim" required>
                    </div>

                    {{-- Perihal --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Perihal</label>
                        <textarea name="perihal" rows="3"
                                  class="w-full border-gray-300 rounded-md shadow-sm"
                                  placeholder="Isi ringkas perihal surat" required></textarea>
                    </div>

                    {{-- Upload Lampiran --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lampiran (PDF)</label>
                        <input type="file" name="lampiran" accept="application/pdf"
                               class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    {{-- Tombol --}}
                    <div class="flex gap-3">
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                            Simpan
                        </button>
                        <a href="{{ route('surat-masuk.create') }}"
                           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md">
                            + Surat Masuk
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>