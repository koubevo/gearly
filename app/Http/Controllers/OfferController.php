<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\DeliveryOption;
use App\Models\FilterCategory;
use App\Models\Offer;
use App\Models\OfferFilter;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class OfferController extends Controller implements HasMedia
{
    use AuthorizesRequests, InteractsWithMedia;

    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $filters = $request->only(['category', 'brand', 'sport', 'condition', 'price', 'search']);

        $offers = Offer::with('brand')
            ->filter($filters)
            ->active()
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString()
            ->through(function ($offer) {
                $offer->thumbnail_url = $offer->getFirstMediaUrl('images', 'thumb');
                return $offer;
            });

        if ($request->wantsJson()) {
            return response()->json($offers);
        }

        return inertia('Offer/Index', [
            'offers' => $offers
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::select('id', 'name')->orderBy('name', 'asc')->get();
        $deliveryOptions = DeliveryOption::select('id', 'name')->get();
        $categories = Category::with('filters')->orderBy('name', 'asc')->get();

        return inertia('Offer/Create', [
            'brands' => $brands,
            'categories' => $categories,
            'deliveryOptions' => $deliveryOptions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $maxFreeActiveOffers = 5;

        $activeOffersCount = $user->offers()->where('status', 'active')->count();

        if (!$user->hasPremium() && $activeOffersCount >= $maxFreeActiveOffers) {
            return redirect()->route('offer.index')
                ->withErrors(['error' => 'For now you can have only 5 active offers.']);
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/|min:0|max:99999',
            'currency' => 'required|string|in:eur,czk', //only 2 currencies now
            'condition' => 'required|in:new,used,damaged|lowercase',
            'sport_id' => 'required|integer|in:1,2,3',
            'category_id' => 'required|integer|min:1',
            'brand_id' => 'required|integer|min:1',
            'delivery_option_id' => 'required|integer|min:1',
            'delivery_detail' => 'nullable|string',
            'images' => 'required|array|min:1',
            'images.*' => 'image|max:5120',
        ] + collect($request->all())
                ->filter(fn($value, $key) => str_starts_with($key, 'fc'))
                ->mapWithKeys(fn($value, $key) => [$key => 'nullable|integer'])
                ->toArray());
        $validated['user_id'] = $user->id;

        $offer = Offer::create($validated);

        //TODO: filters can be null
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

                $offer->addMedia($image)
                    ->usingFileName($fileName)
                    ->toMediaCollection('images', 'media');
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
        $offer->load('seller', 'category', 'brand', 'deliveryOption', 'offerFilters.filterCategory', 'offerFilters.filter');

        return inertia('Offer/Show', [
            'offer' => [
                ...$offer->toArray(),
                'sport' => $offer->getSportEnum()?->label(),
            ],
            'seller' => $offer->seller,
            'category' => $offer->category,
            'brand' => $offer->brand,
            'deliveryOption' => $offer->deliveryOption,
            'images' => $offer->getMedia('images')->map(fn($image) => $image->getUrl()),
            'filters' => $offer->offerFilters->map(fn($filter) => [
                'id' => $filter->id,
                'offer_id' => $filter->offer_id,
                'filter_id' => $filter->filter_id,
                'filter_category_id' => $filter->filter_category_id,
                'filter_category_name' => $filter->filterCategory->name ?? null,
                'filter_name' => $filter->filter->name ?? null,
            ]),
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     * @param Offer $offer
     */
    public function edit(Offer $offer)
    {
        $brands = Brand::select('id', 'name')->orderBy('name', 'asc')->get();
        $deliveryOptions = DeliveryOption::select('id', 'name')->get();
        $categories = Category::with('filters')->orderBy('name', 'asc')->get();

        $this->authorize('update', $offer);

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
            'currency' => 'required|string|in:eur,czk', //only 2 currencies now
            'condition' => 'required|in:new,used,damaged|lowercase',
            'sport_id' => 'required|integer|in:1,2,3',
            'category_id' => 'required|integer|min:1',
            'brand_id' => 'required|integer|min:1',
            'delivery_option_id' => 'required|integer|min:1',
            'delivery_detail' => 'nullable|string',
        ]);

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

        $offer->status = 'deleted';
        $offer->save();
        $offer->delete();

        return redirect()->route('offer.index')
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

}
