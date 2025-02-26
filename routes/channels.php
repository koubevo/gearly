<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Support\Facades\Log;

Broadcast::routes(['middleware' => ['web', 'auth']]);

Broadcast::channel('chat.{offer}.{buyer}', function ($user, $offerId, $buyerId) {
    Log::info("🟢 WebSocket autentizace spuštěna pro chat: {$offerId}.{$buyerId} uživatelem {$user->id}");

    return true; // Zkusíme povolit všem, později zpřísníme
});
