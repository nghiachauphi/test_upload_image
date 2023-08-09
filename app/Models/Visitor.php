<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Jenssegers\Mongodb\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory, HasApiTokens;

    protected $connection  = 'mongodb';
    protected $collection = 'visitor';
    protected $fillable = [
        'user_agent',
        'ip',
        'path',
        'date',
        'created_at',
    ];

    protected $hidden = [
        'updated_at',
    ];
}
