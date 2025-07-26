<?php

namespace App\Services;

use App\Enums\SportEnum;
use App\Models\Offer;
use App\Models\User;
use App\Models\Brand;
use App\Models\Favorite;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\ViewModels\LandingPageOfferModel;

class LandingPageService
{
    public User|null $user;
    public const OFFERS_LIMIT = 4;
    public const OTHERS_BRAND_ID = 61;
    public const BATS_CATEGORY_ID = 1;

    /****
     * Initializes the service with the currently authenticated user, or null if no user is authenticated.
     */
    public function __construct()
    {
        $this->user = Auth::user() ?? null;
    }

    /**
     * Creates a base query for retrieving the latest active offers with their associated brands, limited to a predefined number.
     *
     * @return Builder The Eloquent query builder for active offers.
     */
    private function baseOffersQuery(): Builder
    {
        return Offer::with('brand')
            ->active()
            ->latest()
            ->limit(self::OFFERS_LIMIT);
    }

    /**
     * Retrieves the latest active offers for display as new arrivals on the landing page.
     *
     * @return Collection A collection of LandingPageOfferModel instances representing the newest offers.
     */
    public function getNewArrivals(): Collection
    {
        return $this->baseOffersQuery()
            ->get()
            ->map(fn($offer) => LandingPageOfferModel::fromModel($offer, $this->user));
    }

    /**
     * Retrieves offers from the brand with the highest number of active offers, excluding a specific brand.
     *
     * Returns a collection of offers for the most active brand, each mapped to a `LandingPageOfferModel` with user context.
     *
     * @return Collection The collection of offers from the top brand by active offer count.
     */
    public function getBrandWithMostActiveOffers(): Collection
    {
        $mostActiveBrandId = Offer::select('brand_id')
            ->active()
            ->where('brand_id', '!=', self::OTHERS_BRAND_ID)
            ->groupBy('brand_id')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(1)
            ->pluck('brand_id')
            ->first();

        return $this->baseOffersQuery()
            ->where('brand_id', $mostActiveBrandId)
            ->with('brand')
            ->get()
            ->map(fn($offer) => LandingPageOfferModel::fromModel($offer, $this->user));
    }

    /**
     * Retrieves a collection of bat offers filtered by the specified sport.
     *
     * @param SportEnum $sportEnum The sport to filter bat offers by.
     * @return Collection A collection of LandingPageOfferModel instances representing bat offers for the given sport.
     */
    public function getBats(SportEnum $sportEnum): Collection
    {
        $query = $this->baseOffersQuery()
            ->where('category_id', self::BATS_CATEGORY_ID);

        return $this->getOffersBySport($sportEnum, $query);
    }

    /**
     * Retrieves a collection of active gear offers filtered by the specified sport.
     *
     * @param SportEnum $sportEnum The sport to filter gear offers by.
     * @return Collection A collection of LandingPageOfferModel instances representing the filtered gear offers.
     */
    public function getGear(SportEnum $sportEnum): Collection
    {
        $query = $this->baseOffersQuery();

        return $this->getOffersBySport($sportEnum, $query);
    }

    /**
     * Retrieves offers filtered by the specified sport and maps them to landing page offer models.
     *
     * @param SportEnum $sportEnum The sport to filter offers by.
     * @param Builder $query The base query builder for offers.
     * @return Collection A collection of LandingPageOfferModel instances for the given sport.
     */
    private function getOffersBySport(SportEnum $sportEnum, Builder $query): Collection
    {
        if ($sportEnum === SportEnum::Baseball) {
            $query->baseball();
        } else {
            $query->softball();
        }

        return $query->get()
            ->map(fn($offer) => LandingPageOfferModel::fromModel($offer, $this->user));
    }

    /**
     * Retrieves the current user's most recently favorited offers for the landing page.
     *
     * Returns an empty collection if no user is authenticated. The results are limited to a fixed number and each offer is mapped to a landing page view model.
     *
     * @return Collection The collection of favorited offers as landing page models.
     */
    public function getFavorites(): Collection
    {
        $user = $this->user;
        if (!$user) {
            return collect();
        }

        return Offer::whereHas('favorites', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->with('brand')
            ->orderBy(
                Favorite::select('created_at')
                    ->whereColumn('favorites.offer_id', 'offers.id')
                    ->latest()
                    ->take(1),
                'desc'
            )
            ->limit(self::OFFERS_LIMIT)
            ->get()
            ->map(fn($offer) => LandingPageOfferModel::fromModel($offer, $this->user));
    }

    /**
     * Retrieves the top brands ranked by the number of active offers, excluding a specific brand.
     *
     * Returns a collection of arrays, each containing the brand ID, brand name, active offer count, and brand logo, limited to a predefined number of top brands.
     *
     * @return Collection List of top brands with their offer counts and logos.
     */
    public function getTopBrands(): Collection
    {
        return Offer::select('brand_id', 'brands.name', DB::raw('COUNT(*) as offer_count'))
            ->join('brands', 'offers.brand_id', '=', 'brands.id')
            ->active()
            ->where('brand_id', '!=', 61)
            ->groupBy('brand_id', 'brands.name')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(self::OFFERS_LIMIT)
            ->get()
            ->map(function ($offer) {
                return [
                    'brand_id' => $offer->brand_id,
                    'brand_name' => $offer->name,
                    'offer_count' => $offer->offer_count,
                    'logo' => Brand::find($offer->brand_id)->logo,
                ];
            });
    }
}
