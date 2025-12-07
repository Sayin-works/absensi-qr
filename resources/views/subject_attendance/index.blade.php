 @extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4>Absensi Mapel</h4>

    @if($subjects->isEmpty() || $classes->isEmpty())
        <div class="alert alert-warning">
            Anda belum memiliki mapel atau kelas yang terdaftar.
        </div>
    @else
        <form action="{{ route('subject_attendance.create') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label>Mata Pelajaran</label>
                    <select name="subject_id" class="form-control" required>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Kelas</label>
                    <select name="class_id" class="form-control" required>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary w-100">Mulai Absen</button>
                </div>
            </div>
        </form>

        {{-- Review Absensi --}}
        <h5>Riwayat Absensi Mapel</h5>
        <div class="mt-3">
            <a href="{{ route('subject_attendance.download', 'excel') }}" class="btn btn-success btn-sm">Download Excel</a>
            <a href="{{ route('subject_attendance.download', 'pdf') }}" class="btn btn-danger btn-sm">Download PDF</a>
        </div>

        @if($attendances->isEmpty())
            <div class="alert alert-info">
                Belum ada absensi mapel yang tercatat.
            </div>
        @else
            <table class="table table-bordered table-striped mt-2">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Mapel</th>
                        <th>Kelas</th>
                        <th>Jumlah Hadir</th>
                        <th>Jumlah Alpha</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $attendance)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d-m-Y') }}</td>
                            <td>{{ $attendance->subject->name }}</td>
                            <td>{{ $attendance->classroom->name }}</td>
                            <td>{{ $attendance->present_count }}</td>
                            <td>{{ $attendance->alpha_count }}</td>
                            <td>
                                <a href="{{ route('subject_attendance.show', $attendance->id) }}" class="btn btn-sm btn-info">Lihat</a>
                                <a href="{{ route('subject_attendance.edit', $attendance->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif
</div>
@endsection
