@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Statistik Kehadiran Anak</h4>
    <p class="text-muted">Nama Siswa: <strong>{{ $student->name }}</strong></p>
    <p class="text-muted">Kelas: {{ $student->classroom->name ?? '-' }}</p>

    <div class="row text-center mb-4">
        @foreach($statistik as $key => $value)
            @if($key !== 'total')
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="text-uppercase">{{ ucfirst($key) }}</h6>
                        <h3>{{ $value }}</h3>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>

    <h5>Riwayat 30 Hari Terakhir</h5>
    <table class="table table-bordered mt-3">
        <thead class="table-light">
            <tr>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $att)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($att->date)->format('d-m-Y') }}</td>
                    <td>{{ $att->status }}</td>
                    <td>{{ $att->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Belum ada data kehadiran</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
