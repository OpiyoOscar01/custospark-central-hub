<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subject');
            $table->text('content');
            $table->string('type'); // application_received, interview_scheduled, offer_sent, etc.
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('sent_emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->nullable()->constrained('email_templates');
            $table->morphs('emailable'); // For application, interview, or offer
            $table->string('recipient_email');
            $table->string('subject');
            $table->text('content');
            $table->dateTime('sent_at');
            $table->string('status'); // sent, delivered, opened, clicked, failed
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sent_emails');
        Schema::dropIfExists('email_templates');
    }
};