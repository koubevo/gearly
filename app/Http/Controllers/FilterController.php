<?php

namespace App\Http\Controllers;

use App\Helpers\LanguageHelper;
use App\Models\Filter;
use App\Models\FilterCategory;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function getFiltersByCategory($filterCategoryId)
    {
        $langColumn = LanguageHelper::getLangColumn();
        //TODO: filters translations
        $filters = Filter::where('filter_category_id', $filterCategoryId)->get();

        return response()->json($filters);
    }
}
