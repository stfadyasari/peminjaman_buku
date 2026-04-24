<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Log Aktivitas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #0f172a;
            margin: 24px;
        }

        h1 {
            margin: 0;
            font-size: 20px;
        }

        p {
            margin: 4px 0 0;
            color: #475569;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
            font-size: 12px;
        }

        th, td {
            border: 1px solid #cbd5e1;
            padding: 8px;
            vertical-align: top;
            text-align: left;
        }

        th {
            background: #f8fafc;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                margin: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom:12px;">
        <button onclick="window.print()" style="padding:8px 12px; border:1px solid #94a3b8; background:#fff; border-radius:8px; cursor:pointer;">Cetak Sekarang</button>
    </div>

    <h1>Laporan Log Aktivitas</h1>
    <p>Dicetak pada: {{ $generatedAt->translatedFormat('d F Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th style="width:42px;">No</th>
                <th style="width:112px;">Tanggal</th>
                <th style="width:180px;">Aktivitas</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($activities as $activity)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Illuminate\Support\Carbon::parse($activity->date)->translatedFormat('d M Y') }}</td>
                    <td>{{ $activity->action }}</td>
                    <td>{{ $activity->description }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center;">Belum ada log aktivitas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        window.addEventListener('load', function () {
            window.print();
        });
    </script>
</body>
</html>
