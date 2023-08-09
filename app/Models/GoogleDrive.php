<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class GoogleDrive extends Model
{
    use HasFactory, HasApiTokens;

    protected $connection  = 'mongodb';
    protected $collection = 'googledrive';
    protected $fillable = [
        '_id',
        'id_ggdrive',
        'name_file',
        'user',
        'created_at',
    ];

    protected $hidden = [
        'updated_at',
    ];
}
