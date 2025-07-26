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

    /**
     * Initializes a new instance of the WishlistService class.
     */
    public function __construct()
    {

    }

    /**
     * Toggles the favorite status of an offer for a user.
     *
     * If the offer is already favorited by the user, it removes the favorite and returns 'deleted'.
     * If not, it adds the offer to the user's favorites and returns 'added'.
     *
     * @param Offer $offer The offer to be toggled in the user's favorites.
     * @param User $user The user whose favorites are being modified.
     * @return string The resulting status: 'added' or 'deleted'.
     */
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

    /**
     * Returns the number of times the specified offer has been added to user favorites.
     *
     * @param Offer $offer The offer for which to count favorites.
     * @return int The total count of favorites for the offer.
     */
    public function getFavoritesCount(Offer $offer): int
    {
        return Favorite::where('offer_id', $offer->id)->count();
    }

    /**
     * Retrieves a collection of offers favorited by the specified user, ordered by the most recent favorite date.
     *
     * Each offer is mapped to a WishlistOfferViewModel instance for presentation.
     *
     * @param User $user The user whose favorite offers are to be retrieved.
     * @return Collection A collection of WishlistOfferViewModel instances representing the user's favorite offers.
     */
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
