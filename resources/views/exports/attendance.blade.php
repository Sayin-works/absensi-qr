<table>
    <thead>
        <tr>
            <th>Nama Siswa</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Jenis</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $absen)
            <tr>
                <td>{{ $absen->student->name }}</td>
                <td>{{ $absen->date }}</td>
                <td>{{ $absen->time }}</td>
                <td>{{ $absen->type }}</td>
            </tr>
        @endforeach
    </tbody>
</table>