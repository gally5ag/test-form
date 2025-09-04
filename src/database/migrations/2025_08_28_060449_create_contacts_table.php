<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('last_name');
            $table->string('first_name');
            $table->unsignedTinyInteger('gender'); // 1,2,3
            $table->string('email');
            $table->string('tel')->nullable();     // 今の環境は tel 単体
            $table->string('address');
            $table->string('building')->nullable();

            // ← ここでそのまま列を置く（AFTERは不要）
            $table->enum('inquiry_type', ['document', 'estimate', 'support', 'other']);

            // 管理画面/Seederが使う内容列
            $table->string('detail', 120);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
