<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'bio',
        'avatar',
        'is_email_public',
    ];

    protected $casts = [
        'is_email_public' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}