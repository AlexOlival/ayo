<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ayo') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="{{ Route::currentRouteName() === 'welcome' ? 'homepage-background' : '' }}">
    <div id="app">

        @auth
    @include('partials.navbar') @endauth

        <div class="flex flex-row justify-center w-screen">
            <main class="max-w-5xl w-screen">
                @yield('content')
            </main>
        </div>

        @guest
    @include('modals.login-modal')
    @include('modals.register-modal') @endguest

    </div>
</body>

</html>