<?php

use App\Models\Offer;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignIdFor(User::class, 'rated_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignIdFor(Offer::class, 'offer_id')->nullable()->constrained('offers')->onDelete('set null');
            $table->integer('stars');
            $table->text('comment')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
