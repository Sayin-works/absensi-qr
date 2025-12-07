@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4><i class="fas fa-file-upload"></i> Import Guru</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            Gagal import. Periksa kembali format file.
        </div>
    @endif

    <form action="{{ route('teachers.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="file" class="form-label">Pilih File Excel (.xlsx)</label>
            <input type="file" name="file" class="form-control" required>
        </div>
        <button class="btn btn-success"><i class="fas fa-upload"></i> Import</button>
        <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
