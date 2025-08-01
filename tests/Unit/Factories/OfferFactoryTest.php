<?php

namespace Tests\Unit\Factories;

use Tests\TestCase;
use App\Models\Offer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OfferFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_offer_factory_creates_valid_offer(): void
    {
        $offer = Offer::factory()->create();

        $this->assertDatabaseHas('offers', [
            'id' => $offer->id,
        ]);
    }
}
