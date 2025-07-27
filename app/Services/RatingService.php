<?php

namespace App\Services;

use App\Models\Offer;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Enums\StatusEnum;
use App\Enums\MessageType;
use Illuminate\Http\Request;
use App\Services\MessageService;

class RatingService
{
    public function __construct(protected MessageService $messageService)
    {
    }
    public function createRating(Offer $offer, Request $request)
    {
        $user = Auth::user();

        // TODO translations
        // TODO policy
        if ($offer->status !== StatusEnum::Received->value) {
            return response()->json(['error' => 'You can rate only received offers.'], 403);
        }

        if (!($user->id == $offer->user_id || $user->id == $offer->buyer_id)) {
            return response()->json(['error' => 'You can rate only if you are the buyer or the seller.'], 403);
        }

        if ($this->ratingExists($offer, $user)) {
            return response()->json(['error' => 'You have already rated this offer.'], 403);
        }

        //TODO validation class
        $request->validate([
            'offer_id' => 'required|exists:offers,id',
            'stars' => 'required|integer|min:1|max:5',
            'comment' => 'string|nullable',
        ]);

        if ($offer->buyer_id != $user->id) {
            $ratedUser = User::find($offer->buyer_id);
        } else {
            $ratedUser = User::find($offer->user_id);
        }

        $request->merge([
            'user_id' => $user->id,
            'rated_user_id' => $ratedUser->id,
        ]);

        $rating = Rating::create($request->all());

        if (!$rating) {
            return response()->json(['error' => 'Failed to create rating.'], 500);
        }

        $this->messageService->sendActionMessage(
            $offer,
            MessageType::Rating,
            $offer->buyer_id,
            $ratedUser->id,
            $request['stars']
        );

        return response()->json($rating, 201);
    }

    public function ratingExists(Offer $offer, User $user): bool
    {
        return Rating::where('offer_id', $offer->id)
            ->where('user_id', $user->id)
            ->exists();
    }

    public function getAverageRating(User $user): float
    {
        $ratings = Rating::where('rated_user_id', $user->id)->get();

        if ($ratings->isEmpty()) {
            return 0.0;
        }

        $totalRating = $ratings->sum('stars');
        return $totalRating / $ratings->count();
    }

    public function getReceivedRatingsByUser(User $user): array
    {
        return $user->receivedRatings()
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($rating) {
                $rating->created_at_formatted = $rating->created_at->diffForHumans();
                return $rating;
            })
            ->toArray();
    }
}
