<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlanTypeAndTrialDaysToPlansTable extends Migration
{
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->enum('plan_type', ['free', 'trial', 'paid'])->default('paid')->after('price');
            $table->unsignedInteger('trial_days')->nullable()->after('plan_type');
        });
    }

    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['plan_type', 'trial_days']);
        });
    }
}

