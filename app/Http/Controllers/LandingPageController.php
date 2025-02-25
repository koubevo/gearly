<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user() ?? null;

        $newArrivals = Offer::with('brand')
            ->active()
            ->latest()
            ->limit(4)
            ->get()
            ->map(function ($offer) use ($user) {
                $offer->thumbnail_url = $offer->getFirstMediaUrl('images', 'thumb');
                $offer->favorites_count = $offer->favorites()->count();
                $offer->favorited_by_user = $user ? $offer->favorites()->where('user_id', $user->id)->exists() : false;
                return $offer;
            });

        $mostActiveBrandId = Offer::select('brand_id')
            ->active()
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
            ->map(function ($offer) use ($user) {
                $offer->thumbnail_url = $offer->getFirstMediaUrl('images', 'thumb');
                $offer->favorites_count = $offer->favorites()->count();
                $offer->favorited_by_user = $user ? $offer->favorites()->where('user_id', $user->id)->exists() : false;
                return $offer;
            });

        $baseballBats = Offer::with('brand')
            ->active()
            ->where('category_id', 1)
            ->baseball()
            ->latest()
            ->limit(4)
            ->get()
            ->map(function ($offer) use ($user) {
                $offer->thumbnail_url = $offer->getFirstMediaUrl('images', 'thumb');
                $offer->favorites_count = $offer->favorites()->count();
                $offer->favorited_by_user = $user ? $offer->favorites()->where('user_id', $user->id)->exists() : false;
                return $offer;
            });

        $softballBats = Offer::with('brand')
            ->active()
            ->where('category_id', 1)
            ->softball()
            ->latest()
            ->limit(4)
            ->get()
            ->map(function ($offer) use ($user) {
                $offer->thumbnail_url = $offer->getFirstMediaUrl('images', 'thumb');
                $offer->favorites_count = $offer->favorites()->count();
                $offer->favorited_by_user = $user ? $offer->favorites()->where('user_id', $user->id)->exists() : false;
                return $offer;
            });

        $baseballGear = Offer::with('brand')
            ->active()
            ->baseball()
            ->latest()
            ->limit(4)
            ->get()
            ->map(function ($offer) use ($user) {
                $offer->thumbnail_url = $offer->getFirstMediaUrl('images', 'thumb');
                $offer->favorites_count = $offer->favorites()->count();
                $offer->favorited_by_user = $user ? $offer->favorites()->where('user_id', $user->id)->exists() : false;
                return $offer;
            });

        $softballGear = Offer::with('brand')
            ->active()
            ->softball()
            ->latest()
            ->limit(4)
            ->get()
            ->map(function ($offer) use ($user) {
                $offer->thumbnail_url = $offer->getFirstMediaUrl('images', 'thumb');
                $offer->favorites_count = $offer->favorites()->count();
                $offer->favorited_by_user = $user ? $offer->favorites()->where('user_id', $user->id)->exists() : false;
                return $offer;
            });

        return inertia('LandingPage', [
            'newArrivals' => $newArrivals,
            'brandWithMostActiveOffers' => $brandWithMostActiveOffers,
            'baseballBats' => $baseballBats,
            'softballBats' => $softballBats,
            'baseballGear' => $baseballGear,
            'softballGear' => $softballGear
        ]);
    }
}
