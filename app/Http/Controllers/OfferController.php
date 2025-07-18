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

    public function __construct(OfferService $offerService, OfferTransactionService $offerTransactionService)
    {
        $this->offerService = $offerService;
        $this->offerTransactionService = $offerTransactionService;
    }

    /**
     * Display a listing of the resource.
     * Order by newest by default. 0 price asc, 1 price desc.
     * 
     * @param Request $request
     */

    public function index(Request $request)
    {
        $filters = $request->only(Offer::AVAILABLE_FILTERS);

        $dynamicFilters = collect($request->all())
            ->filter(fn($value, $key) => str_starts_with($key, 'fc') && $value !== null);

        $offers = $this->offerService->getPaginatedOffers(12, $filters, $dynamicFilters, Auth::user() ?? null);

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Offer/Create', OfferCreateViewModel::data(
            Auth::user(),
            LanguageHelper::getLangColumn()
        ));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store(StoreOfferRequest $request)
    {
        try {
            $offer = $this->offerService->createOffer(Auth::user(), $request->validated(), $request->file('images'));
        } catch (\Exception $e) {
            return redirect()->route('offer.index')
                ->withErrors(['error' => __('messages.offer_create_not_allowed')]); //TODO: translation
        }

        return redirect()->route('offer.show', $offer->id)
            ->with('success', __('messages.offer_created'));
    }

    /**
     * Display the specified resource.
     * @param Offer $offer
     */
    public function show(Offer $offer)
    {
        return inertia('Offer/Show', OfferShowViewModel::data(
            $offer,
            Auth::user()
        ));
    }

    /**
     * Show the form for editing the specified resource.
     * @param Offer $offer
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
     * Update the specified resource in storage.
     * @param Request $request
     * @param Offer $offer
     */
    public function update(UpdateOfferRequest $request, Offer $offer)
    {
        $offer->update($request->validated());

        return redirect()->route('offer.show', $offer)
            ->with('success', __('messages.offer_updated'));
    }

    /**
     * Remove the specified resource from storage.
     * @param Offer $offer
     */
    public function destroy(Offer $offer)
    {
        $this->authorize('delete', $offer);

        $this->offerService->deleteOffer($offer);

        return redirect()->route('profile.show')
            ->with('success', __('messages.offer_deleted'));
    }

    public function uploadTempImages(Request $request)
    {
        $request->validate([
            'file' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $path = $request->file('file')->store('temp', 'public');

        return response()->json(['path' => Storage::url($path)]);
    }

    public function sellOffer(Request $request, Offer $offer): void
    {
        $this->authorize('update', $offer);

        $this->offerTransactionService->sellOffer($request, $offer);
    }

    public function receiveOffer(Request $request, Offer $offer): void
    {
        //TODO: policy
        $user = Auth::user();
        if ($user->id !== $offer->buyer_id || $offer->status !== StatusEnum::Sold->value) {
            abort(403, __('messages.not_allowed'));
        }

        $this->offerTransactionService->receiveOffer($offer);
    }

    public function cancelOffer(Request $request, Offer $offer)
    {
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
