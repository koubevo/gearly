<?php

namespace App\Services;

use App\Models\User;
use App\Models\Offer;
use App\Models\OfferFilter;
use Illuminate\Support\Facades\Auth;

class OfferService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public function createOffer(User $user, array $validated, ?array $images = null): Offer
    {
        $activeOffersCount = $user->offers()->where('status', 1)->count();

        if (!$user->hasPremium() && $activeOffersCount >= Offer::MAX_FREE_ACTIVE_OFFERS) {
            //TODO: translation
            throw new \Exception('For now you can have only 5 active offers.');
        }

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

        if ($images) {
            foreach ($images as $image) {
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

        return $offer;
    }
}
