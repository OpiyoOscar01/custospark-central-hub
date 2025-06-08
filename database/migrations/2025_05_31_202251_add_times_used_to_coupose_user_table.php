<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('coupon_user', function (Blueprint $table) {
                 $table->integer('times_used')->default(0); // How many times this user has used the coupon
            $table->integer('max_uses_per_user')->nullable(); // Max uses allowed per user, if applicable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupon_user', function (Blueprint $table) {
            $table->dropColumn(['times_used', 'max_uses_per_user']);
        });
    }
};
