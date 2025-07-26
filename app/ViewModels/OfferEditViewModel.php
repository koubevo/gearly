<?php

namespace App\ViewModels;

use App\Models\Offer;
use App\Models\Brand;
use App\Models\Category;
use App\Models\DeliveryOption;
use App\Services\OfferFormService;

class OfferEditViewModel
{
    public static function data(Offer $offer, string $langColumn, OfferFormService $offerFormService): array
    {
        return [
            'offer' => $offer,
            'brands' => $offerFormService->getBrands(),
            'categories' => $offerFormService->getCategories($langColumn),
            'deliveryOptions' => $offerFormService->getDeliveryOptions($langColumn),
        ];
    }
}
