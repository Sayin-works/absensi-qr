<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class SubjectAttendance extends Model
{
    protected $fillable = [
        'subject_id',
        'class_id', // pastikan nama kolomnya class_id (bukan classroom_id)
        'date',
        'present_count',
        'absent_count',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function classroom()
    {
        // Kalau nama kolom di tabel subject_attendances adalah class_id
        return $this->belongsTo(Classroom::class, 'class_id');
    }
}
