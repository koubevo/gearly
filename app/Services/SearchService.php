<?php

namespace App\Services;

use App\Helpers\LanguageHelper;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Collection;

class SearchService
{
    /**
     * Retrieve all categories with or without active offers.
     * @return Collection
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
     * Retrieve all brands with active offers.
     * @return Collection
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
