<?php

namespace App\ViewModels;
use App\Models\Offer;
use App\Models\User;

class LandingPageOfferModel
{
    /**
     * Initializes a new instance of the LandingPageOfferModel class.
     */
    public function __construct()
    {
        //
    }

    /**
     * Transforms an Offer model into an array with additional landing page fields.
     *
     * Combines the Offer's attributes with computed properties such as thumbnail URL, favorites count, user-specific favorite status, and both label and numeric representations of condition and status.
     *
     * @param Offer $offer The offer model to transform.
     * @param User|null $user The user to check for favorite status, or null.
     * @return array The offer data formatted for landing page display.
     */
    public static function fromModel(Offer $offer, ?User $user = null): array
    {
        return [
            ...$offer->toArray(),
            'thumbnail_url' => $offer->getFirstMediaUrl('images', 'thumb'),
            'favorites_count' => $offer->favorites()->count(),
            'favorited_by_user' => $user ? $offer->favorites()->where('user_id', $user->id)->exists() : false,
            'condition' => $offer->getConditionEnum()?->label(),
            'conditionNumber' => $offer->condition,
            'status' => $offer->getStatusEnum()?->label(),
            'statusNumber' => $offer->status,
        ];
    }
}
