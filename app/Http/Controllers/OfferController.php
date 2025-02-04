<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
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
        Offer::create($request->validate([
            'name' => 'required|string',
            'phone' => 'required|boolean',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'currency' => 'required|string|in:eur,czk', //only 2 currencies now
            'condition' => 'required|in:new,used|lowercase', //TODO: add more conditions
            'sport' => 'required|integer|in:1,2,3',
            'category_id' => 'required|integer|min:1',
            'brand_id' => 'required|integer|min:1',
            'user_id' => 'required|integer'
        ]));

        return redirect()->route('offer.index')
            ->with('success', 'Offer was created.');
    }

    /**
     * Display the specified resource.
     * @param Offer $offer
     */
    public function show(Offer $offer)
    {
        return inertia(
            'Offer/Show',
            [
                'offer' => $offer
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     * @param Offer $offer
     */
    public function edit(Offer $offer)
    {
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
        $offer->update($request->validate([
            'name' => 'required|string',
            'phone' => 'required|boolean',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'currency' => 'required|string|in:eur,czk', //only 2 currencies now
            'condition' => 'required|in:new,used|lowercase', //TODO: add more conditions
            'sport' => 'required|integer|in:1,2,3',
            'category_id' => 'required|integer|min:1',
            'brand_id' => 'required|integer|min:1',
        ]));

        return redirect()->route('offer.index')
            ->with('success', 'Offer was updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
