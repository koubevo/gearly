<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('offers')
            ->orderBy('name', 'asc')
            ->get();
        return inertia('Search/Index', [
            'categories' => $categories
        ]);
    }
}
