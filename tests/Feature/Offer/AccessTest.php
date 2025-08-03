<?php

namespace Tests\Feature\Offer;

use App\Models\Offer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use PHPUnit\Framework\Attributes\DataProvider;

class AccessTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $normalUser;
    protected Offer $offer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->offer = Offer::factory()->create();
        $this->admin = User::factory()->create(['role' => 1]);
        $this->normalUser = User::factory()->create(['role' => 0]);
    }

    #[DataProvider('publicPagesProvider')]
    public function test_guest_user_can_access_public_pages($url): void
    {
        $url = str_replace('{offerId}', $this->offer->id, $url);
        $response = $this->get($url);

        $response->assertStatus(200);
    }

    #[DataProvider('publicPagesProvider')]
    public function test_normal_user_can_access_public_pages($url): void
    {
        $url = str_replace('{offerId}', $this->offer->id, $url);
        $response = $this->actingAs($this->normalUser)->get($url);

        $response->assertStatus(200);
    }

    #[DataProvider('publicPagesProvider')]
    public function test_admin_user_can_access_public_pages($url): void
    {
        $url = str_replace('{offerId}', $this->offer->id, $url);
        $response = $this->actingAs($this->admin)->get($url);

        $response->assertStatus(200);
    }

    public function test_guest_user_can_not_access_protected_pages(): void
    {
        $responses[] = $this->get('/offer/create');
        $responses[] = $this->post('/offer');
        $responses[] = $this->get("/offer/{$this->offer->id}/edit");
        $responses[] = $this->put("/offer/{$this->offer->id}");
        $responses[] = $this->patch("/offer/{$this->offer->id}");
        $responses[] = $this->delete("/offer/{$this->offer->id}");
        $responses[] = $this->post("/offer/{$this->offer->id}/sell");
        $responses[] = $this->post("/offer/{$this->offer->id}/receive");

        foreach ($responses as $response) {
            $response->assertStatus(302);
        }
    }

    public function test_normal_user_can_access_protected_pages(): void
    {
        $responses[] = $this->actingAs($this->normalUser)->get('/offer/create');
        $responses[] = $this->actingAs($this->normalUser)->post('/offer');

        foreach ($responses as $response) {
            $response->assertStatus(200);
        }
    }

    public function test_normal_user_can_not_edit_other_user_offer(): void
    {
        $responses[] = $this->actingAs($this->normalUser)->get("/offer/{$this->offer->id}/edit");
        $responses[] = $this->actingAs($this->normalUser)->put("/offer/{$this->offer->id}");
        $responses[] = $this->actingAs($this->normalUser)->patch("/offer/{$this->offer->id}");
        $responses[] = $this->actingAs($this->normalUser)->delete("/offer/{$this->offer->id}");
        $responses[] = $this->actingAs($this->normalUser)->post("/offer/{$this->offer->id}/sell");
        $responses[] = $this->actingAs($this->normalUser)->post("/offer/{$this->offer->id}/receive");

        foreach ($responses as $response) {
            $response->assertStatus(403);
        }
    }

    public static function publicPagesProvider()
    {
        return [
            ['/offer'],
            ['/offer/{offerId}']
        ];
    }
}
