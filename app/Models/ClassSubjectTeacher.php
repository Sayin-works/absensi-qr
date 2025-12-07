<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSubjectTeacher extends Model
{
    protected $fillable = ['class_id', 'subject_id', 'user_id'];

    public function class()
    {
        return $this->belongsTo(Classroom::class); // Ganti jika nama model kamu 'Kelas'
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

