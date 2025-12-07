<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table = 'informations'; // 👈 tambahkan baris ini

    protected $fillable = [
        'title', 'content', 'date', 'image'
    ];
}
