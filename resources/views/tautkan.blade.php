@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tautkan Akun Anda dengan Siswa</h3>

    <form action="{{ route('tautkan.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="student_id" class="form-label">Pilih Siswa</label>
            <select name="student_id" id="student_id" class="form-select" required>
                <option value="">-- Pilih --</option>
                @foreach ($availableStudents as $student)
                    <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->nis }})</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Tautkan</button>
    </form>
</div>
@endsection
