<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'location' => 'Test City'
        ]);

        User::factory()->create([
            'name' => 'Admin @ Gearly',
            'email' => 'admin@gearly.eu',
            'role' => 1,
            'location' => 'Test City'
        ]);

        $this->call([
            BrandSeeder::class,
            CategorySeeder::class,
            FilterCategorySeeder::class,
            FilterSeeder::class,
            FilterFcMappingSeeder::class,
            DeliveryOptionSeeder::class,
            OfferSeeder::class
        ]);
    }
}
