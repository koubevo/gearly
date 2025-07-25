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
    public function __construct(
        protected RatingService $ratingService
    ) {

    }
    public function store(Request $request)
    {
        $this->ratingService->createRating(Offer::findOrFail($request->offer_id), $request);
    }
}
