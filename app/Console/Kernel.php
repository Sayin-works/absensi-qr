<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Student;
use App\Models\Attendance;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        /**
         * 1️⃣ Pagi (jam 00:01) → Buat absensi baru
         */
        $schedule->call(function () {
            $today = Carbon::today();
            $students = Student::all();
            $added = 0;

            foreach ($students as $student) {
                if (!Attendance::where('student_id', $student->id)->whereDate('date', $today)->exists()) {
                    Attendance::create([
                        'student_id' => $student->id,
                        'date'       => $today,
                        'status'     => 'Hadir',
                        'keterangan' => 'Hadir',
                    ]);
                    $added++;
                }
            }

            \Log::info("Absensi otomatis pagi: {$added} data dibuat untuk {$today->toDateString()}");

        })->dailyAt('00:01');

        /**
         * 2️⃣ Sore (jam 17:00) → Ubah jadi Alpa kalau belum scan pulang
         */
        $schedule->call(function () {
            $today = Carbon::today();

            $attendances = Attendance::whereDate('date', $today)
                ->whereNull('jam_pulang')
                ->get();

            foreach ($attendances as $attendance) {
                $attendance->status = 'Alpa';
                $attendance->keterangan = 'Alpa';
                $attendance->save();
            }

            \Log::info("Absensi otomatis sore: " . count($attendances) . " data diubah jadi Alpa untuk {$today->toDateString()}");

        })->dailyAt('17:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
