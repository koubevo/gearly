<?php

namespace Tests\Unit\Factories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_factory_creates_valid_user(): void
    {
        $this->assertTrue(true);
        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);
        $this->assertNotEmpty($user->name);
        $this->assertNotEmpty($user->email);
        $this->assertNotEmpty($user->location);
        $this->assertTrue($user->exists);
    }
}
