<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = json_decode(Storage::get('categories.json'), true);

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                ['cs' => $category['cs'], 'logo' => $category['logo']]
            );
        }
    }
}
