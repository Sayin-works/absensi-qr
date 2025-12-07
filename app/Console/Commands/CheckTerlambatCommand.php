<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;

class CheckTerlambatCommand extends Command
{
    protected $signature = 'absensi:check-terlambat';
    protected $description = 'Menandai siswa yang belum absen sebagai Alpha setelah jam 09.00 pagi';

    public function handle()
    {
        $waktuSekarang = Carbon::now();

        if ($waktuSekarang->format('H:i') < '09:00') {
            $this->info('Belum jam 9, tidak diproses.');
            return;
        }

        $hariIni = Carbon::today();

        // Ambil semua siswa
        $semuaSiswa = Student::all();

        foreach ($semuaSiswa as $siswa) {
            $absenHariIni = Attendance::where('student_id', $siswa->id)
                ->whereDate('created_at', $hariIni)
                ->first();

            if (!$absenHariIni) {
                Attendance::create([
                    'student_id' => $siswa->id,
                    'status' => 'alpha',
                    'jam_datang' => null,
                    'jam_pulang' => null,
                    'keterangan' => 'Tidak hadir tanpa keterangan',
                ]);

                $this->info("Siswa ID {$siswa->id} ditandai Alpha.");
            }
        }

        $this->info('Proses selesai.');
    }
}
