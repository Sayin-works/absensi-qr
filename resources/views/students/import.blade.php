@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4 text-center">Import Data Siswa</h3>

    {{-- Alert Session --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-warning">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Import Form --}}
    <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="file" class="form-label">Pilih File Excel (.xlsx)</label>
            <input type="file" name="file" id="file" class="form-control" required accept=".xlsx,.xls">
            <small class="text-muted">Gunakan format template yang sesuai. <a href="{{ route('students.template') }}">Unduh Template</a></small>
        </div>

        <button type="submit" class="btn btn-primary w-100">Import Data</button>
    </form>
</div>
@endsection
