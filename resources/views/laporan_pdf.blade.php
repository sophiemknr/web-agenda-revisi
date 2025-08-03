<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Agenda</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 4px;
            text-align: left;
        }

        th {
            background: #eee;
        }
    </style>
</head>

<body>
    <h2 style="text-align:center;">Laporan Agenda</h2>
    <table style="width:100%; margin-bottom:10px;">
        <tr>
            <td><b>Tanggal Cetak:</b>
                {{ isset($waktuCetak) ? $waktuCetak->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') : \Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y H:i') }}
            </td>
            <td style="text-align:right;"><b>Filter:</b>
                @if (request('tanggal_awal') || request('tanggal_akhir'))
                    Tanggal
                    @if (request('tanggal_awal'))
                        {{ \Carbon\Carbon::parse(request('tanggal_awal'))->format('d/m/Y') }}
                    @endif
                    -
                    @if (request('tanggal_akhir'))
                        {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d/m/Y') }}
                    @endif
                @else
                    Semua Tanggal
                @endif
                |
                Status: {{ request('status') && request('status') != 'all' ? strtoupper(request('status')) : 'SEMUA' }}
            </td>
        </tr>
    </table>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kegiatan</th>
                <th>Tempat</th>
                <th>User</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($agendas as $agenda)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($agenda->date)->format('d/m/Y') }}</td>
                    <td>{{ $agenda->title }}</td>
                    <td>{{ $agenda->tempat }}</td>
                    <td>{{ optional($agenda->user)->name ?? 'N/A' }}</td>
                    <td>{{ strtoupper($agenda->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;">Tidak ada data agenda</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
