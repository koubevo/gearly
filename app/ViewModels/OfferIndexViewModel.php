<?php

namespace App\ViewModels;

use Illuminate\Support\Collection;
use App\Models\Category;
use App\Models\Brand;
use \Illuminate\Pagination\LengthAwarePaginator;

class OfferIndexViewModel
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

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
