<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'cover_path',
        'logo_path',
        'school_id',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
