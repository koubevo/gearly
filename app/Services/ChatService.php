<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Helpers\LanguageHelper;
use App\Models\Message;
use App\Models\Offer;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ChatService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getChats(): Collection
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

        return $latestMessages->map(function ($message) use ($user) {
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
                'buyer_name' => $message->buyer->name,
                'buyer_id' => $message->buyer->id,
                'seller_name' => $message->offer->seller->name,
                'seller_id' => $message->offer->seller->id,
                'last_message' => $message->message,
                'last_message_time' => $message->created_at->diffForHumans(),
                'unread_count' => $unreadCount,
            ];
        });
    }

    public function getMessagesCount(Offer $offer, User $buyer): int
    {
        return $offer->messages()
            ->where('seller_id', $offer->user_id)
            ->where('buyer_id', $buyer->id)
            ->where('offer_id', $offer->id)
            ->count();
    }

    public function getAverageRatingOfSecondUser(Offer $offer, User $user, User $buyer)
    {
        return $user->id == $offer->user_id ? $buyer->getRating() : $offer->seller->getRating();
    }

    public function getMessages(Offer $offer, User $user, User $buyer): Collection
    {
        $langColumn = LanguageHelper::getLangColumnForMessages();

        return $offer->messages()
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
    }

    public function markAsRead(Offer $offer, User $buyer)
    {
        $user = Auth::user();

        // TODO: policy
        if (!($buyer->id === $user->id || $offer->user_id === $user->id)) {
            abort(403, 'You are not allowed to access this page.');
        }

        Message::where('offer_id', $offer->id)
            ->where('buyer_id', $buyer->id)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function getUnreadChatsCount(User $user): int
    {
        return Message::where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->whereHas('offer', function ($query) {
                $query->whereIn('status', [StatusEnum::Active->value, StatusEnum::Sold->value, StatusEnum::Received->value]);
            })
            ->selectRaw('offer_id, buyer_id')
            ->groupBy('offer_id', 'buyer_id')
            ->get()
            ->count();
    }
}
