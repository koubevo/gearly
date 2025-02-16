<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferFilter extends Model
{
    protected $fillable = [
        'offer_id',
        'filter_category_id',
        'filter_id',
    ];

}
