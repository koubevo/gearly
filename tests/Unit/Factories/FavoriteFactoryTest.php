<?php

namespace Tests\Unit\Factories;

use Tests\TestCase;
use App\Models\Favorite;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoriteFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_favorite_factory_creates_valid_favorite(): void
    {
        $favorite = Favorite::factory()->create();

        $this->assertDatabaseHas('favorites', [
            'id' => $favorite->id,
        ]);
    }
}
