<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FilterCategory;
use Illuminate\Support\Facades\Storage;

class FilterCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = json_decode(Storage::get('filter_categories.json'), true);

        foreach ($categories as $category) {
            FilterCategory::firstOrCreate(
                ['name' => $category]
            );
        }
    }
}
