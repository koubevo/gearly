<?php

namespace App\ViewModels;
use App\Models\Offer;
use App\Models\User;

class LandingPageOfferModel
{
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
