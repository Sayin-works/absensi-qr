<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance; // ✅ ini yang kurang
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        Attendance::create([
            'student_id' => 1, // pastikan ID 1 sesuai dengan siswa yang sudah ada
            'date' => Carbon::now()->toDateString(),
            'time' => Carbon::now()->toTimeString(),
            'type' => 'masuk',
        ]);
    }
}
