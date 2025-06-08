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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('app_id')->constrained()->onDelete('cascade'); // app-scoped

            $table->string('code')->unique(); // e.g. SAVE20
            $table->enum('type', ['percentage', 'fixed', 'free_trial', 'custom']);
            $table->decimal('value', 10, 2)->nullable(); // e.g. 20% or $20 or null for free_trial

            $table->unsignedInteger('max_uses')->nullable(); // total uses across system
            $table->unsignedInteger('max_uses_per_user')->nullable(); // per user limit

            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            $table->boolean('active')->default(true); // toggled on/off

            $table->boolean('created_by_admin')->default(false); // true if system-generated
            $table->foreignId('creator_id')->nullable()->constrained('users')->nullOnDelete(); // who created the coupon

            $table->text('description')->nullable(); // for backend/admin clarity
            $table->json('conditions')->nullable(); // e.g., min_order_amount, applicable_plans, etc.
            $table->json('metadata')->nullable(); // any other dynamic or future fields

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
