<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Category extends Model
{
    use HasFactory, HasApiTokens;

    protected $collection = 'categories';
    protected $fillable = [
        '_id',
        'name',
        'discription',
        'author',
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];
}
