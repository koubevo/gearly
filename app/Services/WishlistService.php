<?php

namespace App\Services;

use App\Models\Offer;
use App\Models\User;
use App\Models\Favorite;
use Illuminate\Database\Eloquent\Collection;

class WishlistService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public function toggleFavorite(Offer $offer, User $user): string
    {
        $exists = Favorite::where('user_id', $user->id)
            ->where('offer_id', $offer->id)
            ->exists();

        if ($exists) {
            Favorite::where('user_id', $user->id)
                ->where('offer_id', $offer->id)
                ->delete();
            return 'deleted';
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'offer_id' => $offer->id,
                'created_at' => now(),
            ]);
            return 'added';
        }
    }

    public function getFavoritesCount(Offer $offer): int
    {
        return Favorite::where('offer_id', $offer->id)->count();
    }

    public function getUserFavorites(User $user): Collection
    {
        return Offer::whereHas('favorites', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->with('brand')
            ->orderBy(Favorite::select('created_at')
                ->whereColumn('favorites.offer_id', 'offers.id')
                ->latest()
                ->take(1), 'desc')
            ->get()
            ->map(function ($offer) use ($user) {
                $offer->thumbnail_url = $offer->getFirstMediaUrl('images', 'thumb');
                $offer->favorites_count = $offer->favorites()->count();
                $offer->favorited_by_user = $user ? $offer->favorites()->where('user_id', $user->id)->exists() : false;
                $offer->conditionNumber = $offer->condition;
                $offer->condition = $offer->getConditionEnum()?->label();
                $offer->statusNumber = $offer->status;
                $offer->status = $offer->getStatusEnum()?->label();
                return $offer;
            });
    }
}
