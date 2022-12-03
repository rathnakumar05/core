<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Devices extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mongodb';
    protected $collection = 'devices';
    protected $fillable = [
        "user_id",
        "devices",
    ];
    protected $dates = ['deleted_at'];

}
