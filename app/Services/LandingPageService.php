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
    private User|null $user;
    public const OFFERS_LIMIT = 4;
    public const OTHERS_BRAND_ID = 61;
    public const BATS_CATEGORY_ID = 1;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->user = Auth::user() ?? null;
    }

    private function baseOffersQuery(): Builder
    {
        return Offer::with('brand')
            ->active()
            ->latest()
            ->limit(self::OFFERS_LIMIT);
    }

    public function getNewArrivals(): Collection
    {
        return $this->baseOffersQuery()
            ->get()
            ->map(fn($offer) => LandingPageOfferModel::fromModel($offer, $this->user));
    }

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

    public function getBats(SportEnum $sportEnum): Collection
    {
        $query = $this->baseOffersQuery()
            ->where('category_id', self::BATS_CATEGORY_ID);

        return $this->getOffersBySport($sportEnum, $query);
    }

    public function getGear(SportEnum $sportEnum): Collection
    {
        $query = $this->baseOffersQuery();

        return $this->getOffersBySport($sportEnum, $query);
    }

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

    public function getTopBrands(): Collection
    {
        return Offer::select('brand_id', 'brands.name', 'brands.logo', DB::raw('COUNT(*) as offer_count'))
            ->join('brands', 'offers.brand_id', '=', 'brands.id')
            ->active()
            ->where('brand_id', '!=', self::OTHERS_BRAND_ID)
            ->groupBy('brand_id', 'brands.name', 'brands.logo')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(self::OFFERS_LIMIT)
            ->get()
            ->map(function ($offer) {
                return [
                    'brand_id' => $offer->brand_id,
                    'brand_name' => $offer->name,
                    'offer_count' => $offer->offer_count,
                    'logo' => $offer->logo,
                ];
            });
    }
}
