<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CosplayerPhoto extends Model
{
    protected $fillable = [
        'user_id',
        'path',
        'caption',
    ];
}
