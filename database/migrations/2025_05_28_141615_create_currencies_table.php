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
    Schema::create('currencies', function (Blueprint $table) {
        $table->id();
        $table->string('code', 3)->unique(); // e.g. USD
        $table->string('name');              // e.g. US Dollar
        $table->decimal('exchange_rate', 15, 8)->default(1); // relative to USD
        $table->string('symbol')->nullable(); // e.g. $
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
