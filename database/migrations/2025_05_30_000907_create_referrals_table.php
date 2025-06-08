<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('referrer_id')->constrained('users')->onDelete('cascade');       // User who referred
            $table->foreignId('referred_user_id')->constrained('users')->onDelete('cascade');   // User who was referred
            $table->foreignId('app_id')->constrained('apps')->onDelete('cascade');              // App-scoped

            $table->string('referral_url')->nullable();              // Code used by the referred user
            $table->enum('status', ['pending', 'converted', 'rewarded'])->default('pending'); // Referral status
            $table->timestamp('rewarded_at')->nullable();             // When referrer was rewarded

            $table->decimal('earned_amount', 10, 2)->default(0);      // Amount earned (optional monetary incentive)
            $table->string('source')->nullable();                     // e.g., whatsapp, email, direct_link
            $table->string('medium')->nullable();                     // e.g., organic, campaign, paid

            $table->timestamps();

            $table->unique(['referrer_id', 'referred_user_id', 'app_id']); // Prevent duplicate referral records per app
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
