<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Preview Surat Keluar</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-200 py-10">

<div class="max-w-4xl mx-auto bg-white shadow-xl">

    <div class="p-12">

        {{-- Kop Surat --}}
        <div class="border-b-4 border-black pb-6">

            <div class="flex items-center">

                <img
                    src="{{ asset('image/logo.jpg') }}"
                    class="w-24 h-24 object-contain mr-6"
                    alt="Logo">

                <div>

                    <h1 class="text-3xl font-bold uppercase">

                        PT Microdata Indonesia

                    </h1>

                    <p>

                        Jl. Contoh Alamat No.123

                    </p>

                    <p>

                        Bandar Lampung

                    </p>

                    <p>

                        Email : info@microdata.co.id

                    </p>

                </div>

            </div>

        </div>

        {{-- Judul --}}
        <div class="text-center mt-8">

            <h2 class="text-2xl font-bold underline">

                SURAT KELUAR

            </h2>

            <p class="mt-2">

                Nomor :
                <span class="font-semibold">

                    {{ $surat->nomor_surat }}

                </span>

            </p>

        </div>

        {{-- Informasi Surat --}}
        <div class="mt-10 space-y-4">

        {{-- Jenis Surat --}}
        <div class="grid grid-cols-4 gap-4">

            <div class="font-semibold">
                Jenis Surat
            </div>

            <div class="col-span-3">
                : {{ $surat->jenis_surat }}
            </div>

        </div>

        {{-- Tanggal --}}
        <div class="grid grid-cols-4 gap-4">

            <div class="font-semibold">
                Tanggal
            </div>

            <div class="col-span-3">
                : {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}
            </div>

        </div>

        {{-- Tujuan --}}
        <div class="grid grid-cols-4 gap-4">

            <div class="font-semibold">
                Tujuan
            </div>

            <div class="col-span-3">
                : {{ $surat->tujuan }}
            </div>

        </div>

        {{-- Lampiran --}}
        <div class="grid grid-cols-4 gap-4">

            <div class="font-semibold">
                Lampiran
            </div>

            <div class="col-span-3">
                : {{ $surat->lampiran ?: '-' }}
            </div>

        </div>

        {{-- Perihal --}}
        <div class="grid grid-cols-4 gap-4">

            <div class="font-semibold">
                Perihal
            </div>

            <div class="col-span-3">
                : {{ $surat->perihal }}
            </div>

        </div>

        {{-- Salam Pembuka --}}
        <div class="mt-10">

            <p>
                Dengan hormat,
            </p>

        </div>

        {{-- Isi Surat --}}
        <div class="mt-6 text-justify leading-8 indent-10 whitespace-pre-line">

            {{ $surat->isi_surat }}

        </div>

        {{-- Salam Penutup --}}
        <div class="mt-10">

            <p>
                Demikian surat ini kami sampaikan. Atas perhatian dan kerja samanya kami ucapkan terima kasih.
            </p>

        </div>
        {{-- Tanda Tangan --}}
        <div class="mt-16 flex justify-end">

            <div class="text-center w-72">

                <p>
                    Bandar Lampung,
                    {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}
                </p>

                <p class="mt-2">
                    Hormat Kami,
                </p>

                {{-- Ruang Tanda Tangan --}}
                <div class="h-24"></div>

                <p class="font-bold underline">

                    {{ $surat->penandatangan }}

                </p>

                <p>

                    {{ $surat->jabatan_penandatangan }}

                </p>

            </div>

        </div>

    </div>

    {{-- Tombol --}}
    <div class="bg-gray-100 border-t p-6 flex justify-center gap-4 print:hidden">

        <button
            onclick="window.print()"
            class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold">

            <i class="fa-solid fa-print"></i>

            Cetak Surat

        </button>

        <a
            href="{{ route('surat_keluar.show', $surat->id) }}"
            class="inline-flex items-center gap-2 px-6 py-3 bg-slate-700 hover:bg-slate-800 text-white rounded-lg font-semibold">

            <i class="fa-solid fa-arrow-left"></i>

            Kembali

        </a>

    </div>

</div>

<style>

@media print{

    body{

        background:white;

    }

    .print\:hidden{

        display:none !important;

    }

    .shadow-xl{

        box-shadow:none !important;

    }

}

</style>

</body>

</html>
