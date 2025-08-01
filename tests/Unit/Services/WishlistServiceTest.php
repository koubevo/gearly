<?php

namespace Tests\Unit\Services;

use App\Models\Favorite;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Offer;
use App\Services\WishlistService;

class WishlistServiceTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Offer $offer;
    protected WishlistService $wishlistService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->offer = Offer::factory()->create();
        $this->wishlistService = new WishlistService();
    }

    public function test_toggle_favorite_adds_favorite_if_not_exists(): void
    {
        $result = $this->wishlistService->toggleFavorite($this->offer, $this->user);

        $this->assertEquals(WishlistService::STATUS_ADDED, $result);
        $this->assertDatabaseHas('favorites', [
            'user_id' => $this->user->id,
            'offer_id' => $this->offer->id
        ]);
    }

    public function test_toggle_favorite_remove_favorite_if_exists(): void
    {
        Favorite::create([
            'user_id' => $this->user->id,
            'offer_id' => $this->offer->id,
            'created_at' => now()
        ]);

        $result = $this->wishlistService->toggleFavorite($this->offer, $this->user);

        $this->assertEquals(WishlistService::STATUS_DELETED, $result);
        $this->assertDatabaseMissing('favorites', [
            'user_id' => $this->user->id,
            'offer_id' => $this->offer->id
        ]);
    }

    public function test_get_favorites_count_returns_correct_number(): void
    {
        $offer = Offer::factory()->create(['user_id' => $this->user->id]);

        Favorite::factory()->count(3)->create(['offer_id' => $offer->id]);

        $count = $this->wishlistService->getFavoritesCount($offer);

        $this->assertEquals(3, $count);
    }
}
