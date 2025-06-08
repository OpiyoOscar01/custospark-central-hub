<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_risks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->enum('probability', ['low', 'medium', 'high']);
            $table->enum('impact', ['low', 'medium', 'high']);
            $table->enum('status', ['identified', 'analyzing', 'mitigating', 'resolved', 'occurred']);
            $table->text('mitigation_strategy')->nullable();
            $table->text('contingency_plan')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users');
            $table->date('identified_date');
            $table->date('target_resolution_date')->nullable();
            $table->date('actual_resolution_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_risks');
    }
};