<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_skills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category'); // technical, soft, language, etc.
            $table->timestamps();
        });

        Schema::create('job_required_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_job_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained('job_skills')->onDelete('cascade');
            $table->enum('level', ['beginner', 'intermediate', 'expert']);
            $table->boolean('is_required')->default(true);
            $table->timestamps();
        });

        Schema::create('applicant_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained('job_skills')->onDelete('cascade');
            $table->enum('level', ['beginner', 'intermediate', 'expert']);
            $table->text('description')->nullable();
            $table->integer('years_experience');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applicant_skills');
        Schema::dropIfExists('job_required_skills');
        Schema::dropIfExists('job_skills');
    }
};