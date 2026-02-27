<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\CosplayerPhoto;
use App\Models\PhotographerProfile;
use App\Models\Album;
use Illuminate\Database\Eloquent\Relations\HasOne;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

public function cosplayerProfile()
{
    return $this->hasOne(\App\Models\CosplayerProfile::class);
}
 public function photos()
    {
        return $this->hasMany(CosplayerPhoto::class);
    }

public function albums()
{
    return $this->hasMany(Album::class);
}


public function photographerProfile(): HasOne
{
    return $this->hasOne(PhotographerProfile::class);
}

public function cosplayerPhotos()
{
    return $this->hasMany(Photo::class);
}

public function favorites()
{
    return $this->hasMany(Favorite::class);
}

public function favoriteAlbums()
{
    return $this->belongsToMany(Album::class, 'favorites')->withTimestamps();
}

public function contactMessages()
{
    return $this->hasMany(ContactMessage::class, 'recipient_id');
}

public function shopItems()
{
    return $this->hasMany(ShopItem::class);
}

}
