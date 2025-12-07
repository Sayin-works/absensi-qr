<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'student_id',
        'date',
        'status',
        'note'
    ];

    // Relasi ke siswa
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relasi ke kelas
    public function class()
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }
}
