<?php

namespace App\Models;

use App\Enums\ConditionEnum;
use App\Enums\SportEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Offer extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'currency',
        'condition',
        'sport_id',
        'category_id',
        'brand_id',
        'delivery_option_id',
        'delivery_description',
        'created_at',
        'updated_at'
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class, 'offer_id');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'offer_id');
    }

    public function deliveryOption(): BelongsTo
    {
        return $this->belongsTo(DeliveryOption::class, 'delivery_option_id');
    }

    public function getSportEnum(): ?SportEnum
    {
        return SportEnum::tryFrom($this->sport);
    }
}
