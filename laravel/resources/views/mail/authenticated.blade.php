<p>{{ $newCustomer->name }}さん</p>
<p>士業マッチングサイトです。<br>このたびは会員登録ありがとうございます。</p>

<p>{{ $newCustomer->name }}さんの初期ログインIDは以下の通りです。</p>
<p>ID：{{ $newCustomer->user->login_id  }}</p>

<p>サービスご利用の前にまず、下記プロフィールページのリンクよりご自身の<strong>ログインIDの変更をしてください</strong>。</p>
<p><a href="{{ config('app.url') }}/mypage/{{ $newCustomer->id }}/profile">プロフィールページはこちら</a></p>
