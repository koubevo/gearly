<?php

namespace App\Models;

use App\Enums\ConditionEnum;
use App\Enums\SportEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Offer extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes;

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
        'delivery_detail',
        'created_at',
        'updated_at'
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
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
        return SportEnum::tryFrom($this->sport_id);
    }

    public function offerFilters(): HasMany
    {
        return $this->hasMany(OfferFilter::class, 'offer_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'offer_id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(400)
            ->height(400)
            ->nonQueued();
    }

    public function getThumbnailUrl()
    {
        $media = $this->getFirstMedia('images');
        return $media ? $media->getUrl('thumb') : null;
    }

    public function scopeFilter($query, array $filters)
    {
        return $query->when(
            $filters['brand'] ?? null,
            fn($query, $brand)
            => $query->where(
                'brand_id',
                $brand
            )
        )->when(
                $filters['category'] ?? null,
                fn($query, $category)
                => $query->where(
                    'category_id',
                    $category
                )
            )->when(
                $filters['sport'] ?? null,
                fn($query, $sport) => $sport == 1 ? $query : $query->where(function ($query) use ($sport) {
                    $query->where('sport_id', $sport)
                        ->orWhere('sport_id', 1);
                })
            )->when(
                $filters['search'] ?? null,
                fn($query, $search) => $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhereHas('brand', fn($query) => $query->where('name', 'like', '%' . $search . '%'));
                })
            );
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeSold(Builder $query): Builder
    {
        return $query->where('status', 'sold');
    }

    public function scopeMostRecent(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeCheapest(Builder $query): Builder
    {
        return $query->orderBy('price', 'asc');
    }

    public function scopeMostExpensive(Builder $query): Builder
    {
        return $query->orderBy('price', 'desc');
    }

    public function scopeSort(Builder $query, int|null $order): Builder
    {
        if ($order === 0) {
            return $query->cheapest()->orderBy('created_at', 'desc');
        }

        if ($order === 1) {
            return $query->mostExpensive()->orderBy('created_at', 'desc');
        }

        return $query->mostRecent();
    }

    public function scopeBaseball(Builder $query): Builder
    {
        return $query->where('sport_id', 2)->orWhere('sport_id', 1);
    }

    public function scopeSoftball(Builder $query): Builder
    {
        return $query->where('sport_id', 3)->orWhere('sport_id', 1);
    }
}
