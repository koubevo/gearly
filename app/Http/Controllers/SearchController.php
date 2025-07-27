<?php

namespace App\Http\Controllers;

use App\Services\SearchService;

class SearchController extends Controller
{
    public function __construct(protected SearchService $searchService)
    {
    }

    public function index()
    {
        return inertia('Search/Index', [
            'categories' => $this->searchService->getCategories(),
            'brands' => $this->searchService->getBrands(),
        ]);
    }
}
