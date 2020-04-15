<p>
  {{ $mailReceiverName }}さん
</p>

<p>{{ $favoriter->name }}さんがあなたの募集中の案件に「気になる」しました</p>

<pre>
  気になるした人：{{ $favoriter->name }}
  お仕事タイトル：{{ $work->title }}
  詳細：<a href="https://www.shigyo-match.site/mypage/{{ $mailReceiverId }}/favorites">こちらのリンクからご確認ください</a>
</pre>
