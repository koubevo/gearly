<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Auth;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'rated_user_id' => 'required|exists:users,id',
            'offer_id' => 'required|exists:offers,id',
            'stars' => 'required|integer|min:1|max:5',
            'comment' => 'string',
        ]);

        $request->merge([
            'user_id' => $user->id,
        ]);

        $rating = Rating::create($request->all());

        $ratedUser = $rating->ratedUser;

        $offer = $rating->offer;

        $messageContent = $user->name . ' rated ' . $ratedUser->name . ' with ' . $rating->stars . ' stars.';

        $message = $offer->messages()->create([
            'seller_id' => $offer->user_id,
            'buyer_id' => $offer->buyer_id,
            'author_id' => $user->id,
            'receiver_id' => $request->rated_user_id,
            'offer_id' => $offer->id,
            'type_id' => 4,
            'message' => $messageContent,
            'stars' => $rating->stars,
        ]);

        broadcast(new \App\Events\MessageSent($message));

        return response()->json($rating, 201);
    }
}
