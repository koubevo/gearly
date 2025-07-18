<?php

namespace App\ViewModels;

use App\Models\Offer;
use App\Models\Brand;
use App\Models\Category;
use App\Models\DeliveryOption;

class OfferEditViewModel
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

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
