<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="user" content="{{ auth()->user() }}">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#ff8a80">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ff8a80">

    <title>{{ config('app.name', 'Ayo') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,600" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="{{ Route::currentRouteName() === 'welcome' ? 'homepage-background' : '' }}">
    <div id="app">

        @includeWhen(Route::currentRouteName() !== 'welcome', 'partials.navbar')

        <div class="flex flex-row justify-center w-screen">
            <main class="max-w-5xl w-screen container mx-auto">
                @yield('content')
            </main>
        </div>

    </div>
</body>

</html>
