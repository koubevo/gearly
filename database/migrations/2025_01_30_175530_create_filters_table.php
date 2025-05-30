<?php

use App\Models\FilterCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('filters', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(FilterCategory::class, 'filter_category_id')->constrained('filter_categories')->onDelete('cascade');
            $table->string('name');
            $table->string('cs');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('filters');
    }
};
