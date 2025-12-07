<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class SubjectAttendanceExport implements FromCollection
{
    protected $attendances;

    public function __construct($attendances)
    {
        $this->attendances = $attendances;
    }

    public function collection()
    {
        return $this->attendances->map(function ($att) {
            return [
                'Tanggal' => $att->date,
                'Mapel' => $att->subject->name,
                'Kelas' => $att->classroom->name,
                'Jumlah Hadir' => $att->present_count ?? '-',
                'Jumlah Alpha' => $att->absent_count ?? '-'
            ];
        });
    }
}
