@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4>Absensi Mapel {{ $subject->name }} - Kelas {{ $class->name }}</h4>

    <form action="{{ route('subject_attendance.store') }}" method="POST">
        @csrf
        <input type="hidden" name="subject_id" value="{{ $subject->id }}">
        <input type="hidden" name="class_id" value="{{ $class->id }}">

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $i => $student)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $student->name }}</td>
                        <td>
                            <select name="attendance[{{ $student->id }}]" class="form-control">
                                <option value="Hadir">Hadir</option>
                                <option value="Sakit">Sakit</option>
                                <option value="Izin">Izin</option>
                                <option value="Alfa">Alfa</option>
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
