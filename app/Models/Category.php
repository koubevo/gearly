<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function filters()
    {
        return $this->belongsToMany(Filter::class, 'filter_fc_mappings');
    }
}
