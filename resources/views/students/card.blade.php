<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu Pelajar</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .card {
            width: 250px;
            height: 400px;
            border-radius: 12px;
            border: 2px solid #007BFF;
            background: linear-gradient(to bottom, #ffffff, #e6f0ff);
            padding: 10px;
            box-sizing: border-box;

            /* Flex untuk memastikan isi rata tengah vertikal & horizontal */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
        }
        .logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
            margin-bottom: 5px;
        }
        .title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            color: #007BFF;
            margin-bottom: 8px;
        }
        .photo {
            width: 80px;
            height: 100px;
            object-fit: cover;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 8px;
        }
        .info {
            font-size: 11px;
            color: #000;
            line-height: 1.4;
            text-align: left;
            width: 100%;
            padding: 0 5px;
            box-sizing: border-box;
            flex-grow: 1;
        }
        .qr {
            margin-top: 5px;
            margin-bottom: 5px;
            background: #fff;
            padding: 5px;
            border-radius: 5px;
        }
        .qr img {
            width: 100px; 
            height: 100px;
        }
        .footer {
            font-size: 9px;
            color: #555;
            text-align: center;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <div class="card">
        {{-- Logo sekolah --}}
        <img src="{{ public_path('logo-sekolah.png') }}" alt="Logo" class="logo">

        <div class="title">
            KARTU PELAJAR<br>SMP NEGERI 3 JATI AGUNG
        </div>

        {{-- Foto siswa --}}
        @if($student->photo)
            <img src="{{ public_path($student->photo) }}" alt="Foto Siswa" class="photo">
        @else
            <img src="{{ public_path('foto_siswa/default.png') }}" alt="Foto Default" class="photo">
        @endif

        {{-- Info siswa --}}
        <div class="info">
            <strong>Nama:</strong> {{ $student->name }}<br>
            <strong>NISN:</strong> {{ $student->nisn ?? '-' }}<br>
            <strong>Kelas:</strong> {{ $student->classroom->name ?? '-' }}<br>
            <strong>TTL:</strong> {{ $student->birth_place }}, {{ $student->birth_date }}<br>
            <strong>Alamat:</strong> {{ $student->address }}
        </div>

        {{-- QR Code --}}
        <div class="qr">
            <img src="data:image/png;base64, {!! DNS2D::getBarcodePNG($student->qr_code_id, 'QRCODE') !!}">
        </div>

        <div class="footer">
            Kartu ini digunakan sebagai identitas resmi siswa.
        </div>
    </div>
</body>
</html>
