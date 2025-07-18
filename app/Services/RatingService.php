<?php

namespace App\Services;

use App\Models\Offer;
use App\Models\Rating;
use App\Models\User;

class RatingService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function ratingExists(Offer $offer, User $user): bool
    {
        return Rating::where('offer_id', $offer->id)
            ->where('user_id', $user->id)
            ->exists();
    }

    public function getAverageRating(User $user): float
    {
        $ratings = Rating::where('user_id', $user->id)->get();

        if ($ratings->isEmpty()) {
            return 0.0;
        }

        $totalRating = $ratings->sum('rating');
        return $totalRating / $ratings->count();
    }
}
