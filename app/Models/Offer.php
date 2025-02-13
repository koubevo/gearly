<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Offer extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'name',
        'description',
        'price',
        'currency',
        'condition',
        'sport',
        'category_id',
        'brand_id',
        'created_at',
        'updated_at'
    ];

    public function owner(): BelongsTo
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
}
