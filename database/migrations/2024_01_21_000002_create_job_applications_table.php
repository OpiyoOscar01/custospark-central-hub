<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_job_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('resume_path');
            $table->string('cover_letter_path')->nullable();
            $table->text('additional_information')->nullable();
            $table->enum('status', [
                'pending',
                'reviewing',
                'shortlisted',
                'interview_scheduled',
                'interviewed',
                'offered',
                'hired',
                'rejected'
            ])->default('pending');
            $table->text('internal_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};