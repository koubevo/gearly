<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Helpers\LanguageHelper;
use App\Models\User;
use App\Models\Offer;
use App\Models\OfferFilter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use \Illuminate\Pagination\LengthAwarePaginator;

class OfferService
{
    /****
     * Initializes a new instance of the OfferService class.
     */
    public function __construct()
    {

    }

    /**
     * Creates a new offer for a user, associates filters, and attaches optional images.
     *
     * Enforces a limit on the number of active offers for non-premium users. Associates filter categories and filters based on validated input keys, and attaches provided images to the offer's media collection with unique filenames.
     *
     * @param User $user The user creating the offer.
     * @param array $validated Validated offer data, including filter associations.
     * @param array|null $images Optional array of image files to attach to the offer.
     * @return Offer The newly created offer instance.
     * @throws \Exception If the user exceeds the maximum number of active free offers.
     */
    public function createOffer(User $user, array $validated, ?array $images = null): Offer
    {
        $activeOffersCount = $user->offers()->where('status', StatusEnum::Active)->count();

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

    /**
     * Retrieves a paginated list of active offers with applied static and dynamic filters.
     *
     * Each offer in the result includes additional metadata such as thumbnail URL, favorites count, user-specific favorited status, and labels for condition and status enums.
     *
     * @param int $lenght The number of offers per page.
     * @param array $filters Optional static filters and sorting options.
     * @param Collection|null $dynamicFilters Optional dynamic filter IDs to further filter offers.
     * @return LengthAwarePaginator Paginated offers with enriched metadata.
     */
    public function getPaginatedOffers(int $lenght, array $filters = [], ?Collection $dynamicFilters = null): LengthAwarePaginator
    {
        $user = Auth::user() ?? null;
        return Offer::with('brand')
            ->filter($filters)
            ->when(!empty($dynamicFilters), function ($query) use ($dynamicFilters) {
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

    /**
     * Loads detailed relationships for the specified offer, including seller, category, delivery option, and filters with localized names.
     *
     * @param Offer $offer The offer to retrieve details for.
     * @param User|null $user Optional user context (unused in this method).
     * @param string $langColumn The database column name for localized fields.
     * @return Offer The offer with loaded related data.
     */
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

    /**
     * Permanently deletes an offer after marking its status as deleted.
     *
     * Updates the offer's status to deleted, saves the change, and then performs a hard delete.
     *
     * @param Offer $offer The offer to be deleted.
     */
    public function deleteOffer(Offer $offer): void
    {
        $offer->status = StatusEnum::Deleted;
        $offer->save();
        $offer->deleteOrFail();
    }
}
