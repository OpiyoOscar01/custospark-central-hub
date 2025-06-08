<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->tinyInteger('rating')->unsigned()->nullable()->after('attachments');
            $table->enum('status', [
                'pending',       // Default after submission
                'triaged',       // Categorized & prioritized
                'in_progress',   // Being worked on
                'resolved',      // Work completed
                'responded',     // Admin replied to user
                'closed',        // Finalized and archived
                'rejected'       // Invalid or out of scope
            ])->default('pending')->after('rating');


            $table->text('admin_response')->nullable()->after('status');

            $table->timestamp('responded_at')->nullable()->after('admin_response');

            $table->foreignId('admin_id')
                  ->nullable()
                  ->constrained('users') // or use 'admins' if you have a separate admins table
                  ->nullOnDelete()
                  ->after('responded_at');
        });
    }

    public function down(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->dropColumn([
                'rating',
                'status',
                'admin_response',
                'responded_at',
            ]);

            // If using foreign key constraint
            $table->dropForeign(['admin_id']);
            $table->dropColumn('admin_id');
        });
    }
};
