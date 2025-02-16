<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DeliveryOption;
use Illuminate\Support\Facades\Storage;

class DeliveryOptionSeeder extends Seeder
{
    public function run(): void
    {
        $deliveryOptions = json_decode(Storage::get('delivery_options.json'), true);

        foreach ($deliveryOptions as $deliveryOption) {
            DeliveryOption::firstOrCreate(
                $deliveryOption
            );
        }
    }
}
