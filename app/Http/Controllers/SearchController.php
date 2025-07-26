<?php

namespace App\Http\Controllers;

use App\Helpers\LanguageHelper;
use App\Models\Brand;
use App\Models\Category;
use App\Services\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Initializes the controller with a SearchService instance.
     *
     * @param SearchService $searchService The service used for retrieving search-related data.
     */
    public function __construct(protected SearchService $searchService)
    {

    }

    /**
     * Displays the search index page with categories and brands data.
     *
     * Retrieves categories and brands from the search service and renders the Search/Index view using Inertia.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        return inertia('Search/Index', [
            'categories' => $this->searchService->getCategories(),
            'brands' => $this->searchService->getBrands(),
        ]);
    }
}
