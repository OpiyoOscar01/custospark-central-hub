<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('job_applications')->onDelete('cascade');
            $table->decimal('salary_offered', 10, 2);
            $table->string('salary_currency')->default('USD');
            $table->date('start_date');
            $table->text('additional_benefits')->nullable();
            $table->text('special_terms')->nullable();
            $table->enum('status', ['draft', 'sent', 'accepted', 'negotiating', 'declined'])->default('draft');
            $table->dateTime('sent_at')->nullable();
            $table->dateTime('response_at')->nullable();
            $table->text('candidate_feedback')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_offers');
    }
};