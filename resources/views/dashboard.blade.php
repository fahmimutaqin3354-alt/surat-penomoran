<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Cards Ringkasan --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Total Surat Masuk</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">0</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Total Surat Keluar</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">0</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Surat Bulan Ini</p>
                    <p class="text-3xl font-bold text-orange-600 mt-2">0</p>
                </div>

            </div>

            {{-- Menu Cepat --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Menu Cepat</h3>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('surat-masuk.create')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        + Surat Masuk
                    </a>
                    <a href="{{ route('surat-keluar.create')" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                        + Surat Keluar
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>