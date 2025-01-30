<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;
use Illuminate\Support\Facades\Storage;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = json_decode(Storage::get('brands.json'), true);

        foreach ($brands as $brand) {
            Brand::firstOrCreate(
                ['name' => $brand],
                ['logo' => 'default-logo.png']
            );
        }
    }
}
