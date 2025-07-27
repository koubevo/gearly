<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use App\Services\RatingService;
use Illuminate\Http\JsonResponse;

class RatingController extends Controller
{
    public function __construct(
        protected RatingService $ratingService
    ) {

    }
    public function store(Request $request): JsonResponse
    {
        $this->ratingService->createRating(Offer::findOrFail($request->offer_id), $request);

        return response()->json(['message' => 'Rating created successfully'], 201);
    }
}
