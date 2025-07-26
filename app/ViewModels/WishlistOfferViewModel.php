<?php

namespace App\ViewModels;

use App\Models\Offer;
use App\Models\User;

class WishlistOfferViewModel
{
    /**
     * Initializes a new instance of the WishlistOfferViewModel class.
     */
    public function __construct()
    {
        //
    }

    /**
     * Transforms an Offer instance into an associative array with wishlist-specific metadata.
     *
     * The returned array includes the offer's attributes along with its thumbnail URL, favorite count, whether the specified user has favorited it, and both numeric and label representations of its condition and status.
     *
     * @param Offer $offer The offer to transform.
     * @param User|null $user The user for whom to check favorite status, or null.
     * @return array<string, mixed> Associative array representing the offer with additional wishlist metadata.
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
