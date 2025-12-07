<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu Pelajar</title>
    <style>
        @page {
            size: A4;
            margin: 0.5cm;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        table {
            border-spacing: 0.3cm;
            width: 100%;
        }
        td {
            width: 5.4cm;
            height: 8.6cm;
            vertical-align: top;
        }
        .card {
            width: 5.4cm;
            height: 8.6cm;
            border-radius: 8px;
            border: 1px solid #007BFF;
            background: linear-gradient(to bottom, #ffffff, #e6f0ff);
            padding: 0.2cm;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .logo {
            width: 1.5cm;
            height: 1.5cm;
            object-fit: contain;
            margin: 0 auto; /* Posisikan ke tengah */
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .title {
            font-size: 8pt;
            font-weight: bold;
            color: #007BFF;
            text-align: center;
            margin: 0.1cm 0;
        }
        .photo {
            width: 2cm;
            height: 2.5cm;
            object-fit: cover;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin: 0.1cm 0;
        }
        .info {
            font-size: 6.5pt;
            color: #000;
            text-align: left;
            width: 100%;
            line-height: 1.2;
            flex-grow: 1;
        }
        .qr {
            margin-top: 0.1cm;
            background: #fff;
            padding: 0.05cm;
            border-radius: 3px;
        }
        .qr img {
            width: 1.8cm;
            height: 1.8cm;
        }
        .footer {
            font-size: 5pt;
            color: #555;
            text-align: center;
        }
    </style>
</head>
<body>
    @php
        $chunks = $students->chunk(9); // 9 kartu per halaman
    @endphp

    @foreach($chunks as $chunk)
        <table>
            @foreach($chunk->chunk(3) as $row)
                <tr>
                    @foreach($row as $student)
                        <td>
                            <div class="card">
                                {{-- Logo sekolah --}}
                                <img src="{{ public_path('logo-sekolah.png') }}" class="logo" alt="Logo">

                                <div class="title">
                                    KARTU PELAJAR<br>SMP NEGERI 3 JATI AGUNG
                                </div>

                                {{-- Foto siswa --}}
                                @if($student->photo && file_exists(public_path($student->photo)))
                                    <img src="{{ public_path($student->photo) }}" class="photo" alt="Foto Siswa">
                                @else
                                    <img src="{{ public_path('foto_siswa/default.png') }}" class="photo" alt="Default">
                                @endif

                                {{-- Info siswa --}}
                                <div class="info">
                                    <strong>Nama:</strong> {{ $student->name }}<br>
                                    <strong>NISN:</strong> {{ $student->nisn ?? '-' }}<br>
                                    <strong>Kelas:</strong> {{ $student->classroom->name ?? '-' }}<br>
                                    <strong>TTL:</strong> {{ $student->birth_place ?? '-' }}, {{ $student->birth_date ?? '-' }}<br>
                                    <strong>Alamat:</strong> {{ $student->address ?? '-' }}
                                </div>

                                {{-- QR Code --}}
                                <div class="qr">
                                    <img src="data:image/png;base64,{!! DNS2D::getBarcodePNG($student->qr_code_id, 'QRCODE') !!}" alt="QR Code">
                                </div>

                                <div class="footer">
                                    Kartu ini digunakan sebagai identitas resmi siswa.
                                </div>
                            </div>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    @endforeach
</body>
</html>
