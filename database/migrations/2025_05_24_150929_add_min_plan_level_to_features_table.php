<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up()
        {
            Schema::table('features', function (Blueprint $table) {
                $table->unsignedTinyInteger('min_plan_level')->default(1)->after('code');
            });
        }

        public function down()
        {
            Schema::table('features', function (Blueprint $table) {
                $table->dropColumn('min_plan_level');
            });
        }

};
