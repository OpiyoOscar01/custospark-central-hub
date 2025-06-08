<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('time_logs', function (Blueprint $table) {
            $table->boolean('is_billable')->default(true);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->integer('break_duration')->nullable(); // in minutes
            $table->decimal('rate', 10, 2)->default(0);
            $table->string('rejection_reason')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('time_logs', function (Blueprint $table) {
            $table->dropColumn([
                'is_billable',
                'status',
                'approved_by',
                'approved_at',
                'start_time',
                'end_time',
                'break_duration',
                'rate',
                'rejection_reason'
            ]);
        });
    }
};