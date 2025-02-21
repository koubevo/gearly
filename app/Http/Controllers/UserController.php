<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        $offers = $user->offers()
            ->with('brand')
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString()
            ->through(function ($offer) {
                $offer->thumbnail_url = $offer->getFirstMediaUrl('images', 'thumb');
                return $offer;
            });
        return inertia('User/Show', [
            'user' => $user,
            'offers' => $offers
        ]);
    }
}