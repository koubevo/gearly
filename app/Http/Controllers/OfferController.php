<?php

namespace App\Http\Controllers;

use App\Helpers\LanguageHelper;
use App\Models\Brand;
use App\Models\Category;
use App\Models\DeliveryOption;
use App\Models\FilterCategory;
use App\Models\Offer;
use App\Models\OfferFilter;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use \Illuminate\Support\Facades\Auth;

class OfferController extends Controller implements HasMedia
{
    use AuthorizesRequests, InteractsWithMedia;

    const MAX_FREE_ACTIVE_OFFERS = 5;

    /**
     * Display a listing of the resource.
     * Order by newest by default. 0 price asc, 1 price desc.
     * 
     * @param Request $request
     */

    public function index(Request $request)
    {
        $langColumn = LanguageHelper::getLangColumn();
        $filters = $request->only([
            'category',
            'brand',
            'sport',
            'condition',
            'price',
            'search',
            'order',
        ]);

        $dynamicFilters = collect($request->all())
            ->filter(fn($value, $key) => str_starts_with($key, 'fc') && $value !== null);


        $user = Auth::user() ?? null;
        $offers = Offer::with('brand')
            ->filter($filters)
            ->when($dynamicFilters->isNotEmpty(), function ($query) use ($dynamicFilters) {
                foreach ($dynamicFilters as $key => $value) {
                    $query->whereHas('offerFilters', function ($q) use ($value) {
                        $q->where('filter_id', $value);
                    });
                }
            })
            ->active()
            ->sort($filters['order'] ?? null)
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
            });

        if ($request->wantsJson()) {
            return response()->json($offers);
        }

        return inertia('Offer/Index', [
            'offers' => $offers,
            'categories' => Category::with([
                'filters' => fn($q) => $q->select('filter_categories.id', "{$langColumn} as name")
            ])->select('id', "{$langColumn} as name")->orderBy($langColumn, 'asc')->get(),
            'brands' => Brand::select('id', 'name')->orderBy('name', 'asc')->get(),
            'filters' => [
                ...$filters,
                ...$dynamicFilters->toArray(),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $langColumn = LanguageHelper::getLangColumn();

        $brands = Brand::select('id', 'name')->orderBy('name', 'asc')->get();
        $deliveryOptions = DeliveryOption::select('id', "$langColumn as name")->get();
        $categories = Category::with('filters')
            ->select('id', "$langColumn as name", 'logo', 'created_at', 'updated_at')
            ->orderBy('name', 'asc')
            ->get();
        $activeOffersCount = $user->offers()->where('status', 1)->count();

        return inertia('Offer/Create', [
            'brands' => $brands,
            'categories' => $categories,
            'deliveryOptions' => $deliveryOptions,
            'freeLimitExceeded' => !$user->hasPremium() && $activeOffersCount >= self::MAX_FREE_ACTIVE_OFFERS,
            'limit' => self::MAX_FREE_ACTIVE_OFFERS,
            'lang' => $langColumn
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $maxFreeActiveOffers = self::MAX_FREE_ACTIVE_OFFERS;
        $activeOffersCount = $user->offers()->where('status', 1)->count();

        if (!$user->hasPremium() && $activeOffersCount >= $maxFreeActiveOffers) {
            return redirect()->route('offer.index')
                ->withErrors(['error' => 'For now you can have only 5 active offers.']);
        }

        $rules = [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0|max:99999|regex:/^\d{1,5}(\.\d{1,2})?$/',
            'currency' => 'required|string|in:eur,czk',
            'condition' => 'required|in:1,2,3',
            'sport_id' => 'required|integer|in:1,2,3',
            'category_id' => 'required|integer|min:1',
            'brand_id' => 'required|integer|min:1',
            'delivery_option_id' => 'required|integer|min:1',
            'delivery_detail' => 'nullable|string',
            'images' => 'required|array|min:1',
            'images.*' => 'image|max:5120',
        ];

        $filterRules = collect($request->all())
            ->filter(fn($value, $key) => str_starts_with($key, 'fc'))
            ->mapWithKeys(fn($value, $key) => [$key => 'nullable|integer'])
            ->toArray();

        $rules = array_merge($rules, $filterRules);

        $messages = [
            'images.*.image' => 'Každý soubor musí být obrázek.',
            'images.*.max' => 'Maximální velikost obrázku je 5 MB.',
            'images.required' => 'Musíš nahrát alespoň jeden obrázek.',
        ];

        $validated = $request->validate($rules, $messages);
        $validated['user_id'] = Auth::id();

        $offer = Offer::create($validated);

        //TODO: check if filters corespond to category
        foreach ($validated as $key => $value) {
            if (str_starts_with($key, 'fc')) {
                $filterCategoryId = str_replace('fc', '', $key);
                $filterId = $value;

                OfferFilter::create([
                    'offer_id' => $offer->id,
                    'filter_category_id' => $filterCategoryId,
                    'filter_id' => $filterId,
                ]);
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $randomString = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);

                $extension = $image->getClientOriginalExtension();

                $fileName = "gearly-{$offer->id}-{$randomString}.{$extension}";

                $media = $offer->addMedia($image)
                    ->usingFileName($fileName)
                    ->withResponsiveImages()
                    ->toMediaCollection('images', 'media');

                //TODO: main image can be deleted 
            }
        }

        return redirect()->route('offer.show', $offer->id)->with('success', 'Offer created successfully.');
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
            ],
            'soldOffersCount' => $offer->seller->offers()->sold()->count(),
            'seller' => $offer->seller,
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
        $categories = Category::with('filters')
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
    public function update(Request $request, Offer $offer)
    {
        $this->authorize('update', $offer);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/|min:0|max:99999',
            'currency' => 'required|string|in:eur,czk',
            'condition' => 'required|in:1,2,3',
            'sport_id' => 'required|integer|in:1,2,3',
            'category_id' => 'required|integer|min:1',
            'brand_id' => 'required|integer|min:1',
            'delivery_option_id' => 'required|integer|min:1',
            'delivery_detail' => 'nullable|string',
        ]);

        if ($validatedData['delivery_detail'] === 'null') {
            $validatedData['delivery_detail'] = '';
        }

        $offer->update($validatedData);

        return redirect()->route('offer.show', $offer)
            ->with('success', 'Offer was updated.');
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
            ->with('success', 'Offer was removed.');
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

        $maxFreeActiveOffers = self::MAX_FREE_ACTIVE_OFFERS;
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
