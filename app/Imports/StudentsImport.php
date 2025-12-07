<?php

namespace App\Imports;

use App\Models\Classroom;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;




class StudentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
{
    $classroom = Classroom::where('name', $row['kelas'])->first();


    return \App\Models\Student::updateOrCreate(
        ['nisn' => $row['nisn']], // cari berdasarkan NISN
        [
            'name'         => $row['nama_lengkap'],
            'qr_code_id'   => \Illuminate\Support\Str::random(10),
            'class_id'     => $classroom?->id,
            'gender'       => $row['jenis_kelamin_lp'] ?? 'L',
            'birth_place'  => $row['tempat_lahir'] ?? null,
            'birth_date'   => $this->parseDate(
                $row['tanggal_lahir_yyyymmdd']
                ?? $row['tanggal_lahir_yyyy_mm_dd']
                ?? $row['tanggal_lahir_yyyy_mmdd']
                ?? null
            ),
            'address'      => $row['alamat'] ?? null,
            'religion'     => $row['agama'] ?? null,
            'phone'        => $row['nomor_hp'] ?? null,
            'status'       => !empty($row['status_aktifnonaktif'])
                                ? $row['status_aktifnonaktif']
                                : 'Aktif',
        ]
    );
}


    private function parseDate($date)
    {
        try {
            return $date ? Carbon::parse($date) : null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
