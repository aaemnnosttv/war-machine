<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WAR</title>
    <link rel="stylesheet" href="/css/app.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha256-k2/8zcNbxVIh5mnQ52A0r3a6jAgMGxFJFE2707UxGCk= sha512-ZV9KawG2Legkwp3nAlxLIVFudTauWuBpC10uEafMHYL0Sarrz5A7G79kXh5+5+woxQ5HM559XX2UZjMJ36Wplg==" crossorigin="anonymous">
</head>
<body>

<header class="primary">
    <nav class="navbar navbar-light bg-faded">
        <div class="container">
            <a class="navbar-brand" href="/">War Machine</a>
            <ul class="nav navbar-nav">
            	{{--<li class="nav-item"><a href="">Item 1</a></li>--}}
            </ul>
        </div>
    </nav>
</header>

<main>
    <div class="container p-y">
        @yield('content')
    </div>
</main>

<footer>
    <div class="container text-muted">
        <div class="built-with text-xs-center">
            <ul class="list-inline">
                <li class="list-inline-item"><a href="https://laravel.com" target="_blank">Laravel</a></li>
                <li class="list-inline-item"><a href="https://vuejs.org/" target="_blank">Vue</a></li>
                <li class="list-inline-item"><a href="https://github.com/aaemnnosttv/war.php" target="_blank">War.php</a></li>
                <li class="list-inline-item"><a href="http://v4-alpha.getbootstrap.com/getting-started/introduction/" target="_blank">Bootstrap</a></li>
            </ul>
            <div class="byline"><a href="https://github.com/aaemnnosttv/war-machine"><i class="fa fa-2x fa-github"></i></a></div>
        </div>
    </div>
</footer>

<script>
window.App = {
    csrfToken: '{{ csrf_token() }}'
};
</script>
@if ($gaID = env('GOOGLE_ANALYTICS_ID'))
    @include('partials.script-analytics', ['gaID' => $gaID])
@endif
@yield('scripts')
<script src="/js/app.js"></script>
</body>
</html>
