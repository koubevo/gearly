<?php

namespace App\Services;

use App\Models\User;
use App\Models\Offer;

class UserService
{
    /**
     * Initializes a new instance of the UserService class.
     */
    public function __construct()
    {
        //
    }

    /**
     * Retrieves a paginated list of active offers associated with the given user.
     *
     * Returns an array of transformed offer data, including related brand information, for the user's active offers ordered by creation date descending. Each offer is enriched with additional metadata for frontend consumption.
     *
     * @param User $user The user whose active offers are to be retrieved.
     * @return array The paginated and transformed active offers.
     */
    public function getActiveOffers(User $user): array
    {
        return $user->offers()
            ->with('brand')
            ->active()
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString()
            ->through(fn($offer) => $this->transformOffer($offer, $user))
            ->items();
    }

    /**
     * Retrieves a paginated list of sold offers where the user is either the seller or buyer.
     *
     * The returned offers include related brand data and are ordered by creation date in descending order. Each offer is transformed to include additional metadata.
     *
     * @param User $user The user for whom to retrieve sold offers.
     * @return array The list of transformed sold offers.
     */
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

    /**
     * Returns the total number of sold offers where the user is either the seller or the buyer.
     *
     * @param User $user The user whose sold and bought offers are counted.
     * @return int The count of sold offers involving the user.
     */
    public function getSoldAndBoughtOffersCount(User $user): int
    {
        return Offer::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere('buyer_id', $user->id);
        })->sold()->count();
    }

    /**
     * Converts an offer into an array with additional metadata for the specified user.
     *
     * The returned array includes all offer attributes, a thumbnail URL, favorite count, whether the user has favorited the offer, and human-readable as well as numeric values for the offer's condition and status.
     *
     * @param Offer $offer The offer to transform.
     * @param User $user The user for whom the offer is being transformed.
     * @return array The transformed offer data with enriched fields.
     */
    public function transformOffer(Offer $offer, User $user): array
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
