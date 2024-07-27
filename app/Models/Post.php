<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'tags',
        'school_id',
        'user_id',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
