<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Log Aktivitas</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #111827;
        }

        .header {
            margin-bottom: 12px;
        }

        .title {
            font-size: 16px;
            font-weight: 700;
            margin: 0;
        }

        .subtitle {
            margin-top: 4px;
            color: #4b5563;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #cbd5e1;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f1f5f9;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">Laporan Log Aktivitas</h1>
        <div class="subtitle">Dibuat pada: {{ $generatedAt->translatedFormat('d F Y H:i') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:32px;">No</th>
                <th style="width:88px;">Tanggal</th>
                <th style="width:140px;">Aktivitas</th>
                <th>Deskripsi</th>
                <th style="width:120px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($activities as $activity)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Illuminate\Support\Carbon::parse($activity->date)->translatedFormat('d M Y') }}</td>
                    <td>{{ $activity->action }}</td>
                    <td>{{ $activity->description }}</td>
                    <td>{{ \App\Models\Loan::make(['status' => $activity->status])->statusLabel() }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;">Belum ada log aktivitas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
