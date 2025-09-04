<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FashionablyLate</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">

</head>

<body>
    <div class="register-form__content">
        <<div class="hero">
            <div class="hero__inner">
                <h1 class="hero__brand">FashionablyLate</h1>
                <a class="hero__login" href="{{ route('login') }}">login</a>
            </div>
    </div>

    <div class="page-title"><a class="login__button-submit">register</a>
    </div>
    <form class="form" action="{{ route('register') }}" method="POST">
        @csrf
        <!-- お名前 -->
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お名前</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="name" value="{{ old('name') }}">
                </div>
                <div class="form__error">@error('name'){{ $message }}@enderror</div>
            </div>
        </div>

        <!-- メール -->
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">メールアドレス</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="email" name="email" value="{{ old('email') }}">
                </div>
                <div class="form__error">@error('email'){{ $message }}@enderror</div>
            </div>
        </div>

        <!-- パスワード -->
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">パスワード</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="password" name="password">
                </div>
                <div class="form__error">@error('password'){{ $message }}@enderror</div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">パスワード（確認）</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="password" name="password_confirmation">
                    </div>
                </div>
            </div>

            <div class="form__button">
                <button class="form__button-submit" type="submit">登録</button>
            </div>
    </form>


    </div>
</body>

</html>