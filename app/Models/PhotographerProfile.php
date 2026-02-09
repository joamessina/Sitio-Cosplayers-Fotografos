<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhotographerProfile extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'display_name',
        'bio',
        'instagram',
        'portfolio_url',
        'location',
        'primary_color',
        'secondary_color',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
