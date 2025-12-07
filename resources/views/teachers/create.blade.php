@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Tambah Guru</h4>

    <form action="{{ route('teachers.store') }}" method="POST">
    @csrf

    {{-- Nama --}}
    <div class="mb-3">
        <label for="name" class="form-label">Nama Guru</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>

    {{-- Email --}}
    <div class="mb-3">
        <label for="email" class="form-label">Email Guru</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>

{{-- Mata Pelajaran --}}
<div class="mb-3">
    <label for="subject_id" class="form-label">Mata Pelajaran</label>
    <select name="subject_id[]" id="subject_id" class="form-select" multiple required>
        @forelse ($subjects as $subject)
            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
        @empty
            <option value="">(Tidak ada mata pelajaran)</option>
        @endforelse
    </select>
    <small class="form-text text-muted">Gunakan Ctrl (Windows) atau Command (Mac) untuk memilih lebih dari satu.</small>
</div>


    {{-- Wali Kelas Untuk --}}
    <div class="mb-3">
        <label for="class_id" class="form-label">Wali Kelas Untuk</label>
        <select name="class_id" id="class_id" class="form-select">
            <option value="">-- Pilih Kelas --</option>
            @forelse ($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
            @empty
                <option value="">(Tidak ada kelas)</option>
            @endforelse
        </select>
    </div>

    {{-- Checkbox Wali Kelas --}}
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" name="is_homeroom_teacher" id="is_homeroom_teacher">
        <label class="form-check-label" for="is_homeroom_teacher">Wali Kelas</label>
    </div>

    {{-- Checkbox Guru Mapel --}}
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" name="is_subject_teacher" id="is_subject_teacher">
        <label class="form-check-label" for="is_subject_teacher">Guru Mapel</label>
    </div>

    {{-- Submit --}}
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
</div>
@endsection
