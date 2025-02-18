<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nnjeim\World\World;

class LocationController extends Controller
{
    public function getCountries()
    {
        $allowedCountries = ['CZ', 'NL', 'IT', 'DK', 'DE', 'ES', 'AT', 'BE', 'PL', 'HR', 'FR', 'SK', 'SE', 'GB'];

        $countries = World::countries([
            'fields' => 'iso2,name',
            'filters' => [
                'region' => 'Europe'
            ]
        ])->data;

        $filteredCountries = $countries->filter(fn($country) => in_array($country['iso2'], $allowedCountries));
        // sort by popularity
        $sortedCountries = $filteredCountries->sortBy(fn($country) => array_search($country['iso2'], $allowedCountries));

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

        $cities = World::cities([
            'fields' => 'name',
            'filters' => [
                'country_code' => $iso2
            ]
        ])->data;

        return response()->json([
            'success' => true,
            'data' => $cities
        ]);
    }
}
