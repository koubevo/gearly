<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        return inertia('Chat/Index');
    }

    public function show(Offer $offer, User $buyer = null)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        if (isset($buyer)) {
            if (!($buyer?->id === $user->id || $offer->user_id === $user->id)) {
                abort(403, 'You are not allowed to access this page.');
            }
        }

        //TODO: zkontrolovat
        if (!$buyer && $user->id !== $offer->user_id) {
            $buyer = $user;
        } else if (!$buyer) {
            abort(403, 'You are not allowed to access this page.');
        } else if ($buyer->id === $user->id) {
            abort(403, 'You are not allowed to access this page.');
        }

        $offer->thumbnail_url = $offer->getFirstMediaUrl('images', 'thumb');

        $messages = $offer->messages()
            ->where('seller_id', $offer->user_id)
            ->where('buyer_id', $buyer->id)
            ->where('offer_id', $offer->id)
            ->get();

        return inertia('Chat/Show', [
            'seller' => $offer->seller,
            'buyer' => $buyer,
            'offer' => $offer,
            'thumbnail_url' => $offer->thumbnail_url,
            'messages' => $messages,
        ]);
    }

}
