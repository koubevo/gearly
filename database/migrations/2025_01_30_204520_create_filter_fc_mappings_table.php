<?php

use App\Models\Category;
use App\Models\FilterCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('filter_fc_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class, 'category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignIdFor(FilterCategory::class, 'filter_category_id')->constrained('filter_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filter_fc_mappings');
    }
};
