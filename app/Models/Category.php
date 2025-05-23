<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'cs',
        'logo',
        'created_at',
        'updated_at',
    ];

    public function filterCategories(): BelongsToMany
    {
        return $this->belongsToMany(FilterCategory::class, 'filter_fc_mappings', 'category_id', 'filter_category_id');
    }

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class, 'category_id');
    }
}
