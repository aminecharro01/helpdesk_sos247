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
        <!-- <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700&display=swap" rel="stylesheet"> -->

       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <!--
        <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet"> -->
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])


    </head>
    <body>
        <div class="page-wrapper">
            <!-- Header -->
            <header id="header" class="header d-flex align-items-center">
                <div class="container-fluid d-flex align-items-center justify-content-between">
        

                    <!-- Nouvelle Navbar Bootstrap dynamique -->
                    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm w-100">
                        <div class="container-fluid">
                            <a class="navbar-brand d-flex align-items-center" href="{{ route(auth()->user()->role . '.dashboard') }}">
                                <img src="{{ asset('assets/img/logo.webp') }}" alt="Logo" class="me-2" height="32">
                                <span class="fw-bold text-primary">SOS247</span>
                                </a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="mainNavbar">
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                    @if(auth()->check())
                                        @php $role = auth()->user()->role; @endphp
                                        @if($role === 'admin')
                                            <li class="nav-item">
                                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active fw-bold text-primary' : '' }}" href="{{ route('admin.dashboard') }}">
                                                    <i class="bi bi-speedometer2 me-1"></i>Dashboard
                                                </a>
                                            </li>
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.*') ? 'active fw-bold text-primary' : '' }}" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-gear me-1"></i>Gestion
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                                                    <li><a class="dropdown-item {{ request()->routeIs('admin.users.*') ? ' text-primary fw-bold' : '' }}" href="{{ route('admin.users.index') }}"><i class="bi bi-people me-2"></i>Utilisateurs</a></li>
                                                    <li><a class="dropdown-item {{ request()->routeIs('admin.tickets.*') ? ' text-primary fw-bold' : '' }}" href="{{ route('admin.tickets.index') }}"><i class="bi bi-ticket-detailed me-2"></i>Tickets</a></li>
                                                </ul>
                                            </li>
                                        @elseif($role === 'superviseur')
                                            <li class="nav-item">
                                                <a class="nav-link {{ request()->routeIs('superviseur.dashboard') ? ' fw-bold text-primary' : '' }}" href="{{ route('superviseur.dashboard') }}">
                                                    <i class="bi bi-speedometer2 me-1"></i>Dashboard
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link {{ request()->routeIs('superviseur.tickets.index') ? ' fw-bold text-primary' : '' }}" href="{{ route('superviseur.tickets.index') }}">
                                                    <i class="bi bi-ticket-detailed me-1"></i>Tickets
                                                </a>
                                            </li>
                                        @elseif($role === 'agent')
                                            <li class="nav-item">
                                                <a class="nav-link {{ request()->routeIs('agent.dashboard') ? ' fw-bold text-primary' : '' }}" href="{{ route('agent.dashboard') }}">
                                                    <i class="bi bi-speedometer2 me-1"></i>Dashboard
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link {{ request()->routeIs('agent.tickets.index') ? ' fw-bold text-primary' : '' }}" href="{{ route('agent.tickets.index') }}">
                                                    <i class="bi bi-ticket-detailed me-1"></i>Tickets
                                                </a>
                                            </li>
                                        @elseif($role === 'client')
                                            <li class="nav-item">
                                                <a class="nav-link {{ request()->routeIs('client.dashboard') ? ' fw-bold text-primary' : '' }}" href="{{ route('client.dashboard') }}">
                                                    <i class="bi bi-speedometer2 me-1"></i>Dashboard
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link {{ request()->routeIs('client.tickets.index') ? ' fw-bold text-primary' : '' }}" href="{{ route('client.tickets.index') }}">
                                                    <i class="bi bi-ticket-detailed me-1"></i>Mes Tickets
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link {{ request()->routeIs('client.tickets.create') ? ' fw-bold text-primary' : '' }}" href="{{ route('client.tickets.create') }}">
                                                    <i class="bi bi-plus-circle me-1"></i>Nouveau Ticket
                                                </a>
                                            </li>
                                        @endif
                                    @endif
                                </ul>
                                @if(auth()->check())
                                    <ul class="navbar-nav ms-lg-auto">
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle {{ request()->routeIs('profile.*') ? ' fw-bold text-primary' : '' }}" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                                <li><a class="dropdown-item {{ request()->routeIs('profile.edit') ? ' text-primary fw-bold' : '' }}" href="{{ route('profile.edit') }}"><i class="bi bi-pencil-square me-2"></i>Mon Profil</a></li>
                                                <li>
                                                    <form method="POST" action="{{ route('logout') }}">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </nav>


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
        <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>

        <!-- Main JS File -->
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <!-- Bootstrap Bundle JS (CDN) - only include ONCE to ensure toggler works -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
