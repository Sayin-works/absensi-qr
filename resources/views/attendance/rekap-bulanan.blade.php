@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Rekap Absensi Bulanan</h4>

    {{-- Filter --}}
    <form method="GET" class="row g-2 mb-4">
    <div class="col-md-2">
        <select name="bulan" class="form-select">
            @foreach(range(1,12) as $m)
                <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <input type="number" name="tahun" class="form-control" value="{{ $tahun }}">
    </div>
    <div class="col-md-2">
        <select name="class_id" class="form-select">
            <option value="">-- Semua Kelas --</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}" {{ $classId == $class->id ? 'selected' : '' }}>
                    {{ $class->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
    </div>
    <div class="col-md-2">
        <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary w-100">Filter</button>
    </div>
</form>


    {{-- Tabel Rekap --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Sakit</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rekap as $i => $item)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $item->student->name }}</td>
                    <td>{{ $item->student->classroom->name ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                    <td>
                        <span class="badge 
                            @if($item->status == 'Hadir') bg-success
                            @elseif($item->status == 'Izin') bg-warning text-dark
                            @elseif($item->status == 'Sakit') bg-info
                            @else bg-danger @endif">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td>                        
                          
                        {{ $item->keterangan ?? '-' }}
                        
                    </td>
                    <td>{{ $item->check_in ?? '-' }}</td>
                    <td>{{ $item->check_out ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
