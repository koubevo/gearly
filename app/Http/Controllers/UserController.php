<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use App\Services\RatingService;
use \Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Initializes the controller with user and rating service dependencies.
     */
    public function __construct(protected UserService $userService, protected RatingService $ratingService)
    {
    }

    /**
     * Displays a user's public profile page or redirects to the authenticated user's profile if applicable.
     *
     * If the requested user is the currently authenticated user, redirects to their profile page. Otherwise, renders the user's public profile with their details, active and sold offers, offer counts, rating, and received ratings.
     *
     * @param User $user The user whose profile is being viewed.
     * @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    public function show(User $user)
    {
        $activeUser = Auth::user() ?? null;

        if ($user->id === $activeUser?->id) {
            return redirect()->route('profile.show');
        }

        return inertia('User/Show', [
            'user' => [
                ...$user->toArray(),
                'last_login_at' => $user->last_login_at?->diffForHumans(),
            ],
            'activeOffers' => $this->userService->getActiveOffers($user),
            'soldOffers' => $this->userService->getSoldOffers($user),
            'soldOffersCount' => $this->userService->getSoldAndBoughtOffersCount($user),
            'rating' => $user->getRating(),
            'receivedRatings' => $this->ratingService->getReceivedRatingsByUser($user),
        ]);
    }
}