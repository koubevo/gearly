<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Filter;
use Illuminate\Support\Facades\Storage;

class FilterSeeder extends Seeder
{
    public function run(): void
    {
        $filters = json_decode(Storage::get('filters.json'), true);

        foreach ($filters as $filter) {
            Filter::firstOrCreate(
                $filter
            );
        }
    }
}
