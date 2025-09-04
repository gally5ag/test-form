<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,   // ← 追加
            ContactSeeder::class,    // ← まだ無ければ後で作る
        ]);
    }
}
