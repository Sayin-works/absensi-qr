@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Manajemen Tahun Ajaran</h4>

    {{-- Tampilkan pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tombol tambah --}}
    <a href="{{ route('academic-years.create') }}" class="btn btn-primary mb-3">
        + Tambah Tahun Ajaran
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tahun Ajaran</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($years as $year)
                <tr>
                    <td>{{ $year->year }}</td>
                    <td>
                        @if($year->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        @if(!$year->is_active)
                            <form action="{{ route('academic-years.activate', $year) }}" method="POST" style="display: inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-success">Aktifkan</button>
                            </form>
                        @else
                            <span class="text-muted">Sudah aktif</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Belum ada data tahun ajaran.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
