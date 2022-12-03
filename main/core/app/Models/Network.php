<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Network extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mongodb';
    protected $collection = 'network';
    protected $fillable = [
        "user_id",
        "peer_type",
        "public_key",
        "allowed_ip",
        "device_type",
        "device_name",
        "container_id",
        "container_name",
    ];
    protected $dates = ['deleted_at'];
}
