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
    {   Schema::create('plans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('app_id')->constrained('apps')->onDelete('cascade');
        $table->string('name');
        $table->string('slug');
        $table->decimal('price', 10, 2);
        $table->enum('billing_cycle', ['monthly', 'yearly']);
        $table->text('description')->nullable();
        $table->boolean('is_popular')->default(false);
        $table->timestamps();

        $table->unique(['app_id', 'slug']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
