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
    /**
     * Initializes the controller with landing page and offer services.
     *
     * @param LandingPageService $landingPageService Service for retrieving landing page data.
     * @param OfferService $offerService Service for retrieving offer data.
     */
    public function __construct(
        protected LandingPageService $landingPageService,
        protected OfferService $offerService
    ) {

    }

    /**
     * Handles landing page requests, returning either a JSON response with paginated offers or rendering the landing page view with relevant data.
     *
     * If the request expects JSON, returns paginated offers. Otherwise, renders the landing page with new arrivals, top brands, category-specific bats and gear, favorites, and the brand with the most active offers.
     *
     * @param Request $request The incoming HTTP request.
     * @return \Illuminate\Http\JsonResponse|\Inertia\Response
     */
    public function index(Request $request)
    {
        if (request()->wantsJson()) {
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
