@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')

<div class="contact-form__content">
    <div class="contact-form__heading">
        <h2>Contact</h2>
    </div>

    {{-- 送信先は確認画面（POST） --}}
    <form class="form" action="/confirm" method="post">
        @csrf

        {{-- お名前（姓・名に分ける） --}}
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お名前</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text" style="display:flex; gap:.75rem;">
                    <input type="text" name="last_name" placeholder="例: 山田" value="{{ old('last_name') }}" />
                    <input type="text" name="first_name" placeholder="例: 太郎" value="{{ old('first_name') }}" />
                </div>
                <div class="form__error">
                    @error('last_name') {{ $message }} @enderror
                    @error('first_name') {{ $message }} @enderror
                </div>
            </div>
        </div>

        {{-- 性別（デフォルトで男性を選択） --}}
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">性別</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--radio">
                    @php $g = old('gender', 1); @endphp
                    <label><input type="radio" name="gender" value="1" {{ $g == 1 ? 'checked' : '' }}> 男性</label>
                    <label><input type="radio" name="gender" value="2" {{ $g == 2 ? 'checked' : '' }}> 女性</label>
                    <label><input type="radio" name="gender" value="3" {{ $g == 3 ? 'checked' : '' }}> その他</label>
                </div>
                <div class="form__error">
                    @error('gender') {{ $message }} @enderror
                </div>
            </div>
        </div>

        {{-- メールアドレス --}}
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">メールアドレス</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="email" name="email" placeholder="test@example.com" value="{{ old('email') }}" />
                </div>
                <div class="form__error">
                    @error('email') {{ $message }} @enderror
                </div>
            </div>
        </div>

        {{-- 電話番号（3分割：tel1/tel2/tel3） --}}
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">電話番号</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text" style="display:flex; gap:.5rem; align-items:center;">
                    <input type="tel" name="tel1" placeholder="090" value="{{ old('tel1') }}" style="max-width:6rem;">
                    <span>-</span>
                    <input type="tel" name="tel2" placeholder="1234" value="{{ old('tel2') }}" style="max-width:6rem;">
                    <span>-</span>
                    <input type="tel" name="tel3" placeholder="5678" value="{{ old('tel3') }}" style="max-width:6rem;">
                </div>
                <div class="form__error">
                    @error('tel1') {{ $message }} @enderror
                    @error('tel2') {{ $message }} @enderror
                    @error('tel3') {{ $message }} @enderror
                </div>
            </div>
        </div>

        {{-- 住所 --}}
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">住所</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="address" placeholder="例: 東京都渋谷区○○1-2-3" value="{{ old('address') }}" />
                </div>
                <div class="form__error">
                    @error('address') {{ $message }} @enderror
                </div>
            </div>
        </div>

        {{-- 建物名（任意） --}}
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">建物名</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="building" placeholder="例: 千代田マンション101" value="{{ old('building') }}" />
                </div>
                <div class="form__error">
                    @error('building') {{ $message }} @enderror
                </div>
            </div>
        </div>

        {{-- お問い合わせの種類（固定の4択） --}}
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お問い合わせの種類</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--select">
                    <select name="inquiry_type">
                        <option value="" disabled {{ old('inquiry_type') ? '' : 'selected' }}>選択してください</option>
                        <option value="document" {{ old('inquiry_type') === 'document' ? 'selected' : '' }}>商品の交換について</option>
                        <option value="estimate" {{ old('inquiry_type') === 'estimate' ? 'selected' : '' }}>商品トラブル</option>
                        <option value="support" {{ old('inquiry_type') === 'support'  ? 'selected' : '' }}>ショップへのお問い合わせ</option>
                        <option value="other" {{ old('inquiry_type') === 'other'    ? 'selected' : '' }}>その他</option>
                    </select>
                </div>
                <div class="form__error">
                    @error('inquiry_type') {{ $message }} @enderror
                </div>
            </div>
        </div>

        {{-- お問い合わせ内容（120文字まで） --}}
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お問い合わせ内容</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--textarea">
                    <textarea name="content" placeholder="ご要件をご記載ください（120文字以内）">{{ old('content') }}</textarea>
                </div>
                <div class="form__error">
                    @error('content') {{ $message }} @enderror
                </div>
            </div>
        </div>

        {{-- 確認画面へ --}}
        <div class="form__button">
            <button class="form__button-submit" type="submit">確認画面</button>
        </div>
    </form>
</div>
@endsection