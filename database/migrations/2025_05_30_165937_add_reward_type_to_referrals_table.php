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
        Schema::table('referrals', function (Blueprint $table) {
            $table->enum('reward_type', ['coupon', 'cash'])->default('coupon')->after('status');
            $table->boolean('rewarded')->default(false)->after('reward_type'); // Optional but useful
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('referrals', function (Blueprint $table) {
            $table->dropColumn(['reward_type', 'rewarded']); // Remove added columns
        });
    }
};
