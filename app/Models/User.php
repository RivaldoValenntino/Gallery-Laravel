<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Support\Str;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\HasApiTokens;

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
        'username',
        'role',
        'avatar',
    ];

    protected $appends = [
        'avatar',
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
        'password' => 'hashed',
    ];

    public static function register(array $input): self
    {
        return static::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
            'username' => $input['username'],
        ]);
    }
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function rulesForUpdatingEmail(string $email): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->id),
            ],
        ];
    }

    public function rulesForUpdatingUsername(string $username): array
    {
        return [
            'username' => [
                'required',
                Rule::unique('users')->ignore($this->id),
            ],
        ];
    }

    protected static function booted()
    {
        parent::boot();
        static::updated(function ($model) {
            if ($model->isDirty('avatar') && ($model->getOriginal('avatar') !== null)) {
                Storage::disk('public')->delete($model->getOriginal('avatar'));
            }
        });
    }


    public function getAvatarAttribute()
    {
        return Storage::url($this->attributes['avatar']);
    }

    public function albums()
    {
        return $this->hasMany(Album::class);
    }
    public function photo()
    {
        return $this->hasMany(Photo::class);
    }
    public function likes()
    {
        return $this->belongsToMany(Photo::class, 'like_photo')->withTimestamps();
    }

    public function totalLikes()
    {
        return $this->photo()->withCount('likes')->get()->sum('likes_count');
    }


    public function hasLiked(Photo $photo)
    {
        return $this->likes()->where('photo_id', $photo->id)->exists();
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function getRouteKeyName()
    {
        return 'username';
    }
}
