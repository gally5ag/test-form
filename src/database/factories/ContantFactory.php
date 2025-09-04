<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    public function definition(): array
    {
        // gender は DB 仕様 (1:男性 2:女性 3:その他)
        $gender = $this->faker->randomElement([1, 2, 3]);

        // 電話は半角数字・ハイフン無し（10〜11桁）
        $tel = $this->faker->numerify('0#########'); // 10桁
        if ($this->faker->boolean()) {
            $tel = $this->faker->numerify('0##########'); // 11桁になることも
        }

        return [
            'last_name'   => $this->faker->lastName(),
            'first_name'  => $this->faker->firstName(),
            'gender'      => $gender,
            'email'       => $this->faker->unique()->safeEmail(),
            'tel'         => $tel,
            'address'     => $this->faker->address(),
            'building'    => $this->faker->optional()->secondaryAddress(),
            'detail'      => $this->faker->realText(100), // 120字想定なら 100〜120 でOK
            // 既存カテゴリからランダム紐付け
            'category_id' => Category::inRandomOrder()->value('id') ?? Category::factory(),
        ];
    }
}
