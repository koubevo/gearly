<?php

namespace Tests\Unit\Services;

use App\Enums\StatusEnum;
use App\Models\User;
use App\Models\Offer;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected UserService $userService;
    protected Offer $deletedOffer;
    protected Offer $otherOffer;


    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->userService = new UserService();

        $this->otherOffer = Offer::factory()->create();

        $this->deletedOffer = Offer::factory()
            ->create([
                'user_id' => $this->user->id,
                'status' => StatusEnum::Deleted->value
            ]);
    }

    public function test_get_active_offers_returns_only_active_offers_for_user(): void
    {
        // Offers from this user
        $offer1 = Offer::factory()
            ->create([
                'user_id' => $this->user->id,
                'status' => StatusEnum::Active->value
            ]);
        $offer2 = Offer::factory()
            ->create([
                'user_id' => $this->user->id,
                'status' => StatusEnum::Active->value
            ]);
        $soldOffer = Offer::factory()
            ->create([
                'user_id' => $this->user->id,
                'status' => StatusEnum::Sold->value
            ]);

        $activeOffers = $this->userService->getActiveOffers($this->user);

        $this->assertCount(2, $activeOffers);
        $this->assertCount(5, Offer::all());
    }

    public function test_get_active_offers_returns_empty_array_if_user_has_no_active_offers(): void
    {
        $soldOffer = Offer::factory()
            ->create([
                'user_id' => $this->user->id,
                'status' => StatusEnum::Sold->value
            ]);

        $activeOffers = $this->userService->getActiveOffers($this->user);

        $this->assertEquals([], $activeOffers);
    }

    public function test_get_sold_offers_returns_only_sold_offers(): void
    {
        $soldOffer = Offer::factory()
            ->create([
                'user_id' => $this->user->id,
                'status' => StatusEnum::Sold->value
            ]);

        $soldReceivedOffer1 = Offer::factory()
            ->create([
                'user_id' => $this->user->id,
                'status' => StatusEnum::Received->value
            ]);

        $soldReceivedOffer2 = Offer::factory()
            ->create([
                'user_id' => $this->user->id,
                'status' => StatusEnum::Received->value
            ]);

        $soldReceivedOffers = $this->userService->getSoldReceivedOffers($this->user);

        $this->assertCount(2, $soldReceivedOffers);
    }

    public function test_get_sold_offers_returns_empty_array_if_user_has_no_sold_offers(): void
    {
        $soldReceivedOffers = $this->userService->getSoldReceivedOffers($this->user);

        $this->assertEquals([], $soldReceivedOffers);
    }

    public function test_sold_and_bought_offers_count_returns_correct_number(): void
    {
        $soldOffer = Offer::factory()
            ->create([
                'user_id' => $this->user->id,
                'status' => StatusEnum::Sold->value
            ]);

        $soldReceivedOffer1 = Offer::factory()
            ->create([
                'user_id' => $this->user->id,
                'status' => StatusEnum::Received->value
            ]);

        $soldReceivedOffer2 = Offer::factory()
            ->create([
                'user_id' => $this->user->id,
                'status' => StatusEnum::Received->value
            ]);

        $boughtOffer = Offer::factory()
            ->create([
                'buyer_id' => $this->user->id,
                'status' => StatusEnum::Received->value
            ]);

        $bookedOffer = Offer::factory()
            ->create([
                'buyer_id' => $this->user->id,
                'status' => StatusEnum::Sold->value
            ]);

        $soldAndBoughtOffersCount = $this->userService->getSoldAndBoughtOffersCount($this->user);

        $this->assertEquals(3, $soldAndBoughtOffersCount);
    }

    public function test_sold_and_bought_offers_count_returns_zero_if_none(): void
    {
        $soldAndBoughtOffersCount = $this->userService->getSoldAndBoughtOffersCount($this->user);

        $this->assertEquals(0, $soldAndBoughtOffersCount);
    }

    public function test_transform_offer_returns_expected_structure()
    {
        $offer = Offer::factory()->create();

        $result = $this->userService->transformOffer($offer, $this->user);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('thumbnail_url', $result);
        $this->assertArrayHasKey('favorites_count', $result);
        $this->assertArrayHasKey('favorited_by_user', $result);
        $this->assertArrayHasKey('condition', $result);
        $this->assertArrayHasKey('conditionNumber', $result);
        $this->assertArrayHasKey('status', $result);
        $this->assertArrayHasKey('statusNumber', $result);
    }
}
