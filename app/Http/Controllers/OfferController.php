<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\DeliveryOption;
use App\Models\FilterCategory;
use App\Models\Offer;
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
        $offer = $request->user()->offers()->create($request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/|min:0|max:99999',
            'currency' => 'required|string|in:eur,czk', //only 2 currencies now
            'condition' => 'required|in:new,used,damaged|lowercase',
            'sport' => 'required|integer|in:1,2,3',
            'category_id' => 'required|integer|min:1',
            'brand_id' => 'required|integer|min:1'
        ]));

        return redirect()->route('offer.show', $offer->id)
            ->with('success', 'Offer was created.');
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
        $categories = Category::select('id', 'name')->orderBy('name', 'asc')->get();
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
            'sport' => 'required|integer|in:1,2,3',
            'category_id' => 'required|integer|min:1',
            'brand_id' => 'required|integer|min:1',
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
