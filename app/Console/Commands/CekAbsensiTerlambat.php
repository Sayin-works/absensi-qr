<?php

// app/Console/Commands/CekAbsensiTerlambat.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attendance;
use Carbon\Carbon;

class CekAbsensiTerlambat extends Command
{
    protected $signature = 'absensi:check-terlambat';
    protected $description = 'Otomatis tandai siswa alpa jika belum absen jam 9';

    public function handle()
    {
        $waktuSekarang = Carbon::now();
        $jamBatas = Carbon::createFromTime(9, 0, 0);

        if ($waktuSekarang->greaterThanOrEqualTo($jamBatas)) {
            Attendance::whereDate('created_at', Carbon::today())
                ->whereNull('status') // atau kondisi lain
                ->update(['status' => 'alpa']);

            $this->info("Siswa yang belum absen ditandai sebagai alpa.");
        } else {
            $this->info("Belum jam 9, tidak ada yang diubah.");
        }
    }
}

