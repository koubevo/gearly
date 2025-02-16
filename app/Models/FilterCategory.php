<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FilterCategory extends Model
{
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'filter_fc_mappings', 'filter_category_id', 'category_id');
    }

    public function filters(): HasMany
    {
        return $this->hasMany(Filter::class, 'filter_category_id');
    }

    public function offerFilters(): HasMany
    {
        return $this->hasMany(OfferFilter::class, 'filter_category_id');
    }
}
