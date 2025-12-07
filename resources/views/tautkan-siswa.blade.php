@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Tautkan Akun Wali Murid dengan Siswa</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('tautkan.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="qr_code_id" class="form-label">Kode QR Siswa</label>
            <div class="input-group">
                <input type="text" name="qr_code_id" id="qr_code_id" 
                       class="form-control" placeholder="Scan atau masukkan kode QR" required>
                <button type="button" class="btn btn-secondary" id="btnScan">
                    📷 Scan QR
                </button>
            </div>
            @error('qr_code_id')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Area kamera muncul di sini saat scan --}}
        <div id="reader" style="width:300px; display:none;" class="mt-3"></div>

        <button type="submit" class="btn btn-primary mt-3">Tautkan Siswa</button>
    </form>
</div>

{{-- Script untuk scan QR --}}
<script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
<script>
    const scanBtn = document.getElementById('btnScan');
    const reader = document.getElementById('reader');
    const qrInput = document.getElementById('qr_code_id');

    let html5QrCode;

    scanBtn.addEventListener('click', function() {
        reader.style.display = 'block';

        if (!html5QrCode) {
            html5QrCode = new Html5Qrcode("reader");
        }

        html5QrCode.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: 250 },
            qrCodeMessage => {
                qrInput.value = qrCodeMessage; // hasil scan dimasukkan otomatis
                html5QrCode.stop().then(() => {
                    reader.style.display = 'none';
                }).catch(err => console.error(err));
            },
            errorMessage => {
                // Bisa tambahkan log error kalau perlu
            }
        ).catch(err => console.error(err));
    });
</script>
@endsection
