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
     Schema::table('subscriptions', function (Blueprint $table) {
            $table->enum('next_plan_payment_status', ['paid', 'pending'])->nullable()->after('next_plan_id');
            $table->uuid('next_plan_payment_id')->nullable()->after('next_plan_payment_status');

            $table->foreign('next_plan_payment_id')
                ->references('id')
             ->on('payments')
             ->onDelete('set null');
     });
    }

 /**
  * Reverse the migrations.
  */
 public function down(): void
 {
     Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['next_plan_payment_id']);
            $table->dropColumn('next_plan_payment_id');
            $table->dropColumn('next_plan_payment_status');
     });
 }
};
