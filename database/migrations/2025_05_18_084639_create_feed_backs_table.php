<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('feedback', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable(true)->constrained()->onDelete('cascade');
            $table->foreignId('app_id')->nullable(true)->constrained()->onDelete('cascade');

            $table->enum('type', [
                'feature_request',
                'complaint',
                'bug_report',
                'general_comment'
            ]);

            $table->text('message');

            $table->json('complaint_categories')->nullable();
            $table->json('attachments')->nullable();

            $table->string('source')->default('web');

            $table->timestamps();
        });
    }

    public function down(): void
    {
         Schema::table('feedback', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['app_id']);
        });
        Schema::dropIfExists('feedback');
    }
};
