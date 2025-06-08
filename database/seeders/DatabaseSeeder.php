<?php

namespace Database\Seeders;
use App\Models\Notification;
use Illuminate\Support\Carbon;

use App\Models\User;
use App\Models\Role; // Ensure to import the custom Role model
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
{
    $this->call([
        CurrencySeeder::class,
        CustosparkSeeder::class, // Call your new seeder
    ]);
}

       
}



}

