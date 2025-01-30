<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FilterCategory;
use Illuminate\Support\Facades\Storage;

class FilterFcMappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mappings = json_decode(Storage::get('filter_fc_mappings.json'), true);

        foreach ($mappings as $mapping) {
            FilterCategory::firstOrCreate(
                $mapping
            );
        }
    }
}
