<p>
  {{ $mailReceiverName }}さん
</p>

@if( $targetFlag === 'recruiter')
  <p>{{ $applier->name }}さんがあなたの募集案件に応募しました。</p>
  <pre>
    案件タイトル：{{ $work->title }}
    応募者：{{ $applier->name }}
    詳細：<a href="{{ $jumpUrl }}">こちらのリンクからご確認ください</a>
  </pre>
@else
  <p>応募が完了しました。</p>
  <pre>
    案件タイトル：{{ $work->title }}
    詳細：<a href="{{ $jumpUrl }}">こちらのリンクからご確認ください</a>
  </pre>
@endif


