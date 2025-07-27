<?php

namespace App\ViewModels;

use App\Models\Offer;
use App\Models\User;
use App\Services\OfferFormService;

class OfferCreateViewModel
{
    public static function data(User $user, string $langColumn, OfferFormService $offerFormService): array
    {
        return [
            'brands' => $offerFormService->getBrands(),
            'categories' => $offerFormService->getCategories($langColumn),
            'deliveryOptions' => $offerFormService->getDeliveryOptions($langColumn),
            'freeLimitExceeded' => $offerFormService->isOfferLimitExceeded($user),
            'limit' => Offer::MAX_FREE_ACTIVE_OFFERS,
            'lang' => $langColumn
        ];
    }
}
