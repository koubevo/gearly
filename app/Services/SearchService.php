<?php

namespace App\Services;

use App\Helpers\LanguageHelper;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Collection;

class SearchService
{
    /**
     * Initializes a new instance of the SearchService class.
     */
    public function __construct()
    {
        //
    }

    /**
     * Retrieves all categories with their ID, language-specific name, logo, and a count of active offers.
     *
     * The name column is selected based on the current language setting. Each category includes a count of related offers that are currently active. Results are ordered alphabetically by name.
     *
     * @return Collection A collection of categories with active offer counts.
     */
    public function getCategories(): Collection
    {
        $langColumn = LanguageHelper::getLangColumn();

        return Category::select('id', "$langColumn as name", "logo")
            ->withCount([
                'offers' => function ($query) {
                    $query->active();
                }
            ])
            ->orderBy('name', 'asc')
            ->get();
    }

    /**
     * Retrieves all brands that have at least one active offer.
     *
     * Returns a collection of brands, each including a count of their active offers, filtered to only those with at least one active offer and ordered alphabetically by name.
     *
     * @return Collection Collection of brands with active offers and their offer counts.
     */
    public function getBrands(): Collection
    {
        return Brand::withCount([
            'offers' => function ($query) {
                $query->active();
            }
        ])
            ->having('offers_count', '>', 0)
            ->orderBy('name', 'asc')
            ->get();
    }
}
