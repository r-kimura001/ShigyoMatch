<!doctype html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ config('app.name') }}</title>
  <!-- Scripts -->
  <script type="text/javascript" src="{{ asset('js/app.js') }}" defer></script>
  <!-- Twitter -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:site" content="@kaba_farm" />
  <meta property="og:url" content="https://www.shigyo-match.site" />
  <meta property="og:title" content="ポートフォリオ『士業マッチングサイト』" />
  <meta property="og:description" content="キャッチフレーズは『プロフェッショナルをシェアする』。プログラミング学習用のポートフォリオです" />
  <meta property="og:image" content="https://asset.shigyo-match.site/assets/main-visual04.jpg" />
  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/yakuhanjp@3.3.1/dist/css/yakuhanjp.min.css">
  {{-- 住所検索 --}}
  <script src="https://yubinbango.github.io/yubinbango-core/yubinbango-core.js" charset="UTF-8"></script>
</head>
<body>
  <div id="app"></div>
</body>
</html>
