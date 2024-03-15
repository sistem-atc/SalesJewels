<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TypeProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('type_products')->insert([
            'name' => 'Anel',
            'user_id' => 1,
        ]);

        DB::table('type_products')->insert([
            'name' => 'Brinco',
            'user_id' => 1,
        ]);

        DB::table('type_products')->insert([
            'name' => 'Corrente',
            'user_id' => 1,
        ]);
    }
}
