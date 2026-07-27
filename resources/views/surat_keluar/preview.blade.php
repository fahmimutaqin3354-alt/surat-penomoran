<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Surat</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background:#dcdcdc;
            font-family:'Times New Roman', serif;
        }

        .toolbar{
            width:210mm;
            margin:20px auto 10px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .paper{
            width:210mm;
            min-height:297mm;
            background:#fff;
            margin:auto;
            padding:35px 45px;
            box-shadow:0 0 20px rgba(0,0,0,.25);
        }

        .kop{
            display:flex;
            align-items:center;
        }

        .logo{
            width:95px;
            margin-right:20px;
        }

        .company{
            flex:1;
            text-align:center;
        }

        .company h2{
            margin:0;
            font-weight:bold;
        }

        .company h4{
            margin:0;
            font-weight:bold;
        }

        .company p{
            margin:0;
            font-size:14px;
        }

        .line{
            border-top:4px solid #000;
            border-bottom:2px solid #000;
            margin:12px 0 30px;
        }

        .info{
            width:100%;
            margin-bottom:25px;
        }

        .info td{
            padding:3px;
            vertical-align:top;
        }

        .isi{
            text-align:justify;
            line-height:1.8;
        }

        .ttd{
            width:280px;
            margin-left:auto;
            text-align:center;
            margin-top:60px;
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
                margin:0;
                box-shadow:none;
                padding:20px;
            }

        }

    </style>

</head>
<body>

<div class="toolbar">

    <div>

        <a href="{{ route('surat_keluar.index') }}"
           class="btn btn-secondary">

            ← Kembali

        </a>

        <a href="{{ route('surat_keluar.edit',$surat->id) }}"
           class="btn btn-warning">

            Edit

        </a>

    </div>

    <button onclick="window.print()"
            class="btn btn-primary">

        🖨 Cetak

    </button>

</div>

<div class="paper">

    <div class="kop">

        <img src="{{ asset('image/logo.jpg') }}"
             class="logo">

        <div class="company">

            <h2>PT MICRODATA INDONESIA</h2>

            <h4>Sistem Arsip Surat</h4>

            <p>
                Jl. ZA Pagar Alam No. 9 Bandar Lampung
            </p>

            <p>
                www.microdata.co.id
            </p>

        </div>

    </div>

    <div class="line"></div>

    <table class="info">

        <tr>
            <td width="130">Nomor</td>
            <td width="15">:</td>
            <td>{{ $surat->nomor_surat }}</td>
        </tr>

        <tr>
            <td>Lampiran</td>
            <td>:</td>
            <td>{{ $surat->lampiran ?: '-' }}</td>
        </tr>

        <tr>
            <td>Perihal</td>
            <td>:</td>
            <td><strong>{{ $surat->perihal }}</strong></td>
        </tr>

    </table>

    <div style="text-align:right">

        Bandar Lampung,
        {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}

    </div>

    <br>

    <p>

        Kepada Yth.

        <br>

        <strong>{{ $surat->tujuan }}</strong>

        <br>

        Di Tempat

    </p>

    <br>

    <div class="isi">

        <p>Dengan hormat,</p>

        <p>

            {!! nl2br(e($surat->isi_surat)) !!}

        </p>

        <p>

            Demikian surat ini kami sampaikan.
            Atas perhatian dan kerja sama yang baik,
            kami ucapkan terima kasih.

        </p>

    </div>

    <div class="ttd">

        Bandar Lampung,
        {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}

        <br><br><br><br><br>

        <strong>

            {{ $surat->penandatangan }}

        </strong>

        <br>

        {{ $surat->jabatan_penandatangan }}

    </div>

</div>

</body>
</html>
