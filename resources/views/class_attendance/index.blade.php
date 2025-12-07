@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Absensi Kelas {{ $class->name }}</h4>

    <form action="{{ route('class_attendance.store') }}" method="POST">
        @csrf
        <table class="table table-bordered mt-3">
            <thead class="table-dark">
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
                            <option value="Hadir">Hadir</option>
                            <option value="Izin">Izin</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Alpa">Alpa</option>
                        </select>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button class="btn btn-success mt-3">Simpan Absensi</button>
    </form>
</div>
@endsection
