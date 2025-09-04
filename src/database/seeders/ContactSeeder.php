<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('ja_JP');
        $types = ['document', 'estimate', 'support', 'other'];

        // テーブルの実際のカラム構成を確認
        $hasTelSplit  = Schema::hasColumn('contacts', 'tel1') && Schema::hasColumn('contacts', 'tel2') && Schema::hasColumn('contacts', 'tel3');
        $hasTelSingle = Schema::hasColumn('contacts', 'tel');
        $hasDetail    = Schema::hasColumn('contacts', 'detail');
        $hasContent   = Schema::hasColumn('contacts', 'content');

        for ($i = 0; $i < 50; $i++) {
            $now    = now();
            $gender = $faker->numberBetween(1, 3);
            $tel1   = $faker->randomElement(['070', '080', '090']);
            $tel2   = str_pad((string)random_int(0, 9999), 4, '0', STR_PAD_LEFT);
            $tel3   = str_pad((string)random_int(0, 9999), 4, '0', STR_PAD_LEFT);

            $row = [
                'last_name'    => $faker->lastName(),
                'first_name'   => $faker->firstName(),
                'gender'       => $gender,               // 1,2,3
                'email'        => $faker->unique()->safeEmail(),
                'address'      => str_replace("\n", ' ', $faker->address()),
                'building'     => $faker->secondaryAddress(),
                'inquiry_type' => $faker->randomElement($types), // 'document' 等
                'created_at'   => $now->copy()->subDays(random_int(0, 60))->subMinutes(random_int(0, 1440)),
                'updated_at'   => $now,
            ];

            // 電話番号カラムに合わせて詰める
            if ($hasTelSplit) {
                $row['tel1'] = $tel1;
                $row['tel2'] = $tel2;
                $row['tel3'] = $tel3;
            } elseif ($hasTelSingle) {
                $row['tel']  = $tel1 . $tel2 . $tel3;
            }

            // 内容カラム（detail / content どちらでも対応）
            $text = $faker->realText(80);
            if ($hasDetail) {
                $row['detail'] = $text;
            } elseif ($hasContent) {
                $row['content'] = $text;
            }

            DB::table('contacts')->insert($row);
        }
    }
}
