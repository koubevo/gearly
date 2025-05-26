<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Favorite;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $newArrivals = Offer::with('brand')
            ->active()
            ->latest()
            ->limit(4)
            ->get()
            ->map(fn($offer) => $offer->transform($user));

        $mostActiveBrandId = Offer::select('brand_id')
            ->active()
            ->where('brand_id', '!=', 61)
            ->groupBy('brand_id')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(1)
            ->pluck('brand_id')
            ->first();

        $brandWithMostActiveOffers = Offer::where('brand_id', $mostActiveBrandId)
            ->with('brand')
            ->active()
            ->latest()
            ->limit(4)
            ->get()
            ->map(fn($offer) => $offer->transform($user));

        $baseballBats = Offer::with('brand')
            ->active()
            ->where('category_id', 1)
            ->baseball()
            ->latest()
            ->limit(4)
            ->get()
            ->map(fn($offer) => $offer->transform($user));

        $softballBats = Offer::with('brand')
            ->active()
            ->where('category_id', 1)
            ->softball()
            ->latest()
            ->limit(4)
            ->get()
            ->map(fn($offer) => $offer->transform($user));

        $baseballGear = Offer::with('brand')
            ->active()
            ->baseball()
            ->latest()
            ->limit(4)
            ->get()
            ->map(fn($offer) => $offer->transform($user));

        $softballGear = Offer::with('brand')
            ->active()
            ->softball()
            ->latest()
            ->limit(4)
            ->get()
            ->map(fn($offer) => $offer->transform($user));

        if ($user) {
            $favorites = Offer::whereHas('favorites', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
                ->with('brand')
                ->orderBy(Favorite::select('created_at')
                    ->whereColumn('favorites.offer_id', 'offers.id')
                    ->latest()
                    ->take(1), 'desc')
                ->limit(4)
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
        } else {
            $favorites = [];
        }

        $topBrands = Offer::select('brand_id', 'brands.name', \DB::raw('COUNT(*) as offer_count'))
            ->join('brands', 'offers.brand_id', '=', 'brands.id')
            ->active()
            ->where('brand_id', '!=', 61)
            ->groupBy('brand_id', 'brands.name')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(4)
            ->get()
            ->map(function ($offer) {
                return [
                    'brand_id' => $offer->brand_id,
                    'brand_name' => $offer->name,
                    'offer_count' => $offer->offer_count,
                    'logo' => Brand::find($offer->brand_id)->logo,
                ];
            });

        return inertia('LandingPage', [
            'newArrivals' => $newArrivals,
            'brandWithMostActiveOffers' => $brandWithMostActiveOffers,
            'baseballBats' => $baseballBats,
            'softballBats' => $softballBats,
            'baseballGear' => $baseballGear,
            'softballGear' => $softballGear,
            'favorites' => $favorites,
            'topBrands' => $topBrands,
        ]);
    }
}
