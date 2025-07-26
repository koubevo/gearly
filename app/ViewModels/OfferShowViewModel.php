<?php

namespace App\ViewModels;

use App\Models\Offer;
use App\Models\User;

class OfferShowViewModel
{
    /****
     * Initializes a new instance of the OfferShowViewModel class.
     */
    public function __construct()
    {
        //
    }

    /**
     * Compiles and returns a detailed array of information about a given offer and user.
     *
     * The returned array includes the offer's attributes with computed labels for sport, condition, and status, counts of favorites, whether the user has favorited the offer, and a human-readable update time. It also provides the seller's data with last login time, the count of sold offers, the seller's rating, related category, brand, delivery option, mapped image URLs, and associated filters with their categories and names.
     *
     * @param Offer $offer The offer to display.
     * @param User $user The user viewing the offer.
     * @return array An associative array containing offer details, seller information, related entities, images, and filters.
     */
    public static function data(Offer $offer, User $user): array
    {
        return [
            'offer' => [
                ...$offer->toArray(),
                'sport' => $offer->getSportEnum()?->label(),
                'condition' => $offer->getConditionEnum()?->label(),
                'conditionNumber' => $offer->condition,
                'status' => $offer->getStatusEnum()?->label(),
                'statusNumber' => $offer->status,
                'favorites_count' => $offer->favorites()->count(),
                'favorited_by_user' => $user ? $offer->favorites()->where('user_id', $user->id)->exists() : false,
                'updated_at' => $offer->updated_at?->diffForHumans(),
            ],
            'soldOffersCount' => $offer->seller->offers()->sold()->count(),
            'seller' => [
                ...$offer->seller->toArray(),
                'last_login_at' => $offer->seller->last_login_at?->diffForHumans(),
            ],
            'category' => $offer->category,
            'brand' => $offer->brand,
            'deliveryOption' => $offer->deliveryOption,
            'rating' => $offer->seller->getRating(),
            'images' => $offer->getMedia('images')->map(fn($image) => [
                'medium' => $image->getUrl('medium'),
                'thumb' => $image->getUrl('thumb'),
            ]),
            'filters' => $offer->offerFilters->map(fn($filter) => [
                'id' => $filter->id,
                'offer_id' => $filter->offer_id,
                'filter_id' => $filter->filter_id,
                'filter_category_id' => $filter->filter_category_id,
                'filter_category_name' => $filter->filterCategory?->name,
                'filter_name' => $filter->filter?->name,
            ]),
        ];
    }
}
