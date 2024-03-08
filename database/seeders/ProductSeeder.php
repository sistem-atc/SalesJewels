<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            'name' => 'Brinco Rosa',
            'ean' => '6546546798731',
            'image' => '["01HPZF8E1ST3N07FHZH6YBKZ30.jpg","01HPZF8E259MZ9J594A2PET25F.jpg","01HPZF8E2AE022YNCWNR9XA8AC.jpg"]',
            'type_product_id' => 2
        ]);

        DB::table('products')->insert([
            'name' => 'Anel de Coração',
            'ean' => '3213456498798',
            'image' => '["01HPZF9QWXDEMCDSSVNE5S596V.jpg","01HPZF9QX5B3SG84J0RPDPEH4S.jpg","01HPZF9QXB0HNG4AYXCBFXKKWE.jpg","01HPZF9QXG41ASR4G8GQ92GYGE.jpg","01HPZF9QXP7BN1S4X2MC0S8DNW.jpg","01HPZF9QXWS8A0H40QHKHTBGFF.jpg"]',
            'type_product_id' => 1
        ]);

        DB::table('products')->insert([
            'name' => 'Produto de Teste',
            'ean' => '956595651325',
            'image' => '',
            'type_product_id' => 3
        ]);

    }
}
