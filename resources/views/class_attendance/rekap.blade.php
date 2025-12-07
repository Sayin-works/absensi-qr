@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="mb-4">📊 Rekap Absensi Kelas <strong>{{ $class->name }}</strong></h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- TABEL REKAP PER TANGGAL --}}
    @if($attendances->isEmpty())
        <div class="alert alert-warning">
            Belum ada data absensi untuk kelas ini.
        </div>
    @else
        <div class="table-responsive mb-5">
            <table class="table table-striped table-hover table-bordered align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Tanggal</th>
                        <th>Total Siswa</th>
                        <th>Hadir</th>
                        <th>Sakit</th>
                        <th>Izin</th>
                        <th>Alpha</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($attendances as $date => $records)
                        @php
                            $hadir = $records->where('status', 'Hadir')->count();
                            $sakit = $records->where('status', 'Sakit')->count();
                            $izin = $records->where('status', 'Izin')->count();
                            $alpha = $records->where('status', 'Alpha')->count();
                        @endphp
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}</td>
                            <td>{{ $records->count() }}</td>
                            <td class="text-success">{{ $hadir }}</td>
                            <td class="text-warning">{{ $sakit }}</td>
                            <td class="text-primary">{{ $izin }}</td>
                            <td class="text-danger">{{ $alpha }}</td>
                            <td>
                                <a href="{{ route('class_attendance.edit', $date) }}" class="btn btn-sm btn-warning">
                                    ✏ Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- FILTER TANGGAL --}}
        
        @php
            $selectedDate = request('filter_date') ?? $attendances->keys()->first();
            $latestAttendance = $attendances[$selectedDate] ?? collect();
        @endphp

        <form method="GET" action="{{ route('class_attendance.rekap') }}" class="mb-3">
            <div class="row g-2 align-items-center">
                <div class="col-auto">
                    <label for="filter_date" class="col-form-label fw-bold">Pilih Tanggal:</label>
                </div>
                <div class="col-auto">
                    <select name="filter_date" id="filter_date" class="form-select" onchange="this.form.submit()">
                        @foreach($attendances as $date => $records)
                            <option value="{{ $date }}" {{ $selectedDate == $date ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
<a href="{{ route('class_attendance.download', $selectedDate) }}" 
   class="btn btn-success mb-3">
   📥 Download PDF
</a>

        {{-- TABEL SISWA SESUAI TANGGAL TERPILIH --}}
        <h5 class="mb-3">📋 Detail Absensi Siswa ({{ \Carbon\Carbon::parse($selectedDate)->format('d-m-Y') }})</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-secondary text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Status</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestAttendance as $i => $record)
                        <tr>
                            <td class="text-center">{{ $i+1 }}</td>
                            <td>{{ optional($record->student)->name ?? '-' }}</td>

                            <td class="text-center">
                                @if($record->status == 'Hadir')
                                    <span class="badge bg-success">{{ $record->status }}</span>
                                @elseif($record->status == 'Sakit')
                                    <span class="badge bg-warning text-dark">{{ $record->status }}</span>
                                @elseif($record->status == 'Izin')
                                    <span class="badge bg-primary">{{ $record->status }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $record->status }}</span>
                                @endif
                            </td>
                            <td>{{ $record->note ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="mt-3">
        <a href="{{ route('class_attendance.index') }}" class="btn btn-secondary">⬅ Kembali</a>
    </div>
</div>
@endsection
