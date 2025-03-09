<?php

namespace App\Http\Controllers;

use App\Helpers\LanguageHelper;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $langColumn = LanguageHelper::getLangColumn();

        $categories = Category::select('id', "$langColumn as name", "logo")
            ->withCount([
                'offers' => function ($query) {
                    $query->active();
                }
            ])
            ->orderBy('name', 'asc')
            ->get();

        $brands = Brand::withCount([
            'offers' => function ($query) {
                $query->active();
            }
        ])
            ->having('offers_count', '>', 0)
            ->orderBy('name', 'asc')
            ->get();

        return inertia('Search/Index', [
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }
}
