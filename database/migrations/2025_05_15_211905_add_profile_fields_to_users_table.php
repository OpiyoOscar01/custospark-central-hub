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
        Schema::table('users', function (Blueprint $table) {
            // $table->dropColumn('name');

            //More user Information
            $table->string('first_name');
            $table->string('last_name');
            $table->string('profile_url')->nullable();
            // User status and roles
            $table->enum('status', ['pending', 'active', 'inactive', 'suspended', 'banned'])->default('pending')->after('remember_token');

            // Login tracking
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable()->after('last_login_at');
            $table->timestamp('password_changed_at')->nullable()->after('last_login_ip');

            // Profile info
            $table->string('avatar_url')->nullable()->after('password_changed_at');
            $table->enum('sex', ['male', 'female', 'other'])->nullable()->after('avatar_url');
            $table->date('date_of_birth')->nullable()->after('sex');
            $table->string('phone')->nullable()->after('date_of_birth');

            // Location & language
            $table->string('country')->nullable()->after('phone');
            $table->string('state')->nullable()->after('country');
            $table->string('city')->nullable()->after('state');
            $table->string('postal_code')->nullable()->after('city');
            $table->string('address')->nullable()->after('postal_code');
            $table->string('timezone')->nullable()->after('address');
            $table->string('language')->nullable()->after('timezone');

            // Optional personal fields
            $table->text('bio')->nullable()->after('language');
            $table->string('website')->nullable()->after('bio');

            // OAuth / Social login identifiers
            $table->string('google_id')->nullable()->unique()->after('website');
            $table->string('facebook_id')->nullable()->unique()->after('google_id');
            $table->string('twitter_id')->nullable()->unique()->after('facebook_id');

            // Security / 2FA
            $table->boolean('two_factor_enabled')->default(true)->after('twitter_id');
            $table->string('two_factor_secret')->nullable()->after('two_factor_enabled');

            // Marketing preferences
            $table->boolean('newsletter_opt_in')->default(false);
            $table->boolean('marketing_opt_in')->default(false)->after('newsletter_opt_in');

            // Auditing
            $table->unsignedBigInteger('created_by')->nullable()->after('marketing_opt_in')->comment('Admin user who created this user');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('Admin who last updated this user');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('Admin who deleted this user');
            $table->unsignedBigInteger('approved_by')->nullable()->comment('Admin who approved this user');

            // Foreign keys
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
            $table->dropForeign(['approved_by']);

            // Drop columns added in up()
            $table->dropColumn([
                'status', 'first_name','last_name','profile_url', 'last_login_at', 'last_login_ip', 'password_changed_at', 'avatar_url',
                'sex', 'date_of_birth', 'phone', 'country', 'state', 'city', 'postal_code', 'address', 'timezone',
                'language', 'bio', 'website', 'google_id', 'facebook_id', 'twitter_id',
                'two_factor_enabled', 'two_factor_secret', 'subscription_plan', 'subscription_ends_at',
                'newsletter_opt_in', 'marketing_opt_in', 'created_by',
            ]);
        });
    }
};
