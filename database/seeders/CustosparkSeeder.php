<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\App;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CustosparkSeeder extends Seeder
{
    public function run(): void
    {
        // Create the Custospark app
        $app = App::firstOrCreate([
            'slug' => 'custospark',
        ], [
            'name'        => 'Custospark',
            'base_url'    => 'https://custospark.com',
            'icon_url'    => 'https://custospark.com/icon.png',
            'description' => 'An all-in-one platform for business and innovation.',
            'status'      => 'active',
            'tagline'     => 'Empowering innovation.',
            'slug'=> 'custospark',
        ]);

        // Create roles for the app
        $roles = ['admin', 'super-admin', 'normal-user'];

        foreach ($roles as $roleName) {
            Role::firstOrCreate([
                'app_id'     => $app->id,
                'name'       => $roleName,
                'guard_name' => 'web',
            ]);
        }

        // Get the custospark app
        $app = App::where('slug', 'custospark')->firstOrFail();

        // Create the admin user
        $user = User::firstOrCreate([
            'email' => 'opiyooscar414@gmail.com',
        ], [
            'first_name' => 'Oscar',
            'last_name' => 'Opiyo',
            'password' => Hash::make('SuperSecurePass123!'), // use env('ADMIN_PASSWORD') in real apps
            'status' => 'active',
            'email_verified_at' => now(),
            'preferred_currency' => 'USD',
            'country' => 'UG',
            'language' => 'en',
            'last_login_ip' => '127.0.0.1',
            'two_factor_enabled'=> 1,
        ]);

        // Assign the super-admin role for the custospark app
        $user->assignRoleWithApp('super-admin', $app->id);

        $this->command->info("Super Admin user created and assigned to Custospark app.");
    }
}
