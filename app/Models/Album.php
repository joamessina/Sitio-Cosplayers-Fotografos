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
        'drive_url',
        'thumbnail',
        'featured_photo_urls',
        'featured_photos_count',
        'location',
        'description',
        'drive_url',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'event_date' => 'date',
        'featured_photo_urls' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function isFavoritedBy($user)
    {
        return $user && $this->favorites()->where('user_id', $user->id)->exists();
    }
}
