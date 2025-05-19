<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'delivery_price_per_km',
                'value' => 10,
            ],
        ];

        DB::table('settings')->insert($settings);
    }
}
