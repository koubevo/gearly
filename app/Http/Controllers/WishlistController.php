<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Offer;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function toggle(Request $request, Offer $offer)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $exists = Favorite::where('user_id', $user->id)
            ->where('offer_id', $offer->id)
            ->exists();

        if ($exists) {
            Favorite::where('user_id', $user->id)
                ->where('offer_id', $offer->id)
                ->delete();
            $status = 'deleted';
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'offer_id' => $offer->id,
                'created_at' => now(),
            ]);
            $status = 'added';
        }

        return response()->json([
            'message' => 'success',
            'status' => $status
        ]);
    }

    public function count(Offer $offer)
    {
        $count = Favorite::where('offer_id', $offer->id)
            ->count();

        return response()->json([
            'count' => $count
        ]);
    }

    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        $offers = Offer::whereHas('favorites', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->with('brand')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($offer) use ($user) {
                $offer->thumbnail_url = $offer->getFirstMediaUrl('images', 'thumb');
                $offer->favorites_count = $offer->favorites()->count();
                $offer->favorited_by_user = $user ? $offer->favorites()->where('user_id', $user->id)->exists() : false;
                return $offer;
            });

        return inertia('Wishlist/Index', [
            'offers' => $offers
        ]);
    }
}
