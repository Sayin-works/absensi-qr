@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-500 to-purple-600">
    <div class="bg-white shadow-2xl rounded-2xl p-6 w-full max-w-md text-center">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">📷 Scan QR Kehadiran</h2>

        <!-- Status -->
        @if(session('success'))
            <div class="bg-green-100 text-green-800 rounded-lg p-2 mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-800 rounded-lg p-2 mb-4">{{ session('error') }}</div>
        @endif

        <!-- Reader -->
        <div id="reader" class="mx-auto rounded-xl overflow-hidden border-4 border-blue-400 shadow-lg" style="width: 100%; max-width: 300px;"></div>

        <!-- Hidden Form -->
        <form id="scanForm" action="{{ route('attendance.scan.process') }}" method="POST" class="mt-4">
            @csrf
            <input type="hidden" name="qr_code_id" id="qr_code_id">
        </form>

        <p class="text-gray-500 mt-4 text-sm">Arahkan QR Code kartu siswa ke kamera 📌</p>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    function onScanSuccess(decodedText) {
        document.getElementById('qr_code_id').value = decodedText;
        document.getElementById('scanForm').submit();
    }

    Html5Qrcode.getCameras().then(devices => {
        if (devices && devices.length) {
            let cameraId = devices[devices.length - 1].id; // kamera belakang
            const html5QrCode = new Html5Qrcode("reader");
            html5QrCode.start(
                cameraId,
                { fps: 10, qrbox: { width: 250, height: 250 }, aspectRatio: 1.0 },
                onScanSuccess
            );
        }
    }).catch(err => {
        console.error("Error akses kamera: ", err);
    });
</script>
@endsection
