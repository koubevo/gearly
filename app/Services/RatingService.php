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
    /**
     * Initializes the RatingService with a MessageService dependency.
     *
     * @param MessageService $messageService The service used for sending messages related to ratings.
     */
    public function __construct(protected MessageService $messageService)
    {
        //
    }

    /**
     * Creates a new rating for a given offer by the authenticated user.
     *
     * Validates that the offer is in the correct status, the user is authorized, and no duplicate rating exists. On success, creates the rating, sends a notification message, and returns the created rating with a 201 status. Returns a JSON error response with appropriate status code if validation fails or creation is unsuccessful.
     */
    public function createRating(Offer $offer, Request $request)
    {
        $user = Auth::user();

        // TODO translations
        // TODO policy
        if ($offer->status != StatusEnum::Received->value) {
            return response()->json(['error' => 'You can rate only received offers.'], 403);
        }

        if (!($user->id == $offer->user_id || $user->id == $offer->buyer_id)) {
            return response()->json(['error' => 'You can rate only if you are the buyer or the seller.'], 403);
        }

        if ($this->ratingExists($offer, $user)) {
            return response()->json(['error' => 'You have already rated this offer.'], 403);
        }

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

    /**
     * Determines whether the specified user has already submitted a rating for the given offer.
     *
     * @param Offer $offer The offer to check for an existing rating.
     * @param User $user The user whose rating existence is being verified.
     * @return bool True if a rating by the user for the offer exists; otherwise, false.
     */
    public function ratingExists(Offer $offer, User $user): bool
    {
        return Rating::where('offer_id', $offer->id)
            ->where('user_id', $user->id)
            ->exists();
    }

    /**
     * Calculates the average rating received by a user.
     *
     * @param User $user The user whose average rating is to be calculated.
     * @return float The average rating value, or 0.0 if the user has no ratings.
     */
    public function getAverageRating(User $user): float
    {
        $ratings = Rating::where('user_id', $user->id)->get();

        if ($ratings->isEmpty()) {
            return 0.0;
        }

        $totalRating = $ratings->sum('rating');
        return $totalRating / $ratings->count();
    }

    /**
     * Retrieves all ratings received by the specified user, ordered by most recent.
     *
     * Each rating includes a human-readable formatted creation date in the `created_at_formatted` field.
     *
     * @param User $user The user whose received ratings are to be fetched.
     * @return array An array of ratings with formatted creation dates.
     */
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
