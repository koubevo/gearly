<?php

namespace App\ViewModels;

use App\Models\Offer;
use App\Models\Brand;
use App\Models\Category;
use App\Models\DeliveryOption;

class OfferEditViewModel
{
    /****
     * Initializes a new instance of the OfferEditViewModel class.
     */
    public function __construct()
    {
        //
    }

    /**
     * Prepares and returns data required for editing an offer.
     *
     * Retrieves the specified offer, a list of brands, delivery options with localized names, and categories with their related filter categories, all formatted for use in an offer editing context.
     *
     * @param Offer $offer The offer to be edited.
     * @param string $langColumn The name of the language-specific column to use for localized fields.
     * @return array Associative array containing the offer, brands, categories, and delivery options.
     */
    public static function data(Offer $offer, string $langColumn): array
    {
        $brands = Brand::select('id', 'name')->orderBy('name', 'asc')->get();
        $deliveryOptions = DeliveryOption::select('id', "$langColumn as name")->get();
        $categories = Category::with('filterCategories')
            ->select('id', "$langColumn as name", 'logo', 'created_at', 'updated_at')
            ->orderBy('name', 'asc')
            ->get();

        return [
            'offer' => $offer,
            'brands' => $brands,
            'categories' => $categories,
            'deliveryOptions' => $deliveryOptions,
        ];
    }
}
