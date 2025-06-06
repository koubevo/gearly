<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Rating;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use App\Services\MessageNotificationService;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $offer = Offer::findOrFail($request->offer_id);
        $user = Auth::user();

        if ($offer->status != 3) {
            return response()->json(['error' => 'You can rate only received offers.'], 403);
        }

        if (!($user->id == $offer->user_id || $user->id == $offer->buyer_id)) {
            return response()->json(['error' => 'You can rate only if you are the buyer or the seller.'], 403);
        }

        $ratingExists = Rating::where('offer_id', $request->offer_id)
            ->where('user_id', $user->id)
            ->first();

        if ($ratingExists) {
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

        $messageContent = $user->name . ' rated ' . $ratedUser->name . ' with ' . $rating->stars . ' stars.';
        $meesageContentCs = $user->name . ' ohodnotil/a uživatele ' . $ratedUser->name . ' ' . $rating->stars . ' hvězdičkami.';

        $message = $offer->messages()->create([
            'seller_id' => $offer->user_id,
            'buyer_id' => $offer->buyer_id,
            'author_id' => $user->id,
            'receiver_id' => $request->rated_user_id,
            'offer_id' => $offer->id,
            'type_id' => 4,
            'message' => $messageContent,
            'cs' => $meesageContentCs,
            'stars' => $rating->stars,
        ]);

        MessageNotificationService::notifyChatAction(
            message: $message,
            user: $user,
            offer: $offer,
            buyer: User::findOrFail((int) $offer->buyer_id),
            actionType: 7
        );

        broadcast(new \App\Events\MessageSent($message));

        return response()->json($rating, 201);
    }
}
