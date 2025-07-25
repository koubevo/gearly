<?php

namespace App\ViewModels;

use App\Models\Offer;
use App\Models\User;

class WishlistOfferViewModel
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * @param Offer $offer
     * @param User $user
     * @return array<string, mixed>
     */
    public static function fromOffer(Offer $offer, ?User $user = null): array
    {
        return [
            ...$offer->toArray(),
            'thumbnail_url' => $offer->getFirstMediaUrl('images', 'thumb'),
            'favorites_count' => $offer->favorites()->count(),
            'favorited_by_user' => $user ? $offer->favorites()->where('user_id', $user->id)->exists() : false,
            'conditionNumber' => $offer->condition,
            'condition' => $offer->getConditionEnum()?->label(),
            'statusNumber' => $offer->status,
            'status' => $offer->getStatusEnum()?->label(),
        ];
    }
}
