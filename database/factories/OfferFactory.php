<?php

namespace Database\Factories;

use App\Enums\SportEnum;
use App\Models\Brand;
use App\Models\Category;
use App\Models\DeliveryOption;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'currency' => $this->faker->currencyCode,
            'condition' => $this->faker->numberBetween(1, 5),
            'sport_id' => $this->faker->randomElement(SportEnum::cases())->value,
            'delivery_option_id' => DeliveryOption::factory(),
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'deleted_at' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
            'status' => $this->faker->numberBetween(0, 1),
        ];
    }
}
