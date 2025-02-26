<?php

namespace App\Http\Controllers;

use App\Models\Message;
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

        return inertia('Chat/Show', [
            'seller' => $offer->seller,
            'buyer' => $buyer,
            'offer' => $offer,
            'thumbnail_url' => $offer->thumbnail_url,
        ]);
    }

    public function loadMessages(Offer $offer, User $buyer)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        if (!($buyer->id === $user->id || $offer->user_id === $user->id)) {
            abort(403, 'You are not allowed to access this page.');
        }

        $messages = $offer->messages()
            ->where('seller_id', $offer->user_id)
            ->where('buyer_id', $buyer->id)
            ->where('offer_id', $offer->id)
            ->get();

        return response()->json([
            'messages' => $messages,
        ]);

    }

    public function sendMessage(Request $request, Offer $offer, User $buyer)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        if (!($buyer->id === $user->id || $offer->user_id === $user->id)) {
            abort(403, 'You are not allowed to access this page.');
        }

        $message = $offer->messages()->create([
            'seller_id' => $offer->user_id,
            'buyer_id' => $buyer->id,
            'author_id' => $user->id,
            'offer_id' => $offer->id,
            'type_id' => $request->type_id,
            'message' => $request->validate([
                'message' => 'required|string|max:255',
            ])['message'],
        ]);

        return response()->json([
            'message' => $message,
        ]);
    }
}
