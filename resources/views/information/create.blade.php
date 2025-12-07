@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Tambah Informasi Sekolah</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('information.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Judul Informasi</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Tanggal</label>
            <input type="date" name="date" class="form-control" value="{{ old('date') }}">
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Isi Informasi</label>
            <textarea name="content" class="form-control" rows="5" required>{{ old('content') }}</textarea>
        </div>
        <form action="{{ route('information.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="image">Gambar (opsional)</label>
        <input type="file" name="image" class="form-control">
    </div>



    
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('information.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
