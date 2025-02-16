<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\DeliveryOption;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->string('currency');
            $table->string('condition');
            $table->integer('sport_id');
            $table->foreignIdFor(DeliveryOption::class, 'delivery_option_id')->constrained('delivery_options');
            $table->string('delivery_description')->nullable();
            $table->foreignIdFor(Category::class, 'category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignIdFor(Brand::class, 'brand_id')->constrained('brands')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
