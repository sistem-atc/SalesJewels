<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customers')->insert([
            'name' => 'Kaua',
            'user_id' => 1,
        ]);

        DB::table('customers')->insert([
            'name' => 'Kleber',
            'cpf' => '309.081.058-19',
            'user_id' => 1,
        ]);

        DB::table('customers')->insert([
            'name' => 'Gustavo',
            'user_id' => 1,
        ]);
    }
}
