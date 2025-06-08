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
        Schema::table('cash_payouts', function (Blueprint $table) {
            $table->string('currency', 3)->default('USD')->after('amount'); // Adding currency column with default USD
            $table->index('currency'); // Indexing currency for faster queries
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cash_payouts', function (Blueprint $table) {
            $table->dropIndex(['currency']); // Dropping index on currency
            $table->dropColumn('currency'); // Dropping the currency column
        });
    }
};
