<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Support\Facades\Log;

Broadcast::routes(['middleware' => ['web', 'auth']]);

Broadcast::channel('chat.{offer}.{buyer}', function ($user, $offerId, $buyerId) {
    $offer = Offer::find($offerId);

    if (!$offer) {
        Log::warning("Unauthorized channel access: Offer {$offerId} not found.");
        return false;
    }

    if ($user->id === $offer->user_id || $user->id == $buyerId) {
        return true;
    }

    Log::warning("Unauthorized channel access: User {$user->id} tried to listen to chat {$offerId}-{$buyerId}");
    return false;
});
