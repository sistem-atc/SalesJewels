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
        ]);

        DB::table('type_products')->insert([
            'name' => 'Brinco',
        ]);

        DB::table('type_products')->insert([
            'name' => 'Corrente',
        ]);
    }
}
