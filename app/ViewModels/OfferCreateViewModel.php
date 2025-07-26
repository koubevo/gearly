<?php

namespace App\ViewModels;

use App\Models\Category;
use App\Models\Brand;
use App\Models\DeliveryOption;
use App\Models\Offer;
use App\Models\User;

class OfferCreateViewModel
{
    /**
     * Initializes a new instance of the OfferCreateViewModel class.
     */
    public function __construct()
    {
        //
    }

    /**
     * Prepares and returns data required for creating an offer.
     *
     * Retrieves lists of brands, delivery options, and categories (with their filter categories), all localized according to the specified language column. Also determines if the user has exceeded the maximum number of allowed active free offers.
     *
     * @param User $user The user for whom the offer creation data is being prepared.
     * @param string $langColumn The database column name used for localization of names.
     * @return array Associative array containing brands, categories, delivery options, free offer limit status, the offer limit, and the language column used.
     */
    public static function data(User $user, string $langColumn): array
    {
        $brands = Brand::select('id', 'name')->orderBy('name', 'asc')->get();
        $deliveryOptions = DeliveryOption::select('id', "$langColumn as name")->get();
        $categories = Category::with('filterCategories')
            ->select('id', "$langColumn as name", 'logo', 'created_at', 'updated_at')
            ->orderBy('name', 'asc')
            ->get();
        $activeOffersCount = $user->offers()->where('status', 1)->count();

        return [
            'brands' => $brands,
            'categories' => $categories,
            'deliveryOptions' => $deliveryOptions,
            'freeLimitExceeded' => !$user->hasPremium() && $activeOffersCount >= Offer::MAX_FREE_ACTIVE_OFFERS,
            'limit' => Offer::MAX_FREE_ACTIVE_OFFERS,
            'lang' => $langColumn
        ];
    }
}
