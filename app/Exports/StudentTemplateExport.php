<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentTemplateExport implements FromArray, WithHeadings, WithStyles, WithTitle
{
    public function array(): array
    {
        return [
            [
                'Contoh Nama',
                'otomatis',   // qr_code_id akan dibuat otomatis
                '10 A',       // classes
                '1',          // walimurid_id
                '1234567890', // nisn
                'L',          // gender (L/P)
                'Bandung',
                '2008-05-12', // birth_date (format YYYY-MM-DD)
                'Jl. Contoh No. 123',
                'Islam',
                '08123456789',
                'Aktif',
                'foto.jpg'    // jika kosong, akan diabaikan
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'QR Code ID (otomatis)',
            'Kelas',
            'ID Wali Murid',
            'NISN',
            'Jenis Kelamin (L/P)',
            'Tempat Lahir',
            'Tanggal Lahir (YYYY-MM-DD)',
            'Alamat',
            'Agama',
            'Nomor HP',
            'Status (Aktif/Nonaktif)',
            'Foto (opsional)'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['argb' => 'FFDEEAF6'], // warna biru muda
                ],
            ],
        ];
    }

    public function title(): string
    {
        return 'Template Siswa';
    }
}
