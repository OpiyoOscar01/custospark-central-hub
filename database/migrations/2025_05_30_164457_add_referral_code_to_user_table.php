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
        Schema::table('users', function (Blueprint $table) {
            $table->string('referral_code')->nullable()->after('email'); // Add referral_code column
            $table->string('referral_source')->nullable()->after('referral_code'); // Add referral_source column
            $table->string('referral_medium')->nullable()->after('referral_source'); // Add referral_medium column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['referral_code', 'referral_source', 'referral_medium']); // Remove added columns
        });
    }
};
