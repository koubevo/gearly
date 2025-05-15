<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'location',
        'lang',
        'last_login_at',
    ];

    protected $casts = [
        'last_login_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email',
        'email_verified_at',
        'premium_ends_at',
        'role',
        'updated_at',
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
            'premium_ends_at' => 'datetime',
        ];
    }

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class, 'user_id');
    }

    public function hasBoughtOffers(): HasMany
    {
        return $this->hasMany(Offer::class, 'buyer_id');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'user_id');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'user_id');
    }

    public function givenRatings(): HasMany
    {
        return $this->hasMany(Rating::class, 'user_id');
    }

    public function receivedRatings(): HasMany
    {
        return $this->hasMany(Rating::class, 'rated_user_id');
    }

    public function hasPremium()
    {
        return $this->premium_ends_at?->isFuture() ?? false;
    }

    public function sellerMessages()
    {
        return $this->hasMany(Message::class, 'seller_id');
    }

    public function buyerMessages()
    {
        return $this->hasMany(Message::class, 'buyer_id');
    }

    public function authorMessages()
    {
        return $this->hasMany(Message::class, 'author_id');
    }

    public function receiverMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function getRating()
    {
        return Rating::where('rated_user_id', $this->id)
            ->selectRaw('ROUND(AVG(stars), 1) as stars, COUNT(id) as count')
            ->first()
            ->toArray();
    }
}