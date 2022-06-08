<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Post extends Model
{
    use HasFactory, HasApiTokens;

    protected $collection = 'posts';
    protected $fillable = [
        'title',
        'discription',
        'tag',
        'author',
        'content',
        'images',
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];
}
