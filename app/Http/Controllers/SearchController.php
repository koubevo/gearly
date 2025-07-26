<?php

namespace App\Http\Controllers;

use App\Helpers\LanguageHelper;
use App\Models\Brand;
use App\Models\Category;
use App\Services\SearchService;
use Illuminate\Http\Request;

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
