@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="container mt-4">
    <h4>Absensi Kelas {{ $class->name }}</h4>
    <p class="text-muted">Wali Kelas: {{ Auth::user()->name }}</p>

    {{-- Scan QR Section --}}
<a href="{{ route('class_attendance.scan', $class->id) }}" class="btn btn-primary mb-3">
    📷 Scan QR Siswa
</a>


    <form action="{{ route('class_attendance.store') }}" method="POST" id="attendanceForm">
        @csrf
        <input type="hidden" name="class_id" value="{{ $class->id }}">

        <div class="table-responsive mt-3">
            <table class="table table-bordered align-middle" id="attendanceTable">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $index => $student)
                        <tr data-qr="{{ $student->qr_code_id }}">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $student->name }}</td>
                            <td>
                                <select name="attendance[{{ $student->id }}]" class="form-select">
                                    <option value="Hadir">Hadir</option>
                                    <option value="Izin">Izin</option>
                                    <option value="Sakit">Sakit</option>
                                    <option value="Alpa" selected>Alpa</option>
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <button type="submit" class="btn btn-success mt-3">Simpan Absensi</button>
    </form>
</div>

{{-- Script Scan QR --}}
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const html5QrCode = new Html5Qrcode("preview");

    function onScanSuccess(decodedText) {
        const qrCodeId = decodedText.trim();
        const row = document.querySelector(`#attendanceTable tr[data-qr="${qrCodeId}"]`);

        if (row) {
            const select = row.querySelector('select');
            select.value = "Hadir"; // otomatis set hadir
            row.style.backgroundColor = "#d4edda"; // highlight hijau
        } else {
            alert("QR tidak cocok dengan siswa di kelas ini!");
        }
    }

    Html5Qrcode.getCameras().then(devices => {
        if (devices && devices.length) {
            html5QrCode.start(
                { facingMode: "environment" },
                { fps: 10, qrbox: { width: 250, height: 250 } },
                onScanSuccess
            );
        }
    }).catch(err => console.error(err));
});
</script>
@endsection
