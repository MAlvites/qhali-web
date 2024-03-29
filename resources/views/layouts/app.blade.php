<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            width: 100%;
            background-color: #fff;
        }
        .block-web {
            pointer-events: none;
            background-color: #fff;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <div id="app" class="h-100">
        <main class="h-100">
            @yield('content')
        </main>
    </div>
</body>
</html>
