<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{ asset('images/favicon-32x32.png') }}" type="image/png" />
    <!--plugins-->
    <link href="{{ asset('plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <!-- loader-->
    <link href="{{ asset('css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/pace.min.js') }}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/icons.css') }}" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{ asset('css/dark-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/semi-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/header-colors.css') }}" />

    @stack('style')

    <title>@yield('title') - {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <!--start header wrapper-->
        @include('components.header_admin')
        <!--end header wrapper-->
        <!--start page wrapper -->
        <div class="page-wrapper">
            @yield('main')
        </div>
        <!--end page wrapper -->
        <!--start overlay-->
        @include('components.footer_admin')
    </div>
    <!--end wrapper-->
    <!-- Bootstrap JS -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('js/index.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--app JS-->
    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')
</body>

</html>
