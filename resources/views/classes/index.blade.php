@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Manajemen Kelas & Wali Kelas</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama Kelas</th>
                    <th>Wali Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classes as $index => $class)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $class->name }}</td>
                        <td>{{ $class->walikelas ?? '-' }}</td>
                        <td>
                            <form action="{{ route('classes.updateWaliKelas', $class->id) }}" method="POST" class="d-flex gap-2">
                                @csrf
                                <input type="text" name="walikelas" class="form-control form-control-sm" value="{{ $class->walikelas }}" placeholder="Nama wali kelas">
                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if($classes->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center">Belum ada data kelas.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const forms = document.querySelectorAll('form');

        forms.forEach(form => {
            form.addEventListener('submit', function (e) {
                const input = form.querySelector('input[name="walikelas"]');
                if (!input.value.trim()) {
                    e.preventDefault();
                    alert('Nama wali kelas tidak boleh kosong.');
                }
            });
        });
    });
</script>
@endsection
