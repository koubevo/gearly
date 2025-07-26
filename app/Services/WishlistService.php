<?php

namespace App\Services;

use App\Models\Offer;
use App\Models\User;
use App\Models\Favorite;
use Illuminate\Support\Collection;
use App\ViewModels\WishlistOfferViewModel;

class WishlistService
{
    private const STATUS_ADDED = 'added';
    private const STATUS_DELETED = 'deleted';

    public function toggleFavorite(Offer $offer, User $user): string
    {
        $exists = Favorite::where('user_id', $user->id)
            ->where('offer_id', $offer->id)
            ->exists();

        if ($exists) {
            Favorite::where('user_id', $user->id)
                ->where('offer_id', $offer->id)
                ->delete();
            return self::STATUS_DELETED;
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'offer_id' => $offer->id,
                'created_at' => now(),
            ]);
            return self::STATUS_ADDED;
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
                return WishlistOfferViewModel::fromOffer($offer, $user);
            });
    }
}
