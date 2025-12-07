<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMapping;

class RekapBulananExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $bulan, $kelas;

    public function __construct($bulan, $kelas)
    {
        $this->bulan = $bulan;
        $this->kelas = $kelas;
    }

    public function collection()
    {
        $query = Attendance::with('student')
            ->whereMonth('date', $this->bulan);

        if ($this->kelas) {
            $query->whereHas('student.classroom', function($q) {
                $q->where('id', $this->kelas);
            });
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Kelas',
            'Tanggal',
            'Status',
            'Check In',
            'Check Out',
        ];
    }

    public function map($attendance): array
    {
        return [
            $attendance->student->name,
            $attendance->student->classroom->name ?? '-',
            $attendance->date,
            $attendance->status,
            $attendance->check_in,
            $attendance->check_out,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Header Tebal + Warna
            1    => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'color' => ['rgb' => 'D9E1F2']]],
        ];
    }
}
