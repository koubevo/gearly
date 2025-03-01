<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        $activeUser = \Illuminate\Support\Facades\Auth::user() ?? null;

        if ($user->id === $activeUser->id) {
            return redirect()->route('profile.edit');
        }

        $activeOffers = $user->offers()
            ->with('brand')
            ->active()
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString()
            ->through(function ($offer) use ($activeUser) {
                $offer->thumbnail_url = $offer->getFirstMediaUrl('images', 'thumb');
                $offer->favorites_count = $offer->favorites()->count();
                $offer->favorited_by_user = $activeUser ? $offer->favorites()->where('user_id', $activeUser->id)->exists() : false;
                return $offer;
            })
            ->items();

        $soldOffers = $user->offers()
            ->with('brand')
            ->sold()
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString()
            ->through(function ($offer) use ($activeUser) {
                $offer->thumbnail_url = $offer->getFirstMediaUrl('images', 'thumb');
                $offer->favorites_count = $offer->favorites()->count();
                $offer->favorited_by_user = $activeUser ? $offer->favorites()->where('user_id', $activeUser->id)->exists() : false;
                return $offer;
            })
            ->items();

        $soldOffersCount = $user->offers()->sold()->count();

        $receivedRatings = $user->receivedRatings()
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($rating) {
                $rating->created_at_formatted = $rating->created_at->diffForHumans();
                return $rating;
            })
            ->toArray();

        return inertia('User/Show', [
            'user' => $user,
            'activeOffers' => $activeOffers,
            'soldOffers' => $soldOffers,
            'soldOffersCount' => $soldOffersCount,
            'rating' => $user->getRating(),
            'receivedRatings' => $receivedRatings,
        ]);
    }
}