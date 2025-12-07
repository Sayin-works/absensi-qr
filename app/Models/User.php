<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'subject_id',
    'class_id',
    'is_subject_teacher',
    'is_homeroom_teacher',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function student()
    {
        return $this->hasOne(Student::class, 'walimurid_id');
    }
// User.php





public function classes()
{
    return $this->belongsToMany(Classroom::class, 'guru_kelas', 'user_id', 'classroom_id');
}


    public function class()
{
    return $this->belongsTo(Classroom::class, 'class_id'); // ganti 'ClassModel' sesuai nama model aslimu
}

public function teachingAssignments()
{
    return $this->hasMany(ClassSubjectTeacher::class);
}

public function children()
{
    return $this->hasMany(Student::class, 'parent_id');
}
public function subjects()
{
    return $this->belongsToMany(Subject::class, 'subject_user', 'user_id', 'subject_id');
}


}
