<p>
  {{ $mailReceiverName }}さん
</p>

<p>{{ $scouter->name }}さんからスカウトが届きました</p>

<pre>
  お仕事タイトル：{{ $work->title }}
  詳細：<a href="{{ $jumpUrl }}">スカウトの内容はこちらのリンクからご確認ください</a>
</pre>
