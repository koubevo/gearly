<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Support\Facades\Auth;
use App\Services\WishlistService;

class WishlistController extends Controller
{
    public function __construct(
        protected WishlistService $wishlistService
    ) {
        // Constructor logic if needed
    }

    public function toggle(Offer $offer)
    {
        return response()->json([
            'message' => 'success',
            'status' => $this->wishlistService->toggleFavorite($offer, Auth::user())
        ]);
    }

    public function count(Offer $offer)
    {
        return response()->json([
            'count' => $this->wishlistService->getFavoritesCount($offer)
        ]);
    }

    public function index()
    {
        $offers = $this->wishlistService->getUserFavorites(Auth::user());

        return inertia('Wishlist/Index', [
            'offers' => $offers
        ]);
    }
}
