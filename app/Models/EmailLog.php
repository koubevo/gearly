<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $fillable = [
        'receiver_id',
        'sender_id',
        'offer_id',
        'type',
        'sent_at',
    ];

    protected $dates = ['sent_at'];
}
