<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateDailyAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-daily-attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
public function handle()
{
    $today = now()->toDateString();
    $kelas = Kelas::all();

    foreach ($kelas as $kls) {
        $siswa = $kls->students;

        foreach ($siswa as $student) {
            Attendance::firstOrCreate([
                'student_id' => $student->id,
                'tanggal' => $today,
            ], [
                'status' => '-', // Belum absen
                'keterangan' => 'Belum scan',
            ]);
        }
    }

    $this->info("Absensi otomatis berhasil dibuat untuk tanggal $today");
}
}
