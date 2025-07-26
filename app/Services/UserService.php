<?php

namespace App\Services;

use App\Models\User;
use App\Models\Offer;

class UserService
{
    /**
     * Get paginated active offers for a user.
     * @param User $user
     * @return array
     */
    public function getActiveOffers(User $user): array
    {
        return $user->offers()
            ->with('brand')
            ->active()
            ->orderBy('created_at', 'desc')
            ->withQueryString()
            ->through(fn($offer) => $this->transformOffer($offer, $user))
            ->items();
    }

    public function getSoldOffers(User $user): array
    {
        return Offer::with('brand')
            ->sold()
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('buyer_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString()
            ->through(fn($offer) => $this->transformOffer($offer, $user))
            ->items();
    }

    public function getSoldAndBoughtOffersCount(User $user): int
    {
        return Offer::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere('buyer_id', $user->id);
        })->sold()->count();
    }

    public function transformOffer(Offer $offer, ?User $user): array
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
