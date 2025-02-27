<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Nnjeim\World\World;

class LocationController extends Controller
{
    public function getCountries()
    {
        $allowedCountries = ['CZ', 'NL', 'IT', 'DK', 'DE', 'ES', 'AT', 'BE', 'PL', 'HR', 'FR', 'SK', 'SE', 'GB'];

        $countries = DB::table('countries')
            ->whereIn('iso2', $allowedCountries)
            ->select('iso2', 'name')
            ->get();
        // sort by popularity
        $sortedCountries = $countries->sortBy(fn($country) => array_search($country->iso2, $allowedCountries));

        return response()->json([
            'success' => true,
            'data' => $sortedCountries->values(),
        ]);
    }

    public function getCities(Request $request)
    {
        $iso2 = $request->input('iso2');

        if (!$iso2) {
            return response()->json([
                'success' => false,
                'message' => 'iso2 parameter is required'
            ], 400);
        }

        $cities = DB::table('cities')
            ->where('country_code', $iso2)
            ->select('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $cities
        ]);
    }
}
