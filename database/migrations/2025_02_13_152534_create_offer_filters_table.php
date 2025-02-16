<?php

use App\Models\Filter;
use App\Models\FilterCategory;
use App\Models\Offer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('offer_filters', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Offer::class, 'offer_id')->constrained('offers')->onDelete('cascade');
            $table->foreignIdFor(Filter::class, 'filter_id')->constrained('filters')->onDelete('cascade');
            $table->foreignIdFor(FilterCategory::class, 'filter_category_id')->constrained('filter_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_filters');
    }
};
