<?php

namespace App\ViewModels;

use App\Models\Offer;
use App\Models\User;
use App\Services\ChatService;
use App\Services\RatingService;

class ChatShowViewModel
{

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
    }

    /**
     * Compiles and returns chat-related data for a given offer and users.
     *
     * The returned array includes the seller, buyer, offer, offer thumbnail URL, the average rating of the second user in the chat, and a boolean indicating if the current user is able to rate the offer.
     *
     * @param Offer $offer The offer being discussed in the chat.
     * @param User $buyer The user who is the buyer in the transaction.
     * @param User $user The current user viewing the chat.
     * @return array Associative array with chat display data and rating eligibility.
     */
    public static function data(Offer $offer, User $buyer, User $user, ChatService $chatService, RatingService $ratingService): array
    {
        $ratingExists = $ratingService->ratingExists($offer, $user);
        $averageRating = $chatService->getAverageRatingOfSecondUser($offer, $user, $buyer);

        return [
            'seller' => $offer->seller,
            'buyer' => $buyer,
            'offer' => $offer,
            'thumbnail_url' => $offer->thumbnail_url,
            'rating' => $averageRating,
            'ableToRate' => $offer->statusNumber === 3 && !$ratingExists && ($offer->buyer_id === $user->id || $offer->seller->id === $user->id),
        ];
    }
}
