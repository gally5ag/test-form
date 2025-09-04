<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $param = ['name' => '商品のお届けについて', 'created_at' => $now, 'updated_at' => $now];
        DB::table('categories')->insert($param);

        $param = ['name' => '商品の交換について', 'created_at' => $now, 'updated_at' => $now];
        DB::table('categories')->insert($param);

        $param = ['name' => '商品トラブル', 'created_at' => $now, 'updated_at' => $now];
        DB::table('categories')->insert($param);

        $param = ['name' => 'ショップへのお問い合わせ', 'created_at' => $now, 'updated_at' => $now];
        DB::table('categories')->insert($param);

        $param = ['name' => 'その他', 'created_at' => $now, 'updated_at' => $now];
        DB::table('categories')->insert($param);
    }
}
