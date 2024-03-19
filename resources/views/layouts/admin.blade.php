<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('compiled/svg/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('compiled/css/iconly.css') }}">
    <link rel="stylesheet" href="{{ asset('static/css/style.css') }}">
    @stack('style')
</head>

<body>
    <script src="{{ asset('static/js/initTheme.js') }}"></script>
    <div id="app">
        @include('components.sidebar_admin')
        <div id="main" class='layout-navbar navbar-fixed'>
            @include('components.header_admin')
            <div id="main-content">
                @yield('main')
                @include('components.footer')
            </div>
        </div>
    </div>
    <script src="{{ asset('extensions/jquery/jquery.js') }}"></script>
    <script src="{{ asset('static/js/pages/horizontal-layout.js') }}"></script>
    <script src="{{ asset('extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('compiled/js/app.js') }}"></script>
    @stack('scripts')
    <script src="{{ asset('static/js/custom.js') }}"></script>
</body>

</html>
