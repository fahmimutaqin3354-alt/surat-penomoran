<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Surat</title>
    <style>
        @page { margin: 28px 32px; }

        body {
            font-family: 'Helvetica', Arial, sans-serif;
            color: #1f2937;
            font-size: 12px;
        }

        .header {
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
            margin-bottom: 16px;
        }

        .header h1 {
            font-size: 18px;
            color: #1e40af;
            margin: 0 0 2px 0;
        }

        .header p {
            margin: 0;
            color: #6b7280;
            font-size: 11px;
        }

        .periode {
            margin: 10px 0 16px 0;
            font-size: 11px;
            color: #374151;
        }

        .summary {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .summary td {
            width: 20%;
            text-align: center;
            border: 1px solid #e5e7eb;
            padding: 10px 4px;
        }

        .summary .label {
            display: block;
            font-size: 10px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .summary .value {
            display: block;
            font-size: 18px;
            font-weight: bold;
            color: #111827;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data th {
            background-color: #2563eb;
            color: #ffffff;
            text-align: left;
            padding: 6px 8px;
            font-size: 10px;
            text-transform: uppercase;
        }

        table.data td {
            padding: 6px 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
        }

        table.data tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 8px;
            font-size: 10px;
            background-color: #dcfce7;
            color: #15803d;
        }

        .footer {
            margin-top: 24px;
            font-size: 9px;
            color: #9ca3af;
            text-align: right;
        }

        .empty {
            text-align: center;
            color: #9ca3af;
            padding: 20px 0;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Surat — Sistem Arsip Surat</h1>
        <p>PT Microdata Indonesia</p>
    </div>

    <div class="periode">
        Periode:
        <strong>
            {{ \Carbon\Carbon::parse($periode['mulai'])->translatedFormat('d M Y') }}
            s.d
            {{ \Carbon\Carbon::parse($periode['akhir'])->translatedFormat('d M Y') }}
        </strong>
        &nbsp;•&nbsp; Dicetak: {{ now()->translatedFormat('d M Y, H:i') }}
    </div>

    <table class="summary">
        <tr>
            <td>
                <span class="label">Total Surat</span>
                <span class="value">{{ $ringkasan['totalSurat'] }}</span>
            </td>
            <td>
                <span class="label">Surat Masuk</span>
                <span class="value">{{ $ringkasan['suratMasuk'] }}</span>
            </td>
            <td>
                <span class="label">Surat Keluar</span>
                <span class="value">{{ $ringkasan['suratKeluar'] }}</span>
            </td>
            <td>
                <span class="label">Arsip</span>
                <span class="value">{{ $ringkasan['arsip'] }}</span>
            </td>
            <td>
                <span class="label">Disposisi</span>
                <span class="value">{{ $ringkasan['disposisi'] }}</span>
            </td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Surat</th>
                <th>Jenis</th>
                <th>Perihal / Keterangan</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $i => $surat)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $surat['nomor_surat'] }}</td>
                    <td>{{ $surat['jenis'] }}</td>
                    <td>{{ $surat['keterangan'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($surat['tanggal'])->translatedFormat('d M Y') }}</td>
                    <td><span class="badge">{{ $surat['status'] }}</span></td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty">Tidak ada data pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Sistem Arsip Surat — PT Microdata Indonesia
    </div>

</body>
</html>