<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Services extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mongodb';
    protected $collection = 'services';
    protected $fillable = [
        "user_id",
        "mysql"
    ];
    protected $dates = ['deleted_at'];
}
