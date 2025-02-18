<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class, 'brand_id');
    }
}
