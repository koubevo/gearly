<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    const UPDATED_AT = null;

    protected $fillable = [
        'offer_id',
        'seller_id',
        'buyer_id',
        'author_id',
        'receiver_id',
        'message',
        'type_id',
        'created_at'
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class);
    }
}
