@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mx-auto" style="max-width: 100%; width: 480px;">
        <div class="card shadow-sm rounded-4">
            <div class="card-body px-4 py-3">
                <h5 class="text-center mb-4">Tambah Mata Pelajaran</h5>

                {{-- Tampilkan error validasi --}}
                @if ($errors->any())
                    <div class="alert alert-danger small">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('subjects.store') }}" method="POST">
                    @csrf

                    {{-- Nama mapel --}}
                    <div class="mb-3">
                        <label class="form-label">Nama Mata Pelajaran</label>
                        <input type="text" name="name"
                               class="form-control form-control-sm"
                               placeholder="Contoh: Matematika"
                               value="{{ old('name') }}" required>
                    </div>

                    {{-- Pilih guru pengampu (bisa multiple) --}}
                    <div class="mb-3">
                        <label class="form-label">Guru Pengampu</label>
                        <select name="teachers[]" class="form-select form-select-sm" multiple>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ collect(old('teachers'))->contains($teacher->id) ? 'selected' : '' }}>
                                    {{ $teacher->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Tekan Ctrl (atau Cmd di Mac) untuk pilih lebih dari satu guru</small>
                    </div>

                    {{-- Tombol --}}
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a href="{{ route('subjects.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
