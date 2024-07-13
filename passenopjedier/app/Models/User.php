<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
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
        'blocked',
        'role',
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
        'role',
        'blocked'
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

    public function pets(): HasMany
    {
        return $this->hasMany(Pet::class);
    }

    public function houseImages(): HasMany
    {
        return $this->hasMany(HouseImage::class);
    }

    public function sittingRequests(): HasMany
    {
        return $this->hasMany(SittingRequest::class);
    }

    public function ownedPets(): HasMany
    {
        return $this->hasMany(Pet::class, 'user_id');
    }

    public function getAvatarUrl(){
        return Storage::url($this->avatar);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'pet_owner_id');
    }

    public function reviewedBy(): HasMany
    {
        return $this->hasMany(Review::class, 'sitter_id');
    }
}
