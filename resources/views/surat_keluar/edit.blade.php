@extends('layouts.app')

@section('title','Tambah Surat Keluar')

@section('content')

<h4 class="text-xl font-semibold text-gray-800 mb-4">Edit Surat Keluar</h4>

<div class="w-full px-4 py-6">

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

        <div class="bg-blue-600 text-white rounded-t-xl px-6 py-4">

            <h4 class="text-lg font-semibold mb-0">

                Tambah Surat Keluar

            </h4>

        </div>

        <div class="p-6">

            <form>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">

                    <div class="md:col-span-6">

                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Surat</label>

                        <input type="text"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                    </div>

                    <div class="md:col-span-6">

                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Surat</label>

                        <input type="date"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                    </div>

                    <div class="md:col-span-6">

                        <label class="block text-sm font-medium text-gray-700 mb-1">Tujuan</label>

                        <input type="text"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                    </div>

                    <div class="md:col-span-6">

                        <label class="block text-sm font-medium text-gray-700 mb-1">Perihal</label>

                        <input type="text"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                    </div>

                    <div class="md:col-span-12">

                        <label class="block text-sm font-medium text-gray-700 mb-1">Isi Surat</label>

                        <textarea rows="5"
                                  class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>

                    </div>

                    <div class="md:col-span-12">

                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload File PDF</label>

                        <input type="file"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-900 file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                    </div>

                </div>

                <div class="mt-6 flex items-center gap-3">

                    <button class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-white font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">

                        <i class="bi bi-save"></i>

                        Simpan

                    </button>

                    <a href="{{ route('surat_keluar.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg bg-gray-200 px-4 py-2 text-gray-700 font-medium hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-colors">

                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection