<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Offer;
use Illuminate\Support\Facades\Storage;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offers = json_decode(Storage::get('offers.json'), true);

        foreach ($offers as $offer) {
            Offer::firstOrCreate(
                $offer
            );
        }
    }
}
