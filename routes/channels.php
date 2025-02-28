<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Support\Facades\Log;

Broadcast::routes(['middleware' => ['web', 'auth']]);

Broadcast::channel('chat.{offer}.{buyer}', function ($user, $offerId, $buyerId) {
    //TODO: check if user is seller or buyer
    return true;
});
