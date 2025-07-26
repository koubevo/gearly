<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Helpers\LanguageHelper;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Storage;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use \Illuminate\Support\Facades\Auth;
use \App\Services\OfferService;
use App\Services\OfferTransactionService;
use App\ViewModels\OfferIndexViewModel;
use App\ViewModels\OfferCreateViewModel;
use App\ViewModels\OfferShowViewModel;
use App\ViewModels\OfferEditViewModel;

class OfferController extends Controller implements HasMedia
{
    use AuthorizesRequests, InteractsWithMedia;

    protected $offerService;
    protected $offerTransactionService;
    private const PAGINATED_OFFERS_LIMIT = 12;

    /**
     * Initializes the OfferController with required service dependencies.
     *
     * @param OfferService $offerService Service for offer-related business logic.
     * @param OfferTransactionService $offerTransactionService Service for offer transaction operations.
     */
    public function __construct(OfferService $offerService, OfferTransactionService $offerTransactionService)
    {
        $this->offerService = $offerService;
        $this->offerTransactionService = $offerTransactionService;
    }

    /****
     * Retrieves a paginated list of offers with optional filtering and dynamic filters.
     *
     * Returns a JSON response if requested, otherwise renders the offers index view with relevant data.
     *
     * @param Request $request The HTTP request containing filter parameters.
     * @return \Illuminate\Http\JsonResponse|\Inertia\Response
     */

    public function index(Request $request)
    {
        $filters = $request->only(Offer::AVAILABLE_FILTERS);

        $dynamicFilters = collect($request->all())
            ->filter(fn($value, $key) => str_starts_with($key, 'fc') && $value !== null);

        $offers = $this->offerService->getPaginatedOffers(self::PAGINATED_OFFERS_LIMIT, $filters, $dynamicFilters);

        if ($request->wantsJson()) {
            return response()->json($offers);
        }

        return inertia('Offer/Index', OfferIndexViewModel::data(
            $offers,
            $filters,
            $dynamicFilters,
            LanguageHelper::getLangColumn()
        ));
    }

    /**
     * Displays the form for creating a new offer.
     *
     * Returns an Inertia view with the authenticated user and language column data for offer creation.
     */
    public function create()
    {
        return inertia('Offer/Create', OfferCreateViewModel::data(
            Auth::user(),
            LanguageHelper::getLangColumn()
        ));
    }

    /**
     * Creates a new offer using validated request data and uploaded images.
     *
     * Redirects to the offer's detail page on success, or back to the offer index with an error message if creation fails.
     */
    public function store(StoreOfferRequest $request)
    {
        try {
            $offer = $this->offerService->createOffer(Auth::user(), $request->validated(), $request->file('images'));
        } catch (\Exception $e) {
            return redirect()->route('offer.index')
                ->withErrors(['error' => __('messages.offer_create_not_allowed')]);
        }

        return redirect()->route('offer.show', $offer->id)
            ->with('success', __('messages.offer_created'));
    }

    /**
     * Displays the details of a specific offer.
     *
     * Returns an Inertia view with offer information and the authenticated user context.
     *
     * @param Offer $offer The offer to display.
     * @return \Inertia\Response
     */
    public function show(Offer $offer)
    {
        return inertia('Offer/Show', OfferShowViewModel::data(
            $offer,
            Auth::user()
        ));
    }

    /**
     * Displays the edit form for a specific offer.
     *
     * Authorizes the user to update the offer before rendering the edit view.
     *
     * @param Offer $offer The offer to be edited.
     * @return \Inertia\Response
     */
    public function edit(Offer $offer)
    {
        $this->authorize('update', $offer);

        return inertia('Offer/Edit', OfferEditViewModel::data(
            $offer,
            LanguageHelper::getLangColumn()
        ));
    }

    /**
     * Updates an existing offer with validated data.
     *
     * Redirects to the offer's detail page with a success message after updating.
     *
     * @param UpdateOfferRequest $request The validated request containing updated offer data.
     * @param Offer $offer The offer instance to update.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateOfferRequest $request, Offer $offer)
    {
        $offer->update($request->validated());

        return redirect()->route('offer.show', $offer)
            ->with('success', __('messages.offer_updated'));
    }

    /**
     * Deletes the specified offer and redirects to the user's profile with a success message.
     *
     * @param Offer $offer The offer to be deleted.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Offer $offer)
    {
        $this->authorize('delete', $offer);

        $this->offerService->deleteOffer($offer);

        return redirect()->route('profile.show')
            ->with('success', __('messages.offer_deleted'));
    }

    /**
     * Handles temporary upload of an image file and returns its public URL.
     *
     * Validates the uploaded file to ensure it is an image of allowed types and size, stores it in temporary public storage, and responds with the accessible URL.
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing the public URL of the uploaded image.
     */
    public function uploadTempImages(Request $request)
    {
        $request->validate([
            'file' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $path = $request->file('file')->store('temp', 'public');

        return response()->json(['path' => Storage::url($path)]);
    }

    /**
     * Initiates the selling process for the specified offer.
     *
     * Authorizes the current user to update the offer, then delegates the selling logic to the offer transaction service.
     */
    public function sellOffer(Request $request, Offer $offer): void
    {
        $this->authorize('update', $offer);

        $this->offerTransactionService->sellOffer($request, $offer);
    }

    /**
     * Marks an offer as received by the buyer if authorized.
     *
     * Aborts with a 403 error if the authenticated user is not the buyer or if the offer is not in the "Sold" status.
     */
    public function receiveOffer(Request $request, Offer $offer): void
    {
        //TODO: policy
        $user = Auth::user();
        if ($user->id !== $offer->buyer_id || $offer->status !== StatusEnum::Sold->value) {
            abort(403, __('messages.not_allowed'));
        }

        $this->offerTransactionService->receiveOffer($offer);
    }

    /**
     * Cancels a sold offer if the authenticated user is the owner and meets eligibility criteria.
     *
     * Aborts with a 403 error if the user is not the offer owner or the offer is not sold. Non-premium users exceeding the maximum number of free active offers are redirected with an error message. Delegates the cancellation process to the offer transaction service.
     */
    public function cancelOffer(Request $request, Offer $offer)
    {
        //TODO: policy
        $user = Auth::user();
        if ($user->id !== $offer->user_id || $offer->status !== StatusEnum::Sold->value) {
            abort(403, __('messages.not_allowed'));
        }

        $activeOffersCount = $user->offers()->where('status', 1)->count();

        if (!$user->hasPremium() && $activeOffersCount >= Offer::MAX_FREE_ACTIVE_OFFERS) {
            return redirect()->route('offer.index')
                ->withErrors(['error' => __('messages.max_free_active_offers', ['limit' => Offer::MAX_FREE_ACTIVE_OFFERS])]);
        }

        $this->offerTransactionService->cancelOffer($offer);
    }
}
