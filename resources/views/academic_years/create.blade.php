@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Tambah Tahun Ajaran Baru</h4>

    {{-- Error validation --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('academic-years.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="year" class="form-label">Tahun Ajaran</label>
            <input type="text" name="year" id="year" class="form-control" placeholder="contoh: 2024/2025" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('academic-years.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
