<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;
use App\Services\UserService;
use App\Services\RatingService;

class ProfileController extends Controller
{
    public function __construct(protected UserService $userService, protected RatingService $ratingService)
    {
    }
    /**
     * Display the user's profile form.
     */
    public function show(Request $request): Response
    {
        $user = Auth::user();

        return inertia('Profile/Show', [
            'user' => [
                ...$user->attributesToArray(),
                'last_login_at' => $user->last_login_at?->diffForHumans(),
                'notifications_inactive' => $user->notifications_inactive,
                'notifications_new_messages' => $user->notifications_new_messages,
                'notifications_new_message' => $user->notifications_new_message,
                'notifications_closure_reminder' => $user->notifications_closure_reminder,
            ],
            'activeOffers' => $this->userService->getActiveOffers($user),
            'soldOffers' => $this->userService->getSoldReceivedOffers($user),
            'soldOffersCount' => $this->userService->getSoldAndBoughtOffersCount($user),
            'rating' => $user->getRating(),
            'receivedRatings' => $this->ratingService->getReceivedRatingsByUser($user),
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
            ->with('success', __('messages.profile_updated'))
            ->with('forceRefresh', true);
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

        return Redirect::to('/')->with('success', __('messages.profile_deleted'));
    }

    public function updateNofitications(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $validatedData = $request->validate([
            'notifications_inactive' => ['boolean'],
            'notifications_new_messages' => ['boolean'],
            'notifications_new_message' => ['boolean'],
            'notifications_closure_reminder' => ['boolean'],
        ]);

        $user->update($validatedData);

        return redirect()->route('profile.show')
            ->with('success', __('messages.notifications_updated'))
            ->with('forceRefresh', true);
    }
}
