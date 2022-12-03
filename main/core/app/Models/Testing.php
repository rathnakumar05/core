<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Testing extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'my_books_collection';
    protected $fillable = [
        'id',
        'name'
    ];
}
