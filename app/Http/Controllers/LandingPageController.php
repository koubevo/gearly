<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        $newArrivals = Offer::with('brand')
            ->active()
            ->latest()
            ->limit(4)
            ->get()
            ->map(function ($offer) {
                $offer->thumbnail_url = $offer->getFirstMediaUrl('images', 'thumb');
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
            ->map(function ($offer) {
                $offer->thumbnail_url = $offer->getFirstMediaUrl('images', 'thumb');
                return $offer;
            });

        $baseballBats = Offer::with('brand')
            ->active()
            ->where('category_id', 1)
            ->where('sport_id', 2)
            ->latest()
            ->limit(4)
            ->get()
            ->map(function ($offer) {
                $offer->thumbnail_url = $offer->getFirstMediaUrl('images', 'thumb');
                return $offer;
            });

        $softballBats = Offer::with('brand')
            ->active()
            ->where('category_id', 1)
            ->where('sport_id', 3)
            ->latest()
            ->limit(4)
            ->get()
            ->map(function ($offer) {
                $offer->thumbnail_url = $offer->getFirstMediaUrl('images', 'thumb');
                return $offer;
            });


        return inertia('LandingPage', [
            'newArrivals' => $newArrivals,
            'brandWithMostActiveOffers' => $brandWithMostActiveOffers,
            'baseballBats' => $baseballBats,
            'softballBats' => $softballBats,
        ]);
    }
}
