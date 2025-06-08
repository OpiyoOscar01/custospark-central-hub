<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('apps')->insert([
            [
                'name' => 'CustoSpark',
                'slug' => 'custospark',
                'base_url' => 'http://custospark.test:8000',
                'icon_url' => 'https://cdn.example.com/icons/spark.png',
                'description' => 'Core platform and admin dashboard.',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'CustoSpace',
                'slug' => 'custospace',
                'base_url' => 'http://custospace.custospark.test:8001',
                'icon_url' => 'https://cdn.example.com/icons/space.png',
                'description' => 'Collaboration and workspace management.',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'CustoHost',
                'slug' => 'custohost',
                'base_url' => 'http://custohost.custospark.test:8002',
                'icon_url' => 'https://cdn.example.com/icons/host.png',
                'description' => 'Hosting and infrastructure tools.',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'CustoSell',
                'slug' => 'custosell',
                'base_url' => 'http://custosell.custospark.test:8003',
                'icon_url' => 'https://cdn.example.com/icons/sell.png',
                'description' => 'E-commerce and sales solutions.',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
