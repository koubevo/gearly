<?php

namespace App\Http\Controllers;

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
        return inertia(
            'Offer/Index',
            [
                'offers' => Offer::all()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Offer/Create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->user()->offers()->create($request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer|min:0|max:99999',
            'currency' => 'required|string|in:eur,czk', //only 2 currencies now
            'condition' => 'required|in:new,used,damaged|lowercase',
            'sport' => 'required|integer|in:1,2,3',
            'category_id' => 'required|integer|min:1',
            'brand_id' => 'required|integer|min:1'
        ]));

        //TODO: redirect to profile page
        return redirect()->route('offer.index')
            ->with('success', 'Offer was created.');
    }

    /**
     * Display the specified resource.
     * @param Offer $offer
     */
    public function show(Offer $offer)
    {
        $offer->load('seller');

        return inertia(
            'Offer/Show',
            [
                'offer' => $offer,
                'seller' => $offer->seller
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     * @param Offer $offer
     */
    public function edit(Offer $offer)
    {
        $this->authorize('update', $offer);

        return inertia(
            'Offer/Edit',
            [
                'offer' => $offer
            ]
        );
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
            'price' => 'required|integer|min:0|max:99999',
            'currency' => 'required|string|in:eur,czk', //only 2 currencies now
            'condition' => 'required|in:new,used,damaged|lowercase',
            'sport' => 'required|integer|in:1,2,3',
            'category_id' => 'required|integer|min:1',
            'brand_id' => 'required|integer|min:1',
        ]));

        //TODO: redirect to profile page
        return redirect()->route('offer.index')
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
