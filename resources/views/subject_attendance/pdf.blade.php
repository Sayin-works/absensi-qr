<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi Mapel</title>
    <style>
        table { width:100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h2>Laporan Absensi Mapel</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Mapel</th>
                <th>Kelas</th>
                <th>Hadir</th>
                <th>Alpha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $att)
            <tr>
                <td>{{ $att->date }}</td>
                <td>{{ $att->subject->name }}</td>
                <td>{{ $att->classroom->name }}</td>
                <td>{{ $att->present_count ?? '-' }}</td>
                <td>{{ $att->absent_count ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
