<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }
}
