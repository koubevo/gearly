<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('offers')
            ->orderBy('name', 'asc')
            ->get();

        $brands = Brand::withCount('offers')
            ->having('offers_count', '>', 0)
            ->orderBy('name', 'asc')
            ->get();

        return inertia('Search/Index', [
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }
}
