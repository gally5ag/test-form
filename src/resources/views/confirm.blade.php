@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}" />
@endsection

@section('content')

<div class="confirm__content">
    <div class="confirm__heading">
        <h2>Confirm</h2>
    </div>

    {{-- 本送信用：/contacts に POST --}}
    <form class="form" action="/confirm" method="post">
        @csrf

        {{-- 送信用の hidden（保存に必要なキーをすべて持たせる） --}}
        <input type="hidden" name="last_name" value="{{ $contact['last_name'] ?? '' }}">
        <input type="hidden" name="first_name" value="{{ $contact['first_name'] ?? '' }}">
        <input type="hidden" name="gender" value="{{ $contact['gender'] ?? '' }}">
        <input type="hidden" name="email" value="{{ $contact['email'] ?? '' }}">
        <input type="hidden" name="tel1" value="{{ $contact['tel1'] ?? '' }}">
        <input type="hidden" name="tel2" value="{{ $contact['tel2'] ?? '' }}">
        <input type="hidden" name="tel3" value="{{ $contact['tel3'] ?? '' }}">
        <input type="hidden" name="address" value="{{ $contact['address'] ?? '' }}">
        <input type="hidden" name="building" value="{{ $contact['building'] ?? '' }}">
        <input type="hidden" name="inquiry_type" value="{{ $contact['inquiry_type'] ?? '' }}">
        <input type="hidden" name="content" value="{{ $contact['content'] ?? '' }}">

        @php
        // 表示用の整形
        $fullName = trim(($contact['last_name'] ?? '').'　'.($contact['first_name'] ?? '')); // 全角スペース
        $genderText = match((string)($contact['gender'] ?? '')) {
        '1' => '男性',
        '2' => '女性',
        '3' => 'その他',
        default => '未選択',
        };
        $telJoined = trim(($contact['tel1'] ?? '').($contact['tel2'] ?? '').($contact['tel3'] ?? ''));
        $inquiryMap = [
        'document' => '資料請求',
        'estimate' => 'お見積り',
        'support' => 'サポート',
        'other' => 'その他',
        ];
        $inquiryText = $inquiryMap[$contact['inquiry_type'] ?? ''] ?? '未選択';
        @endphp

        <div class="confirm-table">
            <table class="confirm-table__inner">
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お名前</th>
                    <td class="confirm-table__text">
                        <input type="text" value="{{ $fullName }}" readonly />
                    </td>
                </tr>

                <tr class="confirm-table__row">
                    <th class="confirm-table__header">性別</th>
                    <td class="confirm-table__text">
                        <input type="text" value="{{ $genderText }}" readonly />
                    </td>
                </tr>

                <tr class="confirm-table__row">
                    <th class="confirm-table__header">メールアドレス</th>
                    <td class="confirm-table__text">
                        <input type="email" value="{{ $contact['email'] ?? '' }}" readonly />
                    </td>
                </tr>

                <tr class="confirm-table__row">
                    <th class="confirm-table__header">電話番号</th>
                    <td class="confirm-table__text">
                        <input type="tel" value="{{ $telJoined }}" readonly />
                    </td>
                </tr>

                <tr class="confirm-table__row">
                    <th class="confirm-table__header">住所</th>
                    <td class="confirm-table__text">
                        <input type="text" value="{{ $contact['address'] ?? '' }}" readonly />
                    </td>
                </tr>

                <tr class="confirm-table__row">
                    <th class="confirm-table__header">建物名</th>
                    <td class="confirm-table__text">
                        <input type="text" value="{{ $contact['building'] ?? '' }}" readonly />
                    </td>
                </tr>

                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お問い合わせの種類</th>
                    <td class="confirm-table__text">
                        <input type="text" value="{{ $inquiryText }}" readonly />
                    </td>
                </tr>

                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お問い合わせ内容</th>
                    <td class="confirm-table__text">
                        {{-- 表示は1行 input のままに合わせるが、長文に備えて textarea でもOK --}}
                        <input type="text" value="{{ $contact['content'] ?? '' }}" readonly />
                    </td>
                </tr>
            </table>
        </div>

        <div class="form__button" style="display:flex; gap:.75rem; justify-content:center;">
            {{-- 送信（保存してサンクスへ） --}}
            <button class="form__button-submit" type="submit" name="_send" value="1">送信</button>

            {{-- 修正：値を保持してフォームへ戻す（コントローラで _back を検知して back()->withInput()） --}}
            <button class="form__button-submit"
                type="submit"
                formaction="/confirm"
                formmethod="post"
                name="_back" value="1">
                修正
            </button>
        </div>
    </form>
</div>
@endsection