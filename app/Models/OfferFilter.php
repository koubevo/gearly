<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfferFilter extends Model
{
    protected $fillable = [
        'offer_id',
        'filter_category_id',
        'filter_id',
    ];

    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }

    public function filterCategory(): BelongsTo
    {
        return $this->belongsTo(FilterCategory::class, 'filter_category_id');
    }

    public function filter(): BelongsTo
    {
        return $this->belongsTo(Filter::class, 'filter_id');
    }
}