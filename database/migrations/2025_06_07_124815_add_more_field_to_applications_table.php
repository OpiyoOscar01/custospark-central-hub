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
        Schema::table('job_applications', function (Blueprint $table) {
            $table->string('current_role')->nullable()->after('additional_information');
            $table->decimal('current_salary', 10, 2)->nullable()->after('current_role');
            $table->string('current_salary_currency')->default('USD')->after('current_salary');
            $table->string('years_of_experience')->nullable()->after('current_salary');
            $table->string('notice_period')->nullable()->after('years_of_experience');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropColumn(['current_role', 'current_salary', 'years_of_experience', 'notice_period', 'current_salary_currency']);
        });
    }
};
