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


        return inertia('LandingPage', [
            'newArrivals' => $newArrivals
        ]);
    }
}
