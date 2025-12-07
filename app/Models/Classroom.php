<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $table = 'classes';
    protected $fillable = ['name', 'wali_kelas_id'];

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }

    public function classroom()
{
    return $this->belongsTo(Classroom::class, 'class_id');
}

public function teachingAssignments()
{
    return $this->hasMany(ClassSubjectTeacher::class);
}

}
