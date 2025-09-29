<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '홈페이지코리아 유지보수')</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/default.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reactive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">

    <!-- JavaScript -->
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/nice-select.js') }}"></script>
    <script src="{{ asset('js/slick.js') }}"></script>
    <script src="{{ asset('js/com.js') }}"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('styles')
</head>
<body>
    @include('layouts.header')

    <main>
        @yield('content')
    </main>

    @include('layouts.footer')

    @stack('scripts')
</body>
</html>
