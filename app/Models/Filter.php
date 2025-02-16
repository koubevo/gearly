<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Filter extends Model
{
    public function filterCategory(): BelongsTo
    {
        return $this->belongsTo(FilterCategory::class, 'filter_category_id');
    }

    public function offerFilters(): HasMany
    {
        return $this->hasMany(OfferFilter::class, 'filter_id');
    }
}
