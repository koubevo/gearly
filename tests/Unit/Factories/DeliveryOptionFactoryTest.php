<?php

namespace Tests\Unit\Factories;

use Tests\TestCase;
use App\Models\DeliveryOption;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeliveryOptionFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_delivery_option_factory_creates_valid_delivery_option(): void
    {
        $deliveryOption = DeliveryOption::factory()->create();

        $this->assertDatabaseHas('delivery_options', [
            'id' => $deliveryOption->id,
        ]);
    }
}
