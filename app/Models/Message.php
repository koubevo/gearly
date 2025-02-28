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
        return $this->belongsTo(Offer::class, 'offer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
