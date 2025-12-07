@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">📰 Kelola Informasi Sekolah</h4>

    <div class="mb-3">
        <a href="{{ route('information.create') }}" class="btn btn-success">
            ➕ Tambah Informasi
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Tanggal</th>
                    <th>Konten Singkat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($infos as $info)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="width: 120px;">
                        @if($info->image)
                            <img src="{{ asset('storage/' . $info->image) }}" alt="Thumbnail" class="img-fluid rounded shadow-sm" style="max-height: 80px;">
                        @else
                            <small class="text-muted">Tidak ada</small>
                        @endif
                    </td>
                    <td>{{ $info->title }}</td>
                    <td>{{ \Carbon\Carbon::parse($info->date)->translatedFormat('d F Y') }}</td>
                    <td>{{ Str::limit(strip_tags($info->content), 100) }}</td>
                    <td>
                        <a href="{{ route('information.edit', $info->id) }}" class="btn btn-sm btn-warning">✏️ Edit</a>
                        <form action="{{ route('information.destroy', $info->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus informasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">🗑️ Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada informasi yang ditambahkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
