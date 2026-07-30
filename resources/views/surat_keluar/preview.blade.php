<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Preview Surat Keluar</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>

        @page{
            size:A4;
            margin:20mm;
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{

            background:#d1d5db;
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

        .btn{

            display:inline-flex;
            align-items:center;
            gap:8px;

            padding:12px 22px;

            border-radius:8px;

            color:white;
            text-decoration:none;
            font-weight:bold;

            transition:.3s;

        }

        .btn-print{

            background:#4f46e5;

        }

        .btn-print:hover{

            background:#3730a3;

        }

        .btn-pdf{

            background:#dc2626;

        }

        .btn-pdf:hover{

            background:#b91c1c;

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

            box-shadow:0 0 15px rgba(0,0,0,.15);

        }

        table{

            width:100%;
            border-collapse:collapse;

        }

        td{

            vertical-align:top;

        }

        /* ==========================
           Print
        ========================== */

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

    {{-- ==========================
         TOOLBAR
    =========================== --}}

    <div class="toolbar">

        <button
            onclick="window.print()"
            class="btn btn-print">

            <i class="fa-solid fa-print"></i>

            Cetak

        </button>

        <a
            href="{{ route('surat_keluar.pdf',$surat->id) }}"
            class="btn btn-pdf">

            <i class="fa-solid fa-file-pdf"></i>

            Download PDF

        </a>

        <a
            href="{{ route('surat_keluar.show',$surat->id) }}"
            class="btn btn-back">

            <i class="fa-solid fa-arrow-left"></i>

            Kembali

        </a>

    </div>

    {{-- ==========================
         KERTAS A4
    =========================== --}}

    <div class="paper">
    {{-- ==========================================
         KOP SURAT
    =========================================== --}}

    <div style="margin-bottom:25px;">

        <img
            src="{{ asset('image/kop-surat.png') }}"
            alt="Kop Surat"
            style="width:100%; height:auto; display:block;">

    </div>

    {{-- ==========================================
         JUDUL SURAT
    =========================================== --}}

    <div style="text-align:center; margin-bottom:40px;">

        <h2 style="
            font-size:24px;
            font-weight:bold;
            text-transform:uppercase;
            text-decoration:underline;
        ">

            SURAT KELUAR

        </h2>

    </div>

    {{-- ==========================================
         TANGGAL
    =========================================== --}}

    <div style="
        text-align:right;
        font-size:18px;
        margin-bottom:30px;
    ">

        Bandar Lampung,
        {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}

    </div>

    {{-- ==========================================
         INFORMASI SURAT
    =========================================== --}}

    <table style="font-size:18px; margin-bottom:35px;">

        <tr>

            <td style="width:140px;">
                Nomor
            </td>

            <td style="width:20px;">
                :
            </td>

            <td>

                {{ $surat->nomor_surat }}

            </td>

        </tr>

        <tr>

            <td style="padding-top:6px;">
                Lampiran
            </td>

            <td style="padding-top:6px;">
                :
            </td>

            <td style="padding-top:6px;">

                {{ $surat->lampiran ?: '-' }}

            </td>

        </tr>

        <tr>

            <td style="padding-top:6px;">
                Hal
            </td>

            <td style="padding-top:6px;">
                :
            </td>

            <td style="padding-top:6px;">

                <strong>

                    {{ $surat->perihal }}

                </strong>

            </td>

        </tr>

        <tr>

            <td style="padding-top:6px;">
                Jenis Surat
            </td>

            <td style="padding-top:6px;">
                :
            </td>

            <td style="padding-top:6px;">

                {{ $surat->jenis_surat }}

            </td>

        </tr>

    </table>

    {{-- ==========================================
         TUJUAN SURAT
    =========================================== --}}

    <div style="
        font-size:18px;
        line-height:32px;
        margin-bottom:35px;
    ">

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
    {{-- ==========================================
         SALAM PEMBUKA
    =========================================== --}}

    <div style="
        font-size:18px;
        margin-bottom:25px;
    ">

        Dengan hormat,

    </div>

    {{-- ==========================================
         ISI SURAT
    =========================================== --}}

    <div style="
        font-size:18px;
        line-height:34px;
        text-align:justify;
        text-indent:55px;
        white-space:pre-line;
    ">

        {{ $surat->isi_surat }}

    </div>

    {{-- ==========================================
         PENUTUP
    =========================================== --}}

    <div style="
        margin-top:35px;
        font-size:18px;
        line-height:34px;
        text-align:justify;
    ">

        Demikian surat ini kami sampaikan. Atas perhatian dan kerja sama yang baik, kami mengucapkan terima kasih.

    </div>

    {{-- ==========================================
         TANDA TANGAN
    =========================================== --}}

    <table style="
        width:100%;
        margin-top:70px;
    ">

        <tr>

            <td style="width:60%;"></td>

            <td style="
                width:40%;
                text-align:center;
                font-size:18px;
            ">

                <p>

                    Hormat kami,

                </p>

                <p style="margin-top:5px;">

                    PT Microdata Indonesia

                </p>

                {{-- Ruang Tanda Tangan --}}
                <div style="height:90px;"></div>

                <p style="
                    font-weight:bold;
                    text-transform:uppercase;
                    text-decoration:underline;
                    font-size:20px;
                ">

                    {{ strtoupper($surat->penandatangan) }}

                </p>

                <p style="margin-top:5px;">

                    {{ $surat->jabatan_penandatangan }}

                </p>

            </td>

        </tr>

    </table>

    {{-- ==========================================
         FOOTER
    =========================================== --}}

    <div style="
        margin-top:80px;
        border-top:1px solid #999;
        padding-top:10px;
        text-align:center;
        color:#666;
        font-size:14px;
    ">

        Dokumen ini dibuat melalui
        <strong>Sistem Arsip Surat PT Microdata Indonesia</strong>

    </div>

</div>

</body>

</html>
