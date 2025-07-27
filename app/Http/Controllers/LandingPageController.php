<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LandingPageService;
use App\Services\OfferService;
use App\Enums\SportEnum;
use App\Models\Offer;

class LandingPageController extends Controller
{
    private const PAGINATED_OFFERS_LIMIT = 8;
    public function __construct(
        protected LandingPageService $landingPageService,
        protected OfferService $offerService
    ) {

    }

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return response()->json($this->offerService->getPaginatedOffers(self::PAGINATED_OFFERS_LIMIT));
        }

        return inertia('LandingPage', [
            'newArrivals' => $this->landingPageService->getNewArrivals(),
            'brandWithMostActiveOffers' => $this->landingPageService->getBrandWithMostActiveOffers(),
            'baseballBats' => $this->landingPageService->getBats(SportEnum::Baseball),
            'softballBats' => $this->landingPageService->getBats(SportEnum::Softball),
            'baseballGear' => $this->landingPageService->getGear(SportEnum::Baseball),
            'softballGear' => $this->landingPageService->getGear(SportEnum::Softball),
            'favorites' => $this->landingPageService->getFavorites(),
            'topBrands' => $this->landingPageService->getTopBrands(),
            'allOffers' => $this->offerService->getPaginatedOffers(self::PAGINATED_OFFERS_LIMIT),
        ]);
    }
}
