<p>
  {{ $mailReceiverName }}さん
</p>

<p>{{ $follower->name }}さんがあなたを「フォロー」しました</p>

<pre>
  新しいフォロワー：{{ $follower->name }}
  詳細：<a href="https://www.shigyo-match.site/customers/{{ $follower->id }}">こちらのリンクからご確認ください</a>
</pre>
