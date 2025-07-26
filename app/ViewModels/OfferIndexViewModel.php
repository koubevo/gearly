<?php

namespace App\ViewModels;

use Illuminate\Support\Collection;
use App\Models\Category;
use App\Models\Brand;
use \Illuminate\Pagination\LengthAwarePaginator;

class OfferIndexViewModel
{
    /**
     * Initializes a new instance of the OfferIndexViewModel class.
     */
    public function __construct()
    {
        //
    }

    /**
     * Prepares and returns an array of data for offer-related views, including paginated offers, localized categories with filter categories, brands, and combined filters.
     *
     * @param LengthAwarePaginator $offers Paginated offer data.
     * @param array $filters Predefined static filters.
     * @param Collection $dynamicFilters Additional dynamic filters.
     * @param string $langColumn The column name for localized category names.
     * @return array Associative array containing offers, categories, brands, and filters.
     */
    public static function data(LengthAwarePaginator $offers, array $filters, Collection $dynamicFilters, string $langColumn): array
    {
        return [
            'offers' => $offers,
            'categories' => Category::with([
                'filterCategories' => fn($q) => $q->select('filter_categories.id', "{$langColumn} as name")
            ])->select('id', "{$langColumn} as name")->orderBy($langColumn, 'asc')->get(),
            'brands' => Brand::select('id', 'name')->orderBy('name', 'asc')->get(),
            'filters' => [
                ...$filters,
                ...$dynamicFilters->toArray(),
            ],
        ];
    }
}
