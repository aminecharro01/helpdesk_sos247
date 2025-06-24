<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SOS247') }}</title>

        <!-- Favicons -->
        <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
        <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700&display=swap" rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">

        <!-- Main CSS File -->
        <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="page-wrapper">
            <!-- Header -->
            <header id="header" class="header fixed-top d-flex align-items-center">
                <div class="container-fluid d-flex align-items-center justify-content-between">
                    <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="logo d-flex align-items-center me-auto me-xl-0">
                        <img src="{{ asset('assets/img/logo.webp') }}" alt="Logo">
                        <h1>{{ config('app.name', 'SOS247') }}<span>.</span></h1>
                    </a>

                    <!-- Navigation -->
                    <x-navigation />

                    <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
                    <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
                </div>
            </header>

            <!-- Main Content -->
            <main id="main" class="main">
                <div class="container-fluid py-4">
                    {{ $slot }}
                </div>
            </main>

            <!-- Footer -->
            <footer id="footer" class="footer">
                <div class="container">
                    <div class="copyright">
                        &copy; {{ date('Y') }} <strong><span>{{ config('app.name', 'SOS247') }}</span></strong>. All Rights Reserved
                    </div>
                </div>
            </footer>

            <!-- Scroll Top Button -->
            <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

            <!-- Preloader -->
            <div id="preloader"></div>
        </div>

        <!-- Vendor JS Files -->
        <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>

        <!-- Main JS File -->
        <script src="{{ asset('assets/js/main.js') }}"></script>
    </body>
</html>
