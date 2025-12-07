<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use App\Models\Attendance;
use Carbon\Carbon;

class UpdateLateAttendance extends Command
{
    protected $signature = 'update:late-attendance';
    protected $description = 'Tandai siswa yang belum absen hingga jam 9 pagi sebagai Alpa';

    public function handle()
    {
        $today = now()->toDateString();

        // Ambil semua siswa
        $students = Student::all();

        foreach ($students as $student) {
            $attendance = Attendance::where('student_id', $student->id)
                                    ->whereDate('created_at', $today)
                                    ->first();

            if (!$attendance) {
                Attendance::create([
                    'student_id' => $student->id,
                    'status' => 'Alpa',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'date' => Carbon::today(), 
                ]);

                $this->info("Siswa {$student->name} ditandai Alpa");
            }
        }

        return Command::SUCCESS;
    }
}
