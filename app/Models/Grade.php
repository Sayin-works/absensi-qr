<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'subject_id',
        'kd1', 'kd2', 'kd3', 'kd4', 'kd5', 'kd6', 'kd7', 'kd8',
        'nilai_uts', 'nilai_uas', 'nilai_akhir'
    ];



    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function class()
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }
    public function classroom()
{
    return $this->belongsTo(Classroom::class, 'class_id');
}

}

