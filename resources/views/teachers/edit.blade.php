@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Edit Guru</h4>

    <form action="{{ route('teachers.update', $teacher->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $teacher->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Guru</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $teacher->email) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tugas Tambahan</label>
            <div class="form-check">
                <input type="checkbox" name="is_subject_teacher" value="1" class="form-check-input" id="subject_teacher"
                    {{ $teacher->is_subject_teacher ? 'checked' : '' }}>
                <label for="subject_teacher" class="form-check-label">Guru Mata Pelajaran</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="is_homeroom_teacher" value="1" class="form-check-input" id="homeroom_teacher"
                    {{ $teacher->is_homeroom_teacher ? 'checked' : '' }}>
                <label for="homeroom_teacher" class="form-check-label">Wali Kelas</label>
            </div>
        </div>
<div class="mb-3">
    <label for="subject_id" class="form-label">Mata Pelajaran</label>
    <select name="subject_id[]" id="subject_id" class="form-select" multiple required>
        @foreach($subjects as $subject)
            <option value="{{ $subject->id }}" 
                {{ $teacher->subjects->contains('id', $subject->id) ? 'selected' : '' }}>
                {{ $subject->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="class_id" class="form-label">Wali Kelas Untuk</label>
    <select name="class_id" id="class_id" class="form-select">
        <option value="">-- Pilih Kelas --</option>
        @foreach($classes as $class)
            <option value="{{ $class->id }}" {{ $teacher->class_id == $class->id ? 'selected' : '' }}>
                {{ $class->name }}
            </option>
        @endforeach
    </select>
</div>


        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
