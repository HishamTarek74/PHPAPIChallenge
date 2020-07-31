<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $table = 'posts';

    protected $fillable = [
        'title',
        'post_content',
        'author',
        'user_id',
        'created_at',
        'updated_at',
    ];

    public function user()
    {

        return $this->belongsTo(\App\User::class);
    }
}
