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
