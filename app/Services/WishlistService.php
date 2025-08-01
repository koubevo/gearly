<?php

namespace App\Services;

use App\Models\Offer;
use App\Models\User;
use App\Models\Favorite;
use Illuminate\Support\Collection;
use App\ViewModels\WishlistOfferViewModel;

class WishlistService
{
    public const STATUS_ADDED = 'added';
    public const STATUS_DELETED = 'deleted';

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
        return Offer::query()
            ->join('favorites', 'offers.id', '=', 'favorites.offer_id')
            ->where('favorites.user_id', $user->id)
            ->with('brand')
            ->select('offers.*')
            ->active() //TODO: in the future should be removed
            ->orderBy('favorites.created_at', 'desc')
            ->get()
            ->map(function ($offer) use ($user) {
                return WishlistOfferViewModel::fromOffer($offer, $user);
            });
    }
}
