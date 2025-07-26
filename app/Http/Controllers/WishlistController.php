<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Support\Facades\Auth;
use App\Services\WishlistService;

class WishlistController extends Controller
{
    /**
     * Initializes the controller with the provided WishlistService instance.
     *
     * @param WishlistService $wishlistService The service handling wishlist operations.
     */
    public function __construct(
        protected WishlistService $wishlistService
    ) {
        // Constructor logic if needed
    }

    /**
     * Toggles the favorite status of the specified offer for the authenticated user.
     *
     * Returns a JSON response with a success message and the updated favorite status.
     *
     * @param Offer $offer The offer to toggle in the user's wishlist.
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggle(Offer $offer)
    {
        return response()->json([
            'message' => 'success',
            'status' => $this->wishlistService->toggleFavorite($offer, Auth::user())
        ]);
    }

    /**
     * Returns the number of users who have favorited the specified offer.
     *
     * @param Offer $offer The offer to count favorites for.
     * @return \Illuminate\Http\JsonResponse JSON response containing the favorites count.
     */
    public function count(Offer $offer)
    {
        return response()->json([
            'count' => $this->wishlistService->getFavoritesCount($offer)
        ]);
    }

    /**
     * Displays the list of offers favorited by the authenticated user.
     *
     * @return \Inertia\Response The Inertia response rendering the wishlist index view with the user's favorite offers.
     */
    public function index()
    {
        $offers = $this->wishlistService->getUserFavorites(Auth::user());

        return inertia('Wishlist/Index', [
            'offers' => $offers
        ]);
    }
}
