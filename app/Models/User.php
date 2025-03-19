<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->uuid = Str::uuid();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'email',
        'gender',
        'phone',
        'town',
        'location',
        'password',
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
     * Get the attributes that should be cast.
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

    /**
     * The attributes that should be cast.
     */
    public function order()
    {
        return $this->hasMany(Orders::class);
    }

    public function comments()
    {
        return $this->hasMany(Comments::class);
    }

    public function ratings()
    {
        return $this->hasMany(Ratings::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
