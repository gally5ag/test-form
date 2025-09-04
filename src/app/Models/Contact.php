<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'last_name',
        'first_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'detail',
        'category_id',
    ];

    protected $casts = [
        'gender' => 'integer',
        'category_id' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 表示用の便利アクセサ（任意）
    public function getFullNameAttribute(): string
    {
        return trim("{$this->last_name} {$this->first_name}");
    }

    public function getGenderLabelAttribute(): string
    {
        return [1 => '男性', 2 => '女性', 3 => 'その他'][$this->gender] ?? '';
    }
}
