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
    {  Schema::create('invoices', function (Blueprint $table) {
        $table->id();
        $table->foreignId('subscription_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->decimal('amount', 10, 2);
        $table->enum('status', ['paid', 'unpaid', 'failed']);
        $table->timestamp('issued_at');
        $table->timestamp('due_at');
        $table->foreignUuid('payment_id')->nullable()->constrained()->onDelete('set null');
        $table->string('pdf_url')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
