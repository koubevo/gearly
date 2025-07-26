<?php

namespace App\Http\Controllers;

use App\Enums\NotificationType;
use App\Models\Offer;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\RatingService;

class RatingController extends Controller
{
    /**
     * Initializes the controller with a RatingService instance.
     *
     * @param RatingService $ratingService The service used for rating operations.
     */
    public function __construct(
        protected RatingService $ratingService
    ) {

    }
    /**
     * Creates a new rating for the specified offer using the provided request data.
     *
     * Retrieves the offer by its ID from the request and delegates rating creation to the RatingService.
     */
    public function store(Request $request)
    {
        $this->ratingService->createRating(Offer::findOrFail($request->offer_id), $request);
    }
}
