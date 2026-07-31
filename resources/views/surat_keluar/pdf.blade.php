<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Surat Keluar</title>
<style>
@page{size:A4;margin:25mm 20mm;}
body{font-family:"Times New Roman",serif;font-size:12pt;color:#000;line-height:1.7}
.kop img{width:100%}
.judul{text-align:center;margin:20px 0}
.judul h2{margin:0;text-decoration:underline}
.tanggal{text-align:right;margin:20px 0}
table{width:100%;border-collapse:collapse}
.info td{padding:2px 0;vertical-align:top}
.isi{margin-top:20px;text-align:justify;text-indent:45px;white-space:pre-line}
.ttd{width:40%;margin-left:auto;margin-top:60px;text-align:center}
.ttd-space{height:80px}
.footer{margin-top:50px;font-size:10pt;text-align:center;color:#666}
</style>
</head>
<body>

<div class="kop">
    <img src="{{ public_path('image/kop-surat.png') }}" alt="Kop Surat">
</div>

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

<p>Kepada Yth.</p>
<p><strong>{{ $surat->tujuan }}</strong></p>
<p>Di Tempat</p>

<p>Dengan hormat,</p>

<div class="isi">
{{ $surat->isi_surat }}
</div>

<p style="margin-top:25px">
Demikian surat ini kami sampaikan. Atas perhatian dan kerja sama yang baik kami ucapkan terima kasih.
</p>

<div class="ttd">
<p>Hormat kami,</p>
<p>PT Microdata Indonesia</p>

<div class="ttd-space"></div>

<p><strong>{{ strtoupper($surat->penandatangan) }}</strong></p>
<p>{{ $surat->jabatan_penandatangan }}</p>
</div>

<div class="footer">
<hr>
Dokumen ini dibuat melalui <strong>Sistem Arsip Surat PT Microdata Indonesia</strong>
</div>

</body>
</html>
