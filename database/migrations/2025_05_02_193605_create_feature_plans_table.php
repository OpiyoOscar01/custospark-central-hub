<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('feature_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feature_id')->constrained('features')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade');
            $table->string('value');
            $table->timestamps();

            $table->unique(['feature_id', 'plan_id']); // prevent duplicates
        });
    }

    public function down()
    {
        Schema::dropIfExists('feature_plans');
    }
};
