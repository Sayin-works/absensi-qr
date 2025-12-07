<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use App\Models\Attendance;
use Carbon\Carbon;

class ServeWithAbsensi extends Command
{
    /**
     * Nama perintah yang akan dipanggil.
     */
    protected $signature = 'serve:absensi';

    /**
     * Deskripsi perintah.
     */
    protected $description = 'Menjalankan server dan auto menambah data absensi harian';

    /**
     * Jalankan perintah.
     */
    public function handle()
    {
        $this->info('Menambahkan data absensi otomatis untuk hari ini...');

        $today = Carbon::today();
        $students = Student::all();

        $added = 0;
        foreach ($students as $student) {
            if (!Attendance::where('student_id', $student->id)->whereDate('date', $today)->exists()) {
                Attendance::create([
                    'student_id' => $student->id,
                    'date'       => $today,
                    'status'     => 'Hadir', // Atau default lain
                ]);
                $added++;
            }
        }

        $this->info("Absensi otomatis selesai. Total data ditambahkan: {$added}");

        $this->info('Menjalankan server Laravel...');
        passthru(PHP_BINARY . ' artisan serve');
    }
}
