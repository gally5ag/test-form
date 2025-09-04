<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FashionablyLate</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

</head>

<body>
    {{-- 画面上部にサマリ（任意） --}}
    @if ($errors->any())
    <div class="form__error form__error--summary">
        入力内容に誤りがあります。各項目のエラーメッセージをご確認ください
    </div>
    @endif
    <div class="register-form__content">
        <div class="hero">
            <div class="hero__inner">
                <h1 class="hero__brand">FashionablyLate</h1>
                <a class="hero__login" href="/register">register</a>
            </div>
        </div>
        <div class="login-form__content">
            <div class="login-form__heading">
                <h2>login</h2>
            </div>
            <form class="form" method="POST" action="{{ route('login.attempt') }}">
                @csrf
                @csrf
                <div class="form__group">
                    <div class="form__group-title">
                        <span class="form__label--item">メールアドレス</span>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="email" name="email" value="{{ old('email') }}" />
                        </div>
                        <div class="form__error">
                            @error('email')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__group-title">
                        <span class="form__label--item">パスワード</span>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="password" name="password" />
                        </div>
                        <div class="form__error">
                            @error('password')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form__button">
                    <button class="form__button-submit" type="submit">ログイン</button>
                </div>
            </form>

        </div>
    </div>
</body>