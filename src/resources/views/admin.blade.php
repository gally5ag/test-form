<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FashionablyLate</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

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
            <h1 class="hero__brand">FashionablyLate</h1>
            <a class="hero__login" href="{{ route('login') }}">logout</a>
        </div>
        <h2 class="hero__brand">Admin</h2>
        {{-- 検索フォーム（GET） --}}
        <form class="admin__search" action="/admin" method="get">
            <input class="i" type="text" name="keyword" value="{{ request('keyword') }}"
                placeholder="名前やメールアドレスを入力してください">
            <label class="chk"><input type="checkbox" name="exact" value="1" {{ request('exact') ? 'checked' : '' }}> 完全一致</label>

            <select class="i" name="gender">
                <option value="">性別</option>
                <option value="all" {{ request('gender')==='all'  ? 'selected':'' }}>全て</option>
                <option value="1" {{ request('gender')==='1'    ? 'selected':'' }}>男性</option>
                <option value="2" {{ request('gender')==='2'    ? 'selected':'' }}>女性</option>
                <option value="3" {{ request('gender')==='3'    ? 'selected':'' }}>その他</option>
            </select>

            <select class="i" name="inquiry_type">
                <option value="">お問い合わせの種類</option>
                <option value="document" {{ request('inquiry_type')==='document' ? 'selected':'' }}>商品の交換について</option>
                <option value="estimate" {{ request('inquiry_type')==='estimate' ? 'selected':'' }}>商品トラブル</option>
                <option value="support" {{ request('inquiry_type')==='support'  ? 'selected':'' }}>ショップへのお問い合わせ</option>
                <option value="other" {{ request('inquiry_type')==='other'    ? 'selected':'' }}>その他</option>
            </select>

            <input class="i" type="date" name="date" value="{{ request('date') }}">

            <button class="btn btn--primary" type="submit">検索</button>
            <a class="btn btn--ghost" href="/admin">リセット</a>

            {{-- 現在の絞り込み条件でエクスポート --}}
            <a class="btn btn--ghost" href="{{ '/admin/export?'.http_build_query(request()->query()) }}">エクスポート</a>
        </form>

        {{-- 右上ページネーション --}}
        <div class="pager pager--top">
            {{ $contacts->onEachSide(1)->links('pagination::bootstrap-4') }}
        </div>



        {{-- 一覧 --}}
        <div class="table-wrap">
            <table class="tbl">
                <thead>
                    <tr>
                        <th>お名前</th>
                        <th>性別</th>
                        <th>メールアドレス</th>
                        <th>お問い合わせの種類</th>
                        <th style="width:96px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $c)
                    @php
                    $name = $c->last_name.'　'.$c->first_name;
                    $gender = $genderLabels[$c->gender] ?? '';
                    $type = $typeLabels[$c->inquiry_type] ?? $c->inquiry_type;
                    $tel = $c->tel ?? (($c->tel1 ?? '').($c->tel2 ?? '').($c->tel3 ?? ''));
                    @endphp
                    <tr>
                        <td>{{ $name }}</td>
                        <td>{{ $gender }}</td>
                        <td>{{ $c->email }}</td>
                        <td><span class="tag">{{ $type }}</span></td>
                        <td>
                            <button type="button" class="btn btn--sm btn--ghost js-detail"
                                data-id="{{ $c->id }}"
                                data-name="{{ $name }}"
                                data-gender="{{ $gender }}"
                                data-email="{{ $c->email }}"
                                data-tel="{{ $tel }}"
                                data-address="{{ $c->address }}"
                                data-building="{{ $c->building }}"
                                data-type="{{ $type }}"
                                data-content="{{ $c->detail ?? $c->content }}">詳細</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="muted">データがありません</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>



        {{-- ===== モーダル ===== --}}
        <div id="modal" class="modal" aria-hidden="true">
            <div class="modal__overlay js-close"></div>
            <div class="modal__panel" role="dialog" aria-modal="true">
                <button class="modal__close js-close" aria-label="閉じる">×</button>
                <h3 class="modal__title">詳細</h3>
                <div class="modal__body">
                    <dl class="def">
                        <div>
                            <dt>お名前</dt>
                            <dd id="m_name"></dd>
                        </div>
                        <div>
                            <dt>性別</dt>
                            <dd id="m_gender"></dd>
                        </div>
                        <div>
                            <dt>メールアドレス</dt>
                            <dd id="m_email"></dd>
                        </div>
                        <div>
                            <dt>電話番号</dt>
                            <dd id="m_tel"></dd>
                        </div>
                        <div>
                            <dt>住所</dt>
                            <dd id="m_address"></dd>
                        </div>
                        <div>
                            <dt>建物名</dt>
                            <dd id="m_building"></dd>
                        </div>
                        <div>
                            <dt>お問い合わせの種類</dt>
                            <dd id="m_type"></dd>
                        </div>
                        <div>
                            <dt>お問い合わせ内容</dt>
                            <dd id="m_content" style="white-space:pre-wrap;"></dd>
                        </div>
                    </dl>

                    <form id="m_delete" action="#" method="post" class="modal__actions">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn--danger" type="submit" onclick="return confirm('削除しますか？')">削除</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ===== JS（モーダル） ===== --}}
        <script>
            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.js-detail');
                if (btn) {
                    document.getElementById('m_name').textContent = btn.dataset.name || '';
                    document.getElementById('m_gender').textContent = btn.dataset.gender || '';
                    document.getElementById('m_email').textContent = btn.dataset.email || '';
                    document.getElementById('m_tel').textContent = btn.dataset.tel || '';
                    document.getElementById('m_address').textContent = btn.dataset.address || '';
                    document.getElementById('m_building').textContent = btn.dataset.building || '';
                    document.getElementById('m_type').textContent = btn.dataset.type || '';
                    document.getElementById('m_content').textContent = btn.dataset.content || '';

                    document.getElementById('m_delete').action = '/admin/' + btn.dataset.id;
                    document.getElementById('modal').classList.add('is-open');
                }
                if (e.target.closest('.js-close')) {
                    document.getElementById('modal').classList.remove('is-open');
                }
            });
        </script>
    </div>

</body>