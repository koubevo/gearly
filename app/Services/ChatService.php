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
    /****
     * Initializes a new instance of the ChatService class.
     */
    public function __construct()
    {
        //
    }

    /**
     * Retrieves a collection of chat summaries for the authenticated user.
     *
     * Each chat summary includes offer details, buyer and seller information, the latest message content and time, and the count of unread messages for the user. Only chats involving the user as buyer or seller and linked to offers with specific statuses are included.
     *
     * @return \Illuminate\Support\Collection A collection of chat summaries grouped by offer and buyer.
     */
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
                'buyer' => [
                    'name' => $message->buyer->name,
                    'id' => $message->buyer->id,
                ],
                'seller' => [
                    'name' => $message->offer->seller->name,
                    'id' => $message->offer->seller->id,
                ],
                'last_message' => $message->message,
                'last_message_time' => $message->created_at->diffForHumans(),
                'unread_count' => $unreadCount,
            ];
        });
    }

    /**
     * Returns the total number of messages exchanged between the offer owner and the specified buyer for a given offer.
     *
     * @param Offer $offer The offer associated with the chat.
     * @param User $buyer The buyer involved in the chat.
     * @return int The count of messages for the offer and buyer.
     */
    public function getMessagesCount(Offer $offer, User $buyer): int
    {
        return $offer->messages()
            ->where('seller_id', $offer->user_id)
            ->where('buyer_id', $buyer->id)
            ->where('offer_id', $offer->id)
            ->count();
    }

    /**
     * Returns the rating of the other participant in a chat for a given offer.
     *
     * If the provided user is the offer owner (seller), returns the buyer's rating; otherwise, returns the seller's rating.
     *
     * @param Offer $offer The offer associated with the chat.
     * @param User $user The user whose counterpart's rating is requested.
     * @param User $buyer The buyer involved in the chat.
     * @return mixed The rating of the other participant.
     */
    public function getAverageRatingOfSecondUser(Offer $offer, User $user, User $buyer)
    {
        return $user->id == $offer->user_id ? $buyer->getRating() : $offer->seller->getRating();
    }

    /**
     * Retrieves all messages for a given offer and buyer, including only those where the specified user is either the seller or buyer.
     *
     * The returned collection includes each message with a human-readable creation time and, if available, the message content localized to the user's language preference.
     *
     * @param Offer $offer The offer associated with the chat.
     * @param User $user The user requesting the messages (must be either the seller or buyer).
     * @param User $buyer The buyer involved in the chat.
     * @return Collection The collection of messages with formatted timestamps and localized content.
     */
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

    /**
     * Marks all unread messages as read for the authenticated user in a specific chat between an offer and a buyer.
     *
     * Aborts with a 403 error if the authenticated user is neither the buyer nor the offer owner.
     */
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

    /**
     * Returns the number of distinct chats with unread messages for the specified user.
     *
     * Only includes chats linked to offers with statuses Active, Sold, or Received.
     *
     * @param User $user The user for whom to count unread chats.
     * @return int The count of chats with unread messages.
     */
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
