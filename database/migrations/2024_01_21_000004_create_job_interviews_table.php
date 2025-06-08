<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_interviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('job_applications')->onDelete('cascade');
            $table->foreignId('interviewer_id')->constrained('users');
            $table->dateTime('scheduled_at');
            $table->string('type'); // phone, video, in-person
            $table->string('location')->nullable(); // URL for video or physical location
            $table->string('status')->default('scheduled'); // scheduled, completed, cancelled, rescheduled
            $table->text('notes')->nullable();
            $table->text('feedback')->nullable();
            $table->integer('rating')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('interview_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('description')->nullable();
            $table->string('category'); // technical, behavioral, etc.
            $table->timestamps();
        });

        Schema::create('interview_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('interview_id')->constrained('job_interviews')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('interview_questions')->onDelete('cascade');
            $table->text('response')->nullable();
            $table->integer('rating')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interview_responses');
        Schema::dropIfExists('interview_questions');
        Schema::dropIfExists('job_interviews');
    }
};