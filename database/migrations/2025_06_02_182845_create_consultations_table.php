<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationsTable extends Migration
{
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id')->nullable(); // Assigned person
        $table->string('full_name');
        $table->string('email');
        $table->string('country_code')->nullable();
        $table->string('custom_country_code')->nullable();
        $table->string('phone');
        $table->enum('status', ['pending', 'scheduled', 'completed', 'cancelled'])->default('pending');
        $table->string('timezone');
        $table->date('preferred_date')->nullable();
        $table->time('preferred_start')->nullable();
        $table->time(column: 'preferred_end')->nullable();
        $table->enum('meeting_type', ['video', 'phone', 'in_person']);
        $table->string('organization')->nullable();
        $table->text('message')->nullable();
        $table->timestamps();

        // Add foreign key constraint
        $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
    });

    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
}
