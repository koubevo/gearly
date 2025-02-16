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
            'data' => $sortedCountries->values(), // Resetuje indexy
        ]);
    }



    public function getCities(Request $request)
    {
        $request->validate([
            'country_id' => 'required|integer'
        ]);

        $cities = World::cities()
            ->where('country_id', $request->country_id)
            ->orderBy('name')
            ->get();

        return response()->json($cities);
    }
}
