<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'name',
        'description',
        'price',
        'currency',
        'condition',
        'sport',
        'category_id',
        'brand_id',
        'created_at',
        'updated_at'
    ];
}
