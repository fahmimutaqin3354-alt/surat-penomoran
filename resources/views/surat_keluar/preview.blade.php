<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Preview Surat Keluar</title>

    {{-- Font Awesome --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{

            background:#d6d6d6;
            font-family:"Times New Roman", serif;

        }

        /* ==========================
           Toolbar
        ========================== */

        .toolbar{

            width:210mm;

            margin:30px auto 15px;

            display:flex;

            justify-content:flex-end;

            gap:12px;

        }

        /* ==========================
           Tombol
        ========================== */

        .btn{

            padding:12px 24px;

            border-radius:8px;

            color:white;

            font-weight:bold;

            text-decoration:none;

            transition:.3s;

            display:flex;

            align-items:center;

            gap:8px;

        }

        .btn-print{

            background:#4f46e5;

        }

        .btn-print:hover{

            background:#3730a3;

        }

        .btn-back{

            background:#334155;

        }

        .btn-back:hover{

            background:#1e293b;

        }

        /* ==========================
           Kertas A4
        ========================== */

        .paper{

            width:210mm;

            min-height:297mm;

            background:white;

            margin:auto;

            padding:25mm;

            box-shadow:0 0 20px rgba(0,0,0,.2);

        }

        /* ==========================
           Judul
        ========================== */

        .title{

            text-align:center;

            margin-top:30px;

        }

        .title h2{

            font-size:28px;

            font-weight:bold;

            text-transform:uppercase;

            text-decoration:underline;

        }

        .title p{

            margin-top:10px;

            font-size:18px;

        }

        /* ==========================
           Print
        ========================== */

        @page{

            size:A4;

            margin:20mm;

        }

        @media print{

            body{

                background:white;

            }

            .toolbar{

                display:none;

            }

            .paper{

                width:100%;

                min-height:auto;

                margin:0;

                padding:0;

                box-shadow:none;

            }

        }

    </style>

</head>

<body>

    {{-- Toolbar --}}
    <div class="toolbar">

        <button
            onclick="window.print()"
            class="btn btn-print">

            <i class="fa-solid fa-print"></i>

            Cetak Surat

        </button>

        <a
            href="{{ route('surat_keluar.show',$surat->id) }}"
            class="btn btn-back">

            <i class="fa-solid fa-arrow-left"></i>

            Kembali

        </a>

    </div>

    {{-- Awal Kertas --}}
    <div class="paper">

    {{-- ==========================
         KOP SURAT
    =========================== --}}

    <table style="width:100%; border-bottom:4px solid black; padding-bottom:15px;">

        <tr>

            {{-- Logo --}}
            <td style="width:110px; text-align:center;">

                <img
                    src="{{ asset('image/logo.jpg') }}"
                    alt="Logo PT Microdata"
                    style="width:90px; height:90px; object-fit:contain;">

            </td>

            {{-- Identitas Perusahaan --}}
            <td style="text-align:center;">

                <h1 style="
                    font-size:28px;
                    font-weight:bold;
                    text-transform:uppercase;
                    margin-bottom:5px;
                ">
                    PT MICRODATA INDONESIA
                </h1>

                <p style="font-size:16px;">
                    Jl. Contoh Alamat No.123, Bandar Lampung
                </p>

                <p style="font-size:16px;">
                    Telp. (0721) 123456
                </p>

                <p style="font-size:16px;">
                    Email : info@microdata.co.id
                </p>

                <p style="font-size:16px;">
                    Website : www.microdata.co.id
                </p>

            </td>

        </tr>

    </table>

    {{-- Judul Surat --}}
    <div class="title">

        <h2>
            Surat Keluar
        </h2>

        <p>

            Nomor :
            <strong>

                {{ $surat->nomor_surat }}

            </strong>

        </p>

    </div>

    {{-- Awal Isi Surat --}}
    <div style="margin-top:45px;">

            {{-- Tanggal Surat --}}
    <div style="text-align:right; font-size:18px; margin-bottom:35px;">

        Bandar Lampung,
        {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}

    </div>

    {{-- Informasi Surat --}}
    <table style="width:100%; font-size:18px; border-collapse:collapse;">

        <tr>

            <td style="width:140px; padding:4px 0;">
                Nomor
            </td>

            <td style="width:15px;">
                :
            </td>

            <td>
                {{ $surat->nomor_surat }}
            </td>

        </tr>

        <tr>

            <td style="padding:4px 0;">
                Lampiran
            </td>

            <td>
                :
            </td>

            <td>
                {{ $surat->lampiran ?: '-' }}
            </td>

        </tr>

        <tr>

            <td style="padding:4px 0;">
                Perihal
            </td>

            <td>
                :
            </td>

            <td>

                <strong>
                    {{ $surat->perihal }}
                </strong>

            </td>

        </tr>

        <tr>

            <td style="padding:4px 0;">
                Jenis Surat
            </td>

            <td>
                :
            </td>

            <td>
                {{ $surat->jenis_surat }}
            </td>

        </tr>

    </table>

    {{-- Tujuan Surat --}}
    <div style="margin-top:45px; font-size:18px; line-height:32px;">

        <p>

            Kepada Yth.

        </p>

        <p style="font-weight:bold;">

            {{ $surat->tujuan }}

        </p>

        <p>

            Di Tempat

        </p>

    </div>

    {{-- Salam Pembuka --}}
    <div style="margin-top:35px; font-size:18px;">

        Dengan hormat,

    </div>

    {{-- Isi Surat --}}
    <div
        style="
            margin-top:25px;
            font-size:18px;
            line-height:36px;
            text-align:justify;
            text-indent:55px;
            white-space:pre-line;
        ">

        {{ $surat->isi_surat }}

    </div>

    {{-- Penutup --}}
    <div
        style="
            margin-top:35px;
            font-size:18px;
            line-height:34px;
            text-align:justify;
        ">

        Demikian surat ini kami sampaikan. Atas perhatian dan kerja sama yang baik, kami mengucapkan terima kasih.

    </div>

    {{-- Awal Tanda Tangan --}}
    <div style="margin-top:70px;">

            {{-- ==========================
         TANDA TANGAN
    =========================== --}}

    <table style="width:100%;">

        <tr>

            <td style="width:55%;"></td>

            <td style="width:45%; text-align:center;">

                <p style="font-size:18px;">
                    Hormat kami,
                </p>

                <p style="font-size:18px; margin-top:5px;">
                    PT Microdata Indonesia
                </p>

                {{-- Ruang tanda tangan --}}
                <div style="height:110px;"></div>

                <p style="
                    font-size:20px;
                    font-weight:bold;
                    text-transform:uppercase;
                    text-decoration:underline;
                ">

                    {{ strtoupper($surat->penandatangan) }}

                </p>

                <p style="
                    font-size:18px;
                    margin-top:6px;
                ">

                    {{ $surat->jabatan_penandatangan }}

                </p>

            </td>

        </tr>

    </table>


    {{-- ==========================
         FOOTER
    =========================== --}}

    <div
        style="
            margin-top:70px;
            border-top:1px solid #999;
            padding-top:12px;
            text-align:center;
            color:#666;
            font-size:14px;
        ">

        Dokumen ini dibuat melalui
        <strong>Sistem Arsip Surat PT Microdata Indonesia</strong>.

    </div>

</div>

</body>

</html>
