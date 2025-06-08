<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('time_logs', function (Blueprint $table) {
            $table->decimal('actual_hours_worked', 8, 2)->default(0)->after('hours_worked');
        });
    }

    public function down()
    {
        Schema::table('time_logs', function (Blueprint $table) {
            $table->dropColumn('actual_hours_worked');
        });
    }
};

