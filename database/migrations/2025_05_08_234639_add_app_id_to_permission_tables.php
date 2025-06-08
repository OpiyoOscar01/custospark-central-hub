<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAppIdToPermissionTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tableNames = config('permission.table_names');

        // Add app_id to roles
        if (!Schema::hasColumn($tableNames['roles'], 'app_id')) {
            Schema::table($tableNames['roles'], function (Blueprint $table) {
                $table->unsignedBigInteger('app_id')->default(1)->after('id');
                $table->index('app_id');
            });
        }

        // Add app_id to permissions
        if (!Schema::hasColumn($tableNames['permissions'], 'app_id')) {
            Schema::table($tableNames['permissions'], function (Blueprint $table) {
                $table->unsignedBigInteger('app_id')->default(1)->after('id');
                $table->index('app_id');
            });
        }

        // Add app_id to role_has_permissions
        if (!Schema::hasColumn($tableNames['role_has_permissions'], 'app_id')) {
            Schema::table($tableNames['role_has_permissions'], function (Blueprint $table) {
                $table->unsignedBigInteger('app_id')->default(1)->after('role_id');
                $table->index('app_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableNames = config('permission.table_names');

        if (Schema::hasColumn($tableNames['roles'], 'app_id')) {
            Schema::table($tableNames['roles'], function (Blueprint $table) {
                $table->dropIndex([$tableNames['roles'] . '_app_id_index']);
                $table->dropColumn('app_id');
            });
        }

        if (Schema::hasColumn($tableNames['permissions'], 'app_id')) {
            Schema::table($tableNames['permissions'], function (Blueprint $table) {
                $table->dropIndex([$tableNames['permissions'] . '_app_id_index']);
                $table->dropColumn('app_id');
            });
        }

        if (Schema::hasColumn($tableNames['role_has_permissions'], 'app_id')) {
            Schema::table($tableNames['role_has_permissions'], function (Blueprint $table) {
                $table->dropIndex([$tableNames['role_has_permissions'] . '_app_id_index']);
                $table->dropColumn('app_id');
            });
        }
    }
}
