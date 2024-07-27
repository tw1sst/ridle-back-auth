<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'owner_id',
        'nick_name',
        'cover_path',
        'logo_path',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
