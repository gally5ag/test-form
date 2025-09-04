<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'last_name'    => ['required'],
            'first_name'   => ['required'],

            // ラジオの value が 'male','female','other' なので in を追加
            'gender'       => ['required', 'integer', 'in:1,2,3'],

            'email'        => ['required', 'email'],

            // 電話は半角数字のみ・ハイフン無し・最大5桁
            'tel1'         => ['required', 'regex:/^\d{1,5}$/'],
            'tel2'         => ['required', 'regex:/^\d{1,5}$/'],
            'tel3'         => ['required', 'regex:/^\d{1,5}$/'],

            'address'      => ['required'],

            // セレクトの選択肢を固定
            'inquiry_type' => ['required', 'in:document,estimate,support,other'],

            // 120文字以内
            'content'      => ['required', 'max:120'],
        ];
    }

    public function messages()
    {
        return [
            'last_name.required'    => '姓を入力してください',
            'first_name.required'   => '名を入力してください',

            'gender.required'       => '性別を選択してください',
            'gender.in'             => '性別を選択してください',

            'email.required'        => 'メールアドレスを入力してください',
            'email.email'           => 'メールアドレスはメール形式で入力してください',

            'tel1.required'         => '電話番号を入力してください',
            'tel2.required'         => '電話番号を入力してください',
            'tel3.required'         => '電話番号を入力してください',
            'tel1.regex'            => '電話番号は5桁までの数字で入力してください',
            'tel2.regex'            => '電話番号は5桁までの数字で入力してください',
            'tel3.regex'            => '電話番号は5桁までの数字で入力してください',

            'address.required'      => '住所を入力してください',

            'inquiry_type.required' => 'お問い合わせの種類を選択してください',
            'inquiry_type.in'       => 'お問い合わせの種類を選択してください',

            'content.required'      => 'お問い合わせ内容を入力してください',
            'content.max'           => 'お問合せ内容は120文字以内で入力してください',
        ];
    }
}
