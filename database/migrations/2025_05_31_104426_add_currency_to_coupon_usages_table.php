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
        Schema::table('coupon_usages', function (Blueprint $table) {
            // Add currency column to coupon_usages table
            $table->string('currency', 3)->default('USD')->after('discount_amount')
                ->comment('Currency code for the discount amount, e.g., USD, EUR');
            $table->unsignedInteger('times_used')->default(0)->after('currency')
                ->comment('Number of times this coupon has been used by the user');
            $table->timestamp('last_used_at')->nullable()->after('times_used')
                ->comment('Timestamp of the last time this coupon was used by the user');
            
            // Optionally, you can add an index for faster lookups if needed
            $table->index('currency', 'idx_coupon_usages_currency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupon_usages', function (Blueprint $table) {
            // Remove the columns added in the up method
            $table->dropColumn(['currency', 'times_used', 'last_used_at']);
            
            // Drop the index if it exists
            $table->dropIndex('idx_coupon_usages_currency');
            
        });
    }
};
