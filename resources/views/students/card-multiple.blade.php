<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Kartu Pelajar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
        }
        .page {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .card {
            width: 30%;
            height: 400px;
            border-radius: 10px;
            border: 2px solid #007BFF;
            background: linear-gradient(to bottom, #ffffff, #e6f0ff);
            padding: 15px;
            margin: 10px 0;
            box-sizing: border-box;
            position: relative;
        }
        .logo {
            width: 50px;
            height: 50px;
            display: block;
            margin: 0 auto;
        }
        .title {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            color: #007BFF;
            margin: 5px 0;
        }
        .info {
            font-size: 11px;
            color: #333;
            line-height: 1.5;
            margin-top: 10px;
        }
        .qr {
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
        }
        .footer {
            position: absolute;
            bottom: 3px;
            width: 100%;
            text-align: center;
            font-size: 9px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="page">
        @foreach ($students as $student)
            <div class="card">
                <img src="{{ public_path('logo-sekolah.png') }}" alt="Logo" class="logo">
                <div class="title">
                    KARTU PELAJAR<br>SMK CONTOH NEGERI
                </div>
                <div class="info">
                    <strong>Nama:</strong> {{ $student->name }}<br>
                    <strong>NISN:</strong> {{ $student->nisn ?? '-' }}<br>
                    <strong>Kelas:</strong> {{ $student->classroom->name ?? '-' }}<br>
                    <strong>TTL:</strong> {{ $student->birth_place }}, {{ $student->birth_date }}<br>
                    <strong>Alamat:</strong> {{ $student->address }}
                </div>
                <div class="qr">
                    <img src="data:image/png;base64, {!! DNS2D::getBarcodePNG($student->qr_code_id, 'QRCODE') !!}" width="80">
                </div>
                <div class="footer">SMK CONTOH NEGERI</div>
            </div>
        @endforeach
    </div>
</body>
</html>
