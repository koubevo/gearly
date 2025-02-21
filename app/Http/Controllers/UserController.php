<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        $activeOffers = $user->offers()
            ->with('brand')
            ->active()
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString()
            ->through(function ($offer) {
                $offer->thumbnail_url = $offer->getFirstMediaUrl('images', 'thumb');
                return $offer;
            })
            ->items();

        $soldOffers = $user->offers()
            ->with('brand')
            ->sold()
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString()
            ->through(function ($offer) {
                $offer->thumbnail_url = $offer->getFirstMediaUrl('images', 'thumb');
                return $offer;
            })
            ->items();

        return inertia('User/Show', [
            'user' => $user,
            'activeOffers' => $activeOffers,
            'soldOffers' => $soldOffers
        ]);
    }
}