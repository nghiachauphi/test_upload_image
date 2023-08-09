<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Jenssegers\Mongodb\Eloquent\Model;

class Contact extends Model
{
    use HasFactory, HasApiTokens;

    protected $connection  = 'mongodb';
    protected $collection = 'contact';
    protected $fillable = [
        'name',
        'email_phone',
        'title',
        'content_info',
        'image_contact',
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];
}
