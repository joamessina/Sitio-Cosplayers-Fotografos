<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'event',
        'event_date',
        'location',
        'description',
        'drive_url',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'event_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
