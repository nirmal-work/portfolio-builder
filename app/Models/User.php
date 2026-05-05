<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'slug',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (User $user) {
            if (empty($user->username)) {
                $user->username = self::generateUniqueUsername($user->name);
            }

            if (empty($user->slug)) {
                $user->slug = self::generateUniqueSlug($user->name);
            }
        });
    }

    public function setSlugAttribute(?string $value): void
    {
        if ($this->exists) {
            return; // make slug immutable once created
        }

        $this->attributes['slug'] = $value;
    }

    public static function generateUniqueUsername(string $name): string
    {
        $base = Str::slug($name, '_');
        $username = $base;
        $count = 0;

        while (self::where('username', $username)->exists()) {
            $count++;
            $username = $base . '_' . $count;
        }

        return $username;
    }

    public static function generateUniqueSlug(string $name): string
    {
        $base = Str::slug($name, '-');
        $slug = $base;
        $count = 0;

        while (self::where('slug', $slug)->exists()) {
            $count++;
            $slug = $base . '-' . $count;
        }

        return $slug;
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function education()
    {
        return $this->hasMany(Education::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function socialLinks()
    {
        return $this->hasMany(SocialLink::class);
    }
}
