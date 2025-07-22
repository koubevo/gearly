<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LandingPageService;
use App\Enums\SportEnum;

class LandingPageController extends Controller
{
    public function __construct(
        protected LandingPageService $landingPageService
    ) {

    }

    public function index(Request $request)
    {
        return inertia('LandingPage', [
            'newArrivals' => $this->landingPageService->getNewArrivals(),
            'brandWithMostActiveOffers' => $this->landingPageService->getBrandWithMostActiveOffers(),
            'baseballBats' => $this->landingPageService->getBats(SportEnum::Baseball),
            'softballBats' => $this->landingPageService->getBats(SportEnum::Softball),
            'baseballGear' => $this->landingPageService->getGear(SportEnum::Baseball),
            'softballGear' => $this->landingPageService->getGear(SportEnum::Softball),
            'favorites' => $this->landingPageService->getFavorites(),
            'topBrands' => $this->landingPageService->getTopBrands(),
        ]);
    }
}
