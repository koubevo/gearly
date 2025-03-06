<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Offer;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        $latestMessages = Message::with(['offer.seller', 'buyer'])
            ->where(function ($query) use ($user) {
                $query->where('buyer_id', $user->id)
                    ->orWhereHas('offer', function ($subQuery) use ($user) {
                        $subQuery->where('user_id', $user->id);
                    });
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(fn($message) => $message->offer_id . '-' . $message->buyer_id)
            ->map(fn($group) => $group->first())
            ->values();

        $chats = $latestMessages->map(function ($message) use ($user) {
            return [
                'offer' => [
                    'id' => $message->offer->id,
                    'name' => $message->offer->name,
                    'price' => $message->offer->price,
                    'currency' => $message->offer->currency,
                    'status' => $message->offer->status,
                    'thumbnail_url' => $message->offer->getFirstMediaUrl('images', 'thumb'),
                ],
                'buyer_name' => optional($message->buyer)->name,
                'buyer_id' => $message->buyer->id,
                'seller_name' => $message->offer->seller->name,
                'seller_id' => $message->offer->seller->id,
                'last_message' => $message->message,
                'last_message_time' => $message->created_at->diffForHumans(),
            ];
        });

        return inertia('Chat/Index', [
            'chats' => $chats
        ]);
    }

    public function show(Offer $offer, User $buyer)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        if (!($buyer->id === $user->id || $offer->user_id === $user->id)) {
            abort(403, 'You are not allowed to access this page.');
        }

        $messagesCount = $offer->messages()
            ->where('seller_id', $offer->user_id)
            ->where('buyer_id', $buyer->id)
            ->where('offer_id', $offer->id)
            ->count();

        if ($messagesCount == 0 && $user->id == $offer->user_id) {
            abort(403, 'You are not allowed to access this page.');
        }

        if ($messagesCount == 0 && $offer->status !== 'active') {
            abort(403, 'You are not allowed to access this page.');
        }

        $offer->thumbnail_url = $offer->getFirstMediaUrl('images', 'thumb');

        $ratingExists = Rating::where('offer_id', $offer->id)
            ->where('user_id', $user->id)
            ->first();

        $averageRating = $user->id == $offer->user_id ? $buyer->getRating() : $offer->seller->getRating();

        return inertia('Chat/Show', [
            'seller' => $offer->seller,
            'buyer' => $buyer,
            'offer' => $offer,
            'thumbnail_url' => $offer->thumbnail_url,
            'rating' => $averageRating,
            'ableToRate' => $offer->status === 'received' && !$ratingExists,
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
            ->get()
            ->map(function ($message) {
                $message->created_at_formatted = $message->created_at->diffForHumans();
                return $message;
            });

        return response()->json([
            'messages' => $messages,
        ]);

    }

    public function sendMessage(Request $request, Offer $offer, User $buyer)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $receiver_id = $user->id == $buyer->id ? $offer->user_id : $buyer->id;

        if (!($buyer->id === $user->id || $offer->user_id === $user->id)) {
            abort(403, 'You are not allowed to access this page.');
        }

        $message = $offer->messages()->create([
            'seller_id' => $offer->user_id,
            'buyer_id' => $buyer->id,
            'author_id' => $user->id,
            'receiver_id' => $receiver_id,
            'offer_id' => $offer->id,
            'type_id' => $request->type_id,
            'cs' => null,
            'message' => $request->validate([
                'message' => 'required|string|max:255',
            ])['message'],
        ]);

        broadcast(new \App\Events\MessageSent($message));
    }

}
