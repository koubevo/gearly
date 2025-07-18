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
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

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
