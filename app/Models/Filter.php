<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Filter extends Model
{
    public function filterCategory(): BelongsTo
    {
        return $this->belongsTo(FilterCategory::class, 'filter_category_id');
    }
}
