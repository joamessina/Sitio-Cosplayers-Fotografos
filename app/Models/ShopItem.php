<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopItem extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'instagram',
        'photos',
        'status',
    ];

    protected $casts = [
        'photos' => 'array',
        'price'  => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
