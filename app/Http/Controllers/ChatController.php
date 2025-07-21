<?php

namespace App\Http\Controllers;

use App\Helpers\LanguageHelper;
use App\Models\Message;
use App\Models\Offer;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Jobs\ProcessNewMessageEmailNotification;


class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $latestMessages = Message::with(['offer.seller', 'buyer'])
            ->where(function ($query) use ($user) {
                $query->where('buyer_id', $user->id)
                    ->orWhereHas('offer', function ($subQuery) use ($user) {
                        $subQuery->where('user_id', $user->id);
                    });
            })
            ->whereHas('offer', function ($query) {
                $query->whereIn('status', [1, 2, 3]);
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(fn($message) => $message->offer_id . '-' . $message->buyer_id)
            ->map(fn($group) => $group->first())
            ->values()
            ->filter(fn($message) => $message->buyer !== null && $message->offer !== null && $message->offer->seller !== null);

        $chats = $latestMessages->map(function ($message) use ($user) {
            $unreadCount = Message::where('offer_id', $message->offer->id)
                ->where('buyer_id', $message->buyer->id)
                ->where('receiver_id', $user->id)
                ->whereNull('read_at')
                ->count();

            return [
                'offer' => [
                    'id' => $message->offer->id,
                    'name' => $message->offer->name,
                    'price' => $message->offer->price,
                    'currency' => $message->offer->currency,
                    'status' => $message->offer->getStatusEnum()?->label(),
                    'statusNumber' => $message->offer->status,
                    'thumbnail_url' => $message->offer->getFirstMediaUrl('images', 'thumb'),
                ],
                'buyer' => $message->buyer,
                'seller' => $message->offer->seller,
                'last_message' => $message->message,
                'last_message_time' => $message->created_at->diffForHumans(),
                'unread_count' => $unreadCount,
            ];
        });

        return inertia('Chat/Index', [
            'chats' => $chats
        ]);
    }


    /**
     * Displays the chat details and related information for a specific offer and buyer.
     *
     * Authorizes access for the buyer or the offer's seller, ensures chat eligibility, augments offer details, marks messages as read, and returns the chat view with seller, buyer, offer data, thumbnail, average rating, and rating eligibility.
     *
     * @param Offer $offer The offer associated with the chat.
     * @param User $buyer The buyer involved in the chat.
     * @return \Inertia\Response The rendered chat details view.
     */
    public function show(Offer $offer, User $buyer)
    {
        $user = Auth::user();
        $langColumn = LanguageHelper::getLangColumnForMessages();

        if (!($buyer->id === $user->id || $offer->user_id === $user->id)) {
            abort(403, 'You are not allowed to access this page.');
        }

        $messagesCount = $offer->messages()
            ->where('seller_id', $offer->user_id)
            ->where('buyer_id', $buyer->id)
            ->where('offer_id', $offer->id)
            ->count();

        // If there are no messages and the user is the seller, he is not allowed to access the chat
        if ($messagesCount == 0 && $user->id == $offer->user_id) {
            abort(403, 'You are not allowed to access this page.');
        }

        // If there are no messages and the user is the buyer, he is not allowed to access the chat if the offer is not active
        if ($messagesCount == 0 && $offer->status !== 1) {
            abort(403, 'You are not allowed to access this page.');
        }

        $offer->thumbnail_url = $offer->getFirstMediaUrl('images', 'thumb');

        $offer->statusNumber = $offer->status;
        $offer->status = $offer->getStatusEnum()?->label();
        $offer->is_buyer = $buyer->id === $user->id;

        $ratingExists = Rating::where('offer_id', $offer->id)
            ->where('user_id', $user->id)
            ->first();

        $averageRating = $user->id == $offer->user_id ? $buyer->getRating() : $offer->seller->getRating();

        $this->markAsRead($offer, $buyer);

        $deliveryOptionLangColumn = LanguageHelper::getLangColumn();
        $deliveryOption = \App\Models\DeliveryOption::find($offer->delivery_option_id);
        $offer->delivery_option = $deliveryOption->$deliveryOptionLangColumn;

        return inertia('Chat/Show', [
            'seller' => $offer->seller,
            'buyer' => $buyer,
            'offer' => $offer,
            'thumbnail_url' => $offer->thumbnail_url,
            'rating' => $averageRating,
            'ableToRate' => $offer->statusNumber === 3 && !$ratingExists && ($offer->buyer_id === $user->id || $offer->seller->id === $user->id),
        ]);
    }

    public function loadMessages(Offer $offer, User $buyer)
    {
        $user = Auth::user();
        $langColumn = LanguageHelper::getLangColumnForMessages();

        if (!($buyer->id === $user->id || $offer->user_id === $user->id)) {
            abort(403, 'You are not allowed to access this page.');
        }

        $messages = $offer->messages()
            ->where(function ($query) use ($user) {
                $query->where('seller_id', $user->id)
                    ->orWhere('buyer_id', $user->id);
            })
            ->where('offer_id', $offer->id)
            ->where('buyer_id', $buyer->id)
            ->get()
            ->map(function ($message) use ($langColumn) {
                $message->created_at_formatted = $message->created_at->diffForHumans();
                if (!empty($message->$langColumn)) {
                    $message->message = $message->$langColumn;
                }
                return $message;
            });

        return response()->json([
            'messages' => $messages,
        ]);

    }

    public function sendMessage(Request $request, Offer $offer, User $buyer)
    {
        $user = Auth::user();
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
            'message' => $request->validate([
                'message' => 'required|string|max:255',
            ])['message'],
        ]);

        /*$message->receiver->notify(
            new MessageSent($offer, $message)
        );*/

        broadcast(new \App\Events\MessageSent($message));

        ProcessNewMessageEmailNotification::dispatch($message, $user, $offer, $buyer);
    }

    public function markAsRead(Offer $offer, User $buyer)
    {
        $user = Auth::user();

        if (!($buyer->id === $user->id || $offer->user_id === $user->id)) {
            abort(403, 'You are not allowed to access this page.');
        }

        Message::where('offer_id', $offer->id)
            ->where('buyer_id', $buyer->id)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function unreadChatsCount()
    {
        $user = Auth::user();

        $unreadChatsCount = Message::where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->whereHas('offer', function ($query) {
                $query->whereIn('status', [1, 2, 3]);
            })
            ->selectRaw('offer_id, buyer_id')
            ->groupBy('offer_id', 'buyer_id')
            ->get()
            ->count();

        return response()->json([
            'unreadChatsCount' => $unreadChatsCount,
        ]);
    }
}
