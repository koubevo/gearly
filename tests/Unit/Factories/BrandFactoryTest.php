<?php

namespace Tests\Unit\Factories;

use Tests\TestCase;
use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BrandFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_brand_factory_creates_valid_brand(): void
    {
        $brand = Brand::factory()->create();

        $this->assertDatabaseHas('brands', [
            'id' => $brand->id,
        ]);
    }
}
