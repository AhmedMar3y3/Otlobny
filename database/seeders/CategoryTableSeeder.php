<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        DB::table('categories')->insert([
            [
                'name'                            => 'مطاعم',
                'image'                           => '/images/category/restaurant.jpeg',
                'created_at'                      => $now,
                'updated_at'                      => $now,
            ], [
                'name'                            => 'كافيهات',
                'image'                           => '/images/category/cafes.jpeg',
                'created_at'                      => $now,
                'updated_at'                      => $now,
            ],[
                'name'                            => 'سوبر ماركت',
                'image'                           => '/images/category/supermarket.jpeg',
                'created_at'                      => $now,
                'updated_at'                      => $now,
            ], [
                'name'                            => 'صيدليات',
                'image'                           => '/images/category/pharmacy.jpeg',
                'created_at'                      => $now,
                'updated_at'                      => $now,
            ],
        ]);
    }
}
