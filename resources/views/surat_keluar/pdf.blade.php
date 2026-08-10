<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>{{ $surat->jenis_surat }} - {{ $surat->nomor_surat }}</title>
<style>
@page{size:A4;margin:25mm 20mm;}
body{font-family:"Times New Roman",serif;font-size:12pt;color:#000;line-height:1.6}
.kop img{width:100%}
.judul{text-align:center;margin:15px 0}
.judul h2{margin:0;text-decoration:underline;text-transform:uppercase;}
.tanggal{text-align:right;margin:20px 0}
table{width:100%;border-collapse:collapse}
.info td{padding:2px 0;vertical-align:top}
.isi{margin-top:15px;text-align:justify;text-indent:45px;white-space:pre-line}
.ttd{width:40%;margin-left:auto;margin-top:50px;text-align:center}
.ttd-space{height:70px}
.footer{margin-top:40px;font-size:10pt;text-align:center;color:#666}
</style>
</head>
<body>

<div class="kop">
    <img src="{{ public_path('image/kop-surat.png') }}" alt="Kop Surat">
</div>

@php
    $isKuasa = !empty($surat->data_khusus) || (isset($surat->jenisSurat) && $surat->jenisSurat->form_type === 'kuasa') || Str::contains(strtolower($surat->jenis_surat), 'kuasa');
@endphp

@if($isKuasa)
    @php
        $dk = $surat->data_khusus ?? [];
        $pemberi = $dk['pemberi'] ?? [];
        $penerima = $dk['penerima'] ?? [];
        $hal = $dk['hal'] ?? '';
    @endphp

    <div class="judul">
        <h2>SURAT KUASA</h2>
        <p style="margin-top:5px; font-size:11pt;">Nomor: {{ $surat->nomor_surat }}</p>
    </div>

    <p style="margin-top:20px;">Yang bertanda tangan di bawah ini:</p>
    <table class="info" style="margin-left:20px; margin-bottom:15px;">
        <tr><td width="130">Nama</td><td width="15">:</td><td><strong>{{ $pemberi['nama'] ?? '-' }}</strong></td></tr>
        <tr><td>Alamat</td><td>:</td><td>{{ $pemberi['alamat'] ?? '-' }}</td></tr>
        <tr><td>No. KTP</td><td>:</td><td>{{ $pemberi['ktp'] ?? '-' }}</td></tr>
    </table>

    <p>Dengan ini memberikan kuasa penuh kepada:</p>
    <table class="info" style="margin-left:20px; margin-bottom:15px;">
        <tr><td width="130">Nama</td><td width="15">:</td><td><strong>{{ $penerima['nama'] ?? '-' }}</strong></td></tr>
        <tr><td>Alamat</td><td>:</td><td>{{ $penerima['alamat'] ?? '-' }}</td></tr>
        <tr><td>No. KTP</td><td>:</td><td>{{ $penerima['ktp'] ?? '-' }}</td></tr>
    </table>

    <p style="font-weight:bold; margin-top:15px;">Untuk:</p>
    <div style="margin-left:20px; text-align:justify; margin-bottom:20px; white-space:pre-line;">
        {{ $hal }}
    </div>

    <p>Demikian Surat Kuasa ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya.</p>

    <div class="tanggal" style="text-align:right; margin-top:25px;">
        Bandar Lampung, {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}
    </div>

    <table style="width:100%; margin-top:30px; text-align:center;">
        <tr>
            <td width="50%" style="vertical-align:top;">
                <p>Penerima Kuasa,</p>
                <div class="ttd-space"></div>
                <p><strong><u>{{ strtoupper($penerima['nama'] ?? '-') }}</u></strong></p>
            </td>
            <td width="50%" style="vertical-align:top;">
                <p>Pemberi Kuasa,</p>
                <div class="ttd-space"></div>
                <p><strong><u>{{ strtoupper($pemberi['nama'] ?? ($surat->penandatangan ?: '-')) }}</u></strong></p>
            </td>
        </tr>
    </table>
@else
    <div class="judul">
        <h2>SURAT KELUAR</h2>
    </div>

    <div class="tanggal">
        Bandar Lampung,
        {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}
    </div>

    <table class="info">
    <tr><td width="120">Nomor</td><td width="15">:</td><td>{{ $surat->nomor_surat }}</td></tr>
    <tr><td>Lampiran</td><td>:</td><td>{{ $surat->lampiran ?: '-' }}</td></tr>
    <tr><td>Hal</td><td>:</td><td><strong>{{ $surat->perihal }}</strong></td></tr>
    <tr><td>Jenis Surat</td><td>:</td><td>{{ $surat->jenis_surat }}</td></tr>
    </table>

    <p style="margin-top:15px;">Kepada Yth.</p>
    <p><strong>{{ $surat->tujuan }}</strong></p>
    <p>Di Tempat</p>

    <p style="margin-top:15px;">Dengan hormat,</p>

    <div class="isi">
    {{ $surat->isi_surat }}
    </div>

    <p style="margin-top:20px;">
    Demikian surat ini kami sampaikan. Atas perhatian dan kerja sama yang baik kami ucapkan terima kasih.
    </p>

    <div class="ttd">
    <p>Hormat kami,</p>
    <p>PT Microdata Indonesia</p>

    <div class="ttd-space"></div>

    <p><strong>{{ strtoupper($surat->penandatangan) }}</strong></p>
    <p>{{ $surat->jabatan_penandatangan }}</p>
    </div>
@endif

<div class="footer">
<hr>
Dokumen ini dibuat melalui <strong>Sistem Arsip Surat PT Microdata Indonesia</strong>
</div>

</body>
</html>
