<?php

namespace App\Services;

use App\Models\User;
use App\Models\Offer;
use App\Models\OfferFilter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use \Illuminate\Pagination\LengthAwarePaginator;

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

    public function getPaginatedOffers(int $lenght, array $filters, Collection $dynamicFilters, User|null $user = null): LengthAwarePaginator
    {
        return Offer::with('brand')
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
            ->paginate($lenght)
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
    }

    public function getOfferDetail(Offer $offer, User|null $user = null, string $langColumn): Offer
    {
        return $offer->load([
            'seller',
            'category:id,' . $langColumn . ' as name',
            'deliveryOption:id,' . $langColumn . ' as name',
            'offerFilters.filterCategory:id,' . $langColumn . ' as name',
            'offerFilters.filter:id,' . $langColumn . ' as name',
        ]);
    }

    public function deleteOffer(Offer $offer): void
    {
        $offer->status = 5;
        $offer->save();
        $offer->deleteOrFail();
    }
}
