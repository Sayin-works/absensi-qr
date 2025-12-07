<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Classroom;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
    'name', 'qr_code_id', 'class_id', 'walimurid_id',
    'nisn', 'gender', 'birth_place', 'birth_date',
    'address', 'religion', 'phone', 'status', 'photo'
];

    public function classRoom()
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }

    public function attendances()
{
    return $this->hasMany(Attendance::class);
}

public function parent()
{
    return $this->belongsTo(User::class, 'parent_id');
}

public function walimurid()
{
    return $this->belongsTo(User::class, 'walimurid_id');
}


public function grades()
{
    return $this->hasMany(Grade::class, 'student_id');
}




    
}
