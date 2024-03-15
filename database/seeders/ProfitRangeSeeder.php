<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProfitRangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('profit_ranges')->insert([
            'rangeinitial' => 0,
            'rangefinal' => 2000.0,
            'percent' => 30.0,
            'user_id' => 1,
        ]);

        DB::table('profit_ranges')->insert([
            'rangeinitial' => 2000.01,
            'rangefinal' => 3000.0,
            'percent' => 35.0,
            'user_id' => 1,
        ]);

        DB::table('profit_ranges')->insert([
            'rangeinitial' => 3000.01,
            'rangefinal' => 50000.0,
            'percent' => 40.0,
            'user_id' => 1,
        ]);
    }
}
