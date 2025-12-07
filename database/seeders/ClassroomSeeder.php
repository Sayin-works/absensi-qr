<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\User;


class ClassroomSeeder extends Seeder
{
    public function run(): void
    {
        $grades = ['7', '8', '9'];
        $parallels = range('A', 'J'); // A-J

        foreach ($grades as $grade) {
            foreach ($parallels as $parallel) {
                Classroom::create([
                    'name' => $grade . ' ' . $parallel
                ]);
            }
        }
    }
}
