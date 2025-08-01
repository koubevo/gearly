<?php

namespace Tests\Unit\Factories;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_factory_creates_valid_category(): void
    {
        $category = Category::factory()->create();

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
        ]);
    }
}
