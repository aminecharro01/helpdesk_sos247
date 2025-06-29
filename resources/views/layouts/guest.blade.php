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

    <!-- Vendor CSS -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">

    <!-- Main CSS -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/auth.css') }}" rel="stylesheet">

    <!-- Laravel Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Guest Layout Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/guest-layout.css') }}">

</head>
<body>

<div class="page-wrapper">

    <!-- Header -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="container-fluid d-flex align-items-center justify-content-between">

            <a href="{{ route('login') }}" class="logo d-flex align-items-center me-auto me-xl-0">
                <img src="{{ asset('assets/img/logo.png') }}" alt="SOS247 Logo" height="40">
                <h1>{{ config('app.name', 'SOS247') }}<span>.</span></h1>
            </a>

            <nav id="navbar" class="navbar">
                <ul class="d-flex gap-2 mb-0">
                    <li><a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                    </a></li>
                    <li><a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'active' : '' }}">
                        <i class="bi bi-person-plus me-2"></i>Register
                    </a></li>
                </ul>
            </nav>

            <!-- Mobile nav toggles -->
            <i class="mobile-nav-toggle mobile-nav-show bi bi-list d-xl-none"></i>
            <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x d-xl-none"></i>
        </div>
    </header>

    <!-- Main Content -->
    <main id="main" class="main" data-aos="fade-up">
        <div class="container py-5">
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

    <!-- Scroll to Top -->
    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short fs-4"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>
</div>

<!-- Vendor JS -->
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('assets/js/main.js') }}"></script>

<script>
    // AOS Init
    AOS.init({
        duration: 700,
        once: true
    });

    // Preloader removal
    window.addEventListener('load', () => {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            preloader.style.display = 'none';
        }
    });
</script>

</body>
</html>
