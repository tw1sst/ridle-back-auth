<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollow extends Model
{
    use HasFactory;

     protected $fillable = [
        'user-id',
        'to_user_id',
        'to_school_id'
    ];
}
