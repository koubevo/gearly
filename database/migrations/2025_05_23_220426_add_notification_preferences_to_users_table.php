<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('notifications_inactive')->default(true);
            $table->boolean('notifications_new_messages')->default(true);
            $table->boolean('notifications_new_message')->default(true);
            $table->boolean('notifications_closure_reminder')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['notifications_inactive', 'notifications_new_messages', 'notifications_new_message', 'notifications_closure_reminder']);
        });
    }
};
