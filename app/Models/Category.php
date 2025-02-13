<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    public function filters(): BelongsToMany
    {
        return $this->belongsToMany(Filter::class, 'filter_fc_mappings');
    }

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class, 'category_id');
    }
}
