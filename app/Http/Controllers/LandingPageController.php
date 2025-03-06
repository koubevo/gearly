<?php

namespace App\Http\Controllers;

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
