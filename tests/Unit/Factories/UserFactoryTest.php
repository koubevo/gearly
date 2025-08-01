<?php

namespace Tests\Unit\Factories;

use Tests\TestCase;
use App\Models\User;

class UserFactoryTest extends TestCase
{
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
