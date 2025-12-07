@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4>Edit Absensi Kelas {{ $class->name }} - Tanggal {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}</h4>

    <form action="{{ route('class_attendance.update', $date) }}" method="POST">
        @csrf
        @method('PUT')

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>
                            <select name="attendance[{{ $student->id }}]" class="form-select">
                                @php
                                    $status = $attendances[$student->id]->status ?? 'Hadir';
                                @endphp
                                <option value="Hadir" {{ $status == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="Sakit" {{ $status == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="Izin" {{ $status == 'Izin' ? 'selected' : '' }}>Izin</option>
                                <option value="Alfa" {{ $status == 'Alfa' ? 'selected' : '' }}>Alfa</option>
                            </select>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
        <a href="{{ route('class_attendance.rekap') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div>
@endsection
