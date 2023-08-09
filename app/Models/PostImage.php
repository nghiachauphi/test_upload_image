<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class PostImage extends Model
{
    use HasFactory, HasApiTokens;

    protected $connection  = 'mongodb';
    protected $collection = 'freeimage';
    protected $fillable = [
        '_id',
        'user',
        'image_base64',
        'created_at',
    ];

    protected $hidden = [
        'updated_at',
    ];
}
