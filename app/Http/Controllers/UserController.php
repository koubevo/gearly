<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use App\Services\RatingService;
use \Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(protected UserService $userService, protected RatingService $ratingService)
    {
    }

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