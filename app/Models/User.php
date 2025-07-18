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

    private const ROLE_ADMIN = 1;
    private const ROLE_USER = 0;

    protected $fillable = [
        'name',
        'email',
        'password',
        'location',
        'lang',
        'last_login_at',
        'notifications_inactive',
        'notifications_new_messages',
        'notifications_new_message',
        'notifications_closure_reminder',
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
        'updated_at',
        'notifications_inactive',
        'notifications_new_messages',
        'notifications_new_message',
        'notifications_closure_reminder',
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

    protected $appends = [
        'is_premium',
        'is_admin',
    ];

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

    public function getIsPremiumAttribute(): bool
    {
        return $this->premium_ends_at?->isFuture() ?? false;
    }

    public function getIsAdminAttribute(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }
}