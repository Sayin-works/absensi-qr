<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Absensi {{ $class->name }} - {{ $date }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h3>Rekap Absensi Kelas {{ $class->name }}</h3>
    <p>Tanggal: {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Status</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $i => $record)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $record->student->name }}</td>
                    <td>{{ $record->status }}</td>
                    <td>{{ $record->note ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
