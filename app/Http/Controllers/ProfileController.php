<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show(Request $request): Response
    {
        $user = Auth::user();

        $activeOffers = $user->offers()
            ->with('brand')
            ->active()
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString()
            ->through(function ($offer) use ($user) {
                return [
                    ...$offer->toArray(),
                    'thumbnail_url' => $offer->getFirstMediaUrl('images', 'thumb'),
                    'favorites_count' => $offer->favorites()->count(),
                    'favorited_by_user' => $user ? $offer->favorites()->where('user_id', $user->id)->exists() : false,
                    'condition' => $offer->getConditionEnum()?->label(),
                    'conditionNumber' => $offer->condition,
                    'status' => $offer->getStatusEnum()?->label(),
                    'statusNumber' => $offer->status,
                ];
            })
            ->items();

        $soldOffers = $user->offers()
            ->with('brand')
            ->sold()
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString()
            ->through(function ($offer) use ($user) {
                return [
                    ...$offer->toArray(),
                    'thumbnail_url' => $offer->getFirstMediaUrl('images', 'thumb'),
                    'favorites_count' => $offer->favorites()->count(),
                    'favorited_by_user' => $user ? $offer->favorites()->where('user_id', $user->id)->exists() : false,
                    'condition' => $offer->getConditionEnum()?->label(),
                    'conditionNumber' => $offer->condition,
                    'status' => $offer->getStatusEnum()?->label(),
                    'statusNumber' => $offer->status,
                ];
            })
            ->items();

        $soldOffersCount = $user->offers()->sold()->count();

        $receivedRatings = $user->receivedRatings()
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($rating) {
                $rating->created_at_formatted = $rating->created_at->diffForHumans();
                return $rating;
            })
            ->toArray();

        return inertia('Profile/Show', [
            'user' => $user,
            'activeOffers' => $activeOffers,
            'soldOffers' => $soldOffers,
            'soldOffersCount' => $soldOffersCount,
            'rating' => $user->getRating(),
            'receivedRatings' => $receivedRatings,
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $validatedData = $request->validate([
            'lang' => ['required', 'string', 'in:en,cs'],
        ]);

        $user->update($validatedData);

        return redirect()->route('profile.show')
            ->with('success', 'Profile was updated.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
