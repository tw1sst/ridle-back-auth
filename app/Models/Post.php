<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'tags',
        'school_id',
        'user_id',
        'parent_id'
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function childPosts()
    {
        return $this->hasMany(Post::class, 'parent_id', 'id')->with('user')->orderBy('id', 'desc');
    }
}
