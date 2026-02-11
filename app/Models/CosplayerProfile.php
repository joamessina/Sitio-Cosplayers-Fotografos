<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CosplayerProfile extends Model
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
        'avatar_path',
        'cover_path',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
