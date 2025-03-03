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
        $filters = Filter::where('filter_category_id', $filterCategoryId)
            ->select('id', "$langColumn as name", 'cs')
            ->get();

        return response()->json($filters);
    }
}
