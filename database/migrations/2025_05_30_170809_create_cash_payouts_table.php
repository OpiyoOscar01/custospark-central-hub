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
       Schema::create('cash_payouts', function (Blueprint $table) {
    $table->id();

    // The user who is receiving the payout
    $table->foreignId('user_id')->constrained()->onDelete('cascade');

    // Optional: link to the app where the referral happened
    $table->foreignId('app_id')->nullable()->constrained()->nullOnDelete();

    // Optional: link to the specific referral record that triggered the payout
    $table->foreignId('referral_id')->nullable()->constrained()->nullOnDelete();

    // Amount of cash being paid
    $table->decimal('amount', 10, 2);

    // How it is being paid (e.g., Mobile Money, Bank, etc.)
    $table->string('payment_method')->nullable();

    // Where it's being sent (e.g., phone number, account number)
    $table->string('payment_details')->nullable();

    // Optional: who approved the payout
    $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();

    // When payout was completed
    $table->timestamp('paid_at')->nullable();

    // Current status of the payout
    $table->enum('status', ['pending', 'approved', 'paid'])->default('pending');

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_payouts');
    }
};
