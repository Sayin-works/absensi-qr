@extends('layouts.app')

@section('content')
<div class="container">
 <div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="fas fa-chalkboard-teacher"></i> Daftar Guru</h4>
    <div class="btn-group">
        <a href="{{ route('teachers.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Guru
        </a>
        <a href="{{ route('teachers.import.form') }}" class="btn btn-secondary">
            <i class="fas fa-file-upload"></i> Import
        </a>
        <a href="{{ route('teachers.template') }}" class="btn btn-outline-secondary">
            <i class="fas fa-download"></i> Template
        </a>
    </div>
</div>


    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('teachers.create') }}" class="btn btn-primary mb-3">Tambah Guru</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Mata Pelajaran</th>
                <th>Wali Kelas Untuk</th>
                <th>Peran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($teachers as $teacher)
                <tr>
                    <td>{{ $teacher->name }}</td>
                    <td>{{ $teacher->email }}</td>
                    <td>
                        @if ($teacher->subjects && $teacher->subjects->count())
                            {{ $teacher->subjects->pluck('name')->join(', ') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $teacher->class->name ?? '-' }}</td>
                    <td>
                        @if ($teacher->is_subject_teacher && $teacher->is_homeroom_teacher)
                            Guru Mapel & Wali Kelas
                        @elseif ($teacher->is_subject_teacher)
                            Guru Mapel
                        @elseif ($teacher->is_homeroom_teacher)
                            Wali Kelas
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus guru ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada data guru.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $teachers->links() }}
    </div>
</div>
@endsection
