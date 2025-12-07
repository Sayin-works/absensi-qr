<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use App\Models\Attendance;
use Carbon\Carbon;

class AutoMarkAlpaCheckout extends Command
{
    protected $signature = 'attendance:auto-mark';
    protected $description = 'Otomatis menandai Alpa dan check-out untuk siswa';

    public function handle()
    {
        $today = Carbon::today()->toDateString();
        $now = Carbon::now();

        $batasAlpa = Carbon::createFromTime(12, 0, 0);
        $batasCheckout = Carbon::createFromTime(15, 0, 0);

        $students = Student::all();

        foreach ($students as $student) {
            $attendance = Attendance::where('student_id', $student->id)
                ->where('date', $today)
                ->first();

            // Auto Alpa jam 12
            if (!$attendance && $now->greaterThan($batasAlpa)) {
                Attendance::create([
                    'student_id' => $student->id,
                    'date' => $today,
                    'status' => 'Alpa',
                    'check_in' => null,
                    'check_out' => null,
                    'keterangan' => 'Alpa'
                ]);
                continue;
            }

            if ($attendance && is_null($attendance->check_in) && $now->greaterThan($batasAlpa)) {
                $attendance->update([
                    'status' => 'Alpa',
                    'keterangan' => 'Alpa'
                ]);
            }

            // Auto check-out jam 15
            if ($attendance && !is_null($attendance->check_in) && is_null($attendance->check_out) && $now->greaterThan($batasCheckout)) {
                $attendance->update([
                    'check_out' => $batasCheckout->format('H:i:s')
                ]);
            }
        }

        $this->info('Auto mark Alpa & checkout berhasil dijalankan.');
    }
}
