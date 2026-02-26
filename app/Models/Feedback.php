<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'type',
        'message',
        'ip',
        'is_read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function typeLabel(): string
    {
        return match($this->type) {
            'suggestion' => 'Sugerencia',
            'bug'        => 'Bug',
            'other'      => 'Otro',
            default      => 'Desconocido',
        };
    }
}
