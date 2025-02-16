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

class OfferController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = Offer::with('brand')->get();

        return inertia(
            'Offer/Index',
            [
                'offers' => $offers
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::select('id', 'name')->orderBy('name', 'asc')->get();
        $categories = Category::select('id', 'name')->orderBy('name', 'asc')->get();
        $deliveryOptions = DeliveryOption::select('id', 'name')->get();
        $categories = Category::with('filters')->get();

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
        ] + collect($request->all())
                ->filter(fn($value, $key) => str_starts_with($key, 'fc'))
                ->mapWithKeys(fn($value, $key) => [$key => 'nullable|integer'])
                ->toArray());
        $validated['user_id'] = \Illuminate\Support\Facades\Auth::user()->id;

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

        return redirect()->route('offer.show', $offer->id)->with('success', 'Offer created successfully.');
    }


    /**
     * Display the specified resource.
     * @param Offer $offer
     */
    public function show(Offer $offer)
    {
        $offer->load('seller', 'category', 'brand', 'deliveryOption');

        return inertia('Offer/Show', [
            'offer' => [
                ...$offer->toArray(),
                'sport' => $offer->getSportEnum()?->label(),
            ],
            'seller' => $offer->seller,
            'category' => $offer->category,
            'brand' => $offer->brand,
            'deliveryOption' => $offer->deliveryOption
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
        $categories = Category::with('filters')->get();

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

        $offer->update($request->validate([
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
        ]));

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

        $offer->delete();

        return redirect()->route('offer.index')
            ->with('success', 'Offer was removed.');
    }
}
