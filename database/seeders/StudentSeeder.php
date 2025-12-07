<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\User;
use App\Models\Classroom;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada user walimurid
        $wali = User::firstOrCreate(
            ['email' => 'walimurid@example.com'],
            [
                'name' => 'Wali Murid 1',
                'password' => bcrypt('password'),
                'role' => 'walimurid'
            ]
        );

        // Ambil kelas
        $kelas7A = Classroom::where('name', '7 A')->first();
        $kelas7B = Classroom::where('name', '7 B')->first();

        // Tambahkan siswa yang sudah tertaut
        Student::create([
            'name' => 'Siti Aminah',
            'class_id' => $kelas7A->id,
            'qr_code_id' => 'QR123456',
            'walimurid_id' => $wali->id,
        ]);

        // Tambahkan siswa yang belum tertaut (akan muncul di form tautkan)
        Student::create([
            'name' => 'Budi Santoso',
            'class_id' => $kelas7B->id,
            'qr_code_id' => 'QR654321',
            'walimurid_id' => null,
        ]);
    }
}
