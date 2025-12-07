@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Informasi</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('information.update', $information->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Judul --}}
        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" name="title" value="{{ old('title', $information->title) }}" class="form-control" required>
        </div>

        {{-- Tanggal --}}
        <div class="mb-3">
            <label for="date" class="form-label">Tanggal</label>
            <input type="date" name="date" value="{{ old('date', $information->date ? \Carbon\Carbon::parse($information->date)->format('Y-m-d') : '') }}" class="form-control">
        </div>

        {{-- Gambar --}}
        <div class="mb-3">
            <label for="image" class="form-label">Gambar (opsional)</label>
            @if ($information->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $information->image) }}" alt="Gambar" style="max-height: 150px;">
                </div>
            @endif
            <input type="file" name="image" class="form-control">
        </div>

        {{-- Konten --}}
        <div class="mb-3">
            <label for="content" class="form-label">Isi Informasi</label>
            <textarea name="content" rows="5" class="form-control" required>{{ old('content', $information->content) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('information.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
