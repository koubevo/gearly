<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;

class AccessTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $normalUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 1]);
        $this->normalUser = User::factory()->create(['role' => 0]);
    }

    #[DataProvider('adminPagesProvider')]
    public function test_admin_can_access_admin_pages($url): void
    {
        $response = $this->actingAs($this->admin)->get($url);

        $response->assertStatus(200);
    }

    #[DataProvider('adminPagesProvider')]
    public function test_normal_user_can_not_access_admin_pages($url): void
    {
        $response = $this->actingAs($this->normalUser)->get($url);

        $response->assertStatus(403);
    }

    #[DataProvider('adminPagesProvider')]
    public function test_guest_user_can_not_access_admin_pages($url): void
    {
        $response = $this->get($url);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public static function adminPagesProvider()
    {
        return [
            ['/admin'],
            //['/admin/users'],
            ['/admin/brands'],
            ['/admin/categories'],
            ['/admin/delivery-options'],
            ['/admin/filters'],
            ['/admin/filter-categories']
        ];
    }
}
