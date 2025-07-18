<?php

namespace App\Http\Controllers;

use App\Helpers\LanguageHelper;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\DeliveryOption;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Storage;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use \Illuminate\Support\Facades\Auth;
use App\Services\MessageNotificationService;
use \App\Services\OfferService;
use App\ViewModels\OfferIndexViewModel;
use App\ViewModels\OfferCreateViewModel;

class OfferController extends Controller implements HasMedia
{
    use AuthorizesRequests, InteractsWithMedia;

    protected $offerService;

    public function __construct(OfferService $offerService)
    {
        $this->offerService = $offerService;
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
        $user = Auth::user();
        $langColumn = LanguageHelper::getLangColumn();

        $offer->load([
            'seller',
            'category:id,' . $langColumn . ' as name',
            'deliveryOption:id,' . $langColumn . ' as name',
            'offerFilters.filterCategory:id,' . $langColumn . ' as name',
            'offerFilters.filter:id,' . $langColumn . ' as name',
        ]);

        return inertia('Offer/Show', [
            'offer' => [
                ...$offer->toArray(),
                'sport' => $offer->getSportEnum()?->label(),
                'condition' => $offer->getConditionEnum()?->label(),
                'conditionNumber' => $offer->condition,
                'status' => $offer->getStatusEnum()?->label(),
                'statusNumber' => $offer->status,
                'favorites_count' => $offer->favorites()->count(),
                'favorited_by_user' => $user ? $offer->favorites()->where('user_id', $user->id)->exists() : false,
                'updated_at' => $offer->updated_at?->diffForHumans(),
            ],
            'soldOffersCount' => $offer->seller->offers()->sold()->count(),
            'seller' => [
                ...$offer->seller->toArray(),
                'last_login_at' => $offer->seller->last_login_at?->diffForHumans(),
            ],
            'category' => $offer->category,
            'brand' => $offer->brand,
            'deliveryOption' => $offer->deliveryOption,
            'rating' => $offer->seller->getRating(),
            'images' => $offer->getMedia('images')->map(fn($image) => [
                'medium' => $image->getUrl('medium'),
                'thumb' => $image->getUrl('thumb'),
            ]),
            'filters' => $offer->offerFilters->map(fn($filter) => [
                'id' => $filter->id,
                'offer_id' => $filter->offer_id,
                'filter_id' => $filter->filter_id,
                'filter_category_id' => $filter->filter_category_id,
                'filter_category_name' => $filter->filterCategory?->name,
                'filter_name' => $filter->filter?->name,
            ]),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param Offer $offer
     */
    public function edit(Offer $offer)
    {
        $this->authorize('update', $offer);

        $langColumn = LanguageHelper::getLangColumn();

        $brands = Brand::select('id', 'name')->orderBy('name', 'asc')->get();
        $deliveryOptions = DeliveryOption::select('id', "$langColumn as name")->get();
        $categories = Category::with('filterCategories')
            ->select('id', "$langColumn as name", 'logo', 'created_at', 'updated_at')
            ->orderBy('name', 'asc')
            ->get();

        return inertia('Offer/Edit', [
            'offer' => $offer,
            'brands' => $brands,
            'categories' => $categories,
            'deliveryOptions' => $deliveryOptions
        ]);
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

        $offer->status = 5;
        $offer->save();
        $offer->deleteOrFail();

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

    public function sellOffer(Request $request, Offer $offer)
    {
        $user = Auth::user();
        $this->authorize('update', $offer);

        $offer->buyer_id = $request->buyer['id'];
        $offer->status = 2;
        $offer->save();

        $message = $offer->messages()->create([
            'seller_id' => $user->id,
            'buyer_id' => $request->buyer['id'],
            'author_id' => $user->id,
            'receiver_id' => $request->buyer['id'],
            'offer_id' => $offer->id,
            'type_id' => 2,
            'message' => 'Offer was sold to ' . $request->buyer['name'] . '.',
            'cs' => 'Nabídka byla prodána uživateli ' . $request->buyer['name'] . '.',
        ]);

        MessageNotificationService::notifyChatAction(
            message: $message,
            user: $user,
            offer: $offer,
            buyer: User::findOrFail((int) $offer->buyer_id),
            actionType: 5
        );

        broadcast(new \App\Events\MessageSent($message));
    }

    public function receiveOffer(Request $request, Offer $offer)
    {
        $user = Auth::user();
        if ($user->id !== $offer->buyer_id) {
            abort(403, 'You are not allowed to access this page.');
        }

        if ($offer->status !== 2) {
            abort(403, 'You are not allowed to access this page.');
        }

        $offer->status = 3;
        $offer->save();

        $message = $offer->messages()->create([
            'seller_id' => $offer->user_id,
            'buyer_id' => $user->id,
            'author_id' => $user->id,
            'receiver_id' => $offer->user_id,
            'offer_id' => $offer->id,
            'type_id' => 3,
            'message' => 'Offer was received. Now you can rate each other.',
            'cs' => 'Nabídka byla přijata. Nyní si můžete navzájem udělit hodnocení.',
        ]);

        MessageNotificationService::notifyChatAction(
            message: $message,
            user: $user,
            offer: $offer,
            buyer: User::findOrFail((int) $offer->buyer_id),
            actionType: 6
        );

        broadcast(new \App\Events\MessageSent($message));
    }

    public function cancelOffer(Request $request, Offer $offer)
    {
        $user = Auth::user();
        if ($user->id !== $offer->user_id) {
            abort(403, 'You are not allowed to access this page.');
        }

        if ($offer->status !== 2) {
            abort(403, 'You are not allowed to access this page.');
        }

        $maxFreeActiveOffers = Offer::MAX_FREE_ACTIVE_OFFERS;
        $activeOffersCount = $user->offers()->where('status', 1)->count();

        if (!$user->hasPremium() && $activeOffersCount >= $maxFreeActiveOffers) {
            return redirect()->route('offer.index')
                ->withErrors(['error' => 'For now you can have only 5 active offers.']);
        }

        $buyerId = $offer->buyer_id;
        $offer->buyer_id = null;
        $offer->status = 1;
        $offer->save();

        $message = $offer->messages()->create([
            'seller_id' => $offer->user_id,
            'buyer_id' => $buyerId,
            'author_id' => $offer->user_id,
            'receiver_id' => $buyerId,
            'offer_id' => $offer->id,
            'type_id' => 5,
            'message' => 'The sale was canceled by the seller.',
            'cs' => 'Prodej byl zrušen prodejcem.',
        ]);

        broadcast(new \App\Events\MessageSent($message));
    }
}
