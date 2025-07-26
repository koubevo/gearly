<?php

namespace App\ViewModels;

use Illuminate\Support\Collection;
use App\Models\Category;
use App\Models\Brand;
use App\Services\OfferFormService;
use \Illuminate\Pagination\LengthAwarePaginator;

class OfferIndexViewModel
{
    public static function data(LengthAwarePaginator $offers, array $filters, Collection $dynamicFilters, string $langColumn, OfferFormService $offerFormService): array
    {
        return [
            'offers' => $offers,
            'categories' => $offerFormService->getIndexCategories($langColumn),
            'brands' => $offerFormService->getBrands(),
            'filters' => [
                ...$filters,
                ...$dynamicFilters->toArray(),
            ],
        ];
    }
}
