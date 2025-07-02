<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ config('app.name', 'SOS247') }} - Système d'Assistance</title>
    <meta name="description" content="Système de tickets d'assistance professionnel pour un support client efficace">
    <meta name="keywords" content="assistance, tickets, support, service client">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="index-page">
    <header id="header" class="header fixed-top">
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('welcome') }}">
                    <span class="fw-bold text-primary">{{ config('app.name', 'SOS247') }}</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mainNavbar">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" href="#hero">Accueil</a></li>
                        <li class="nav-item"><a class="nav-link" href="#features">Fonctionnalités</a></li>
                        <li class="nav-item"><a class="nav-link" href="#how-it-works">Comment ça marche</a></li>
                    </ul>
                    @if (Route::has('login'))
                        <div class="d-flex align-items-center ms-lg-3">
                            @auth
                                @php
                                    $role = auth()->user()->role;
                                    $dashboardRoute = match($role) {
                                        'admin' => route('admin.dashboard'),
                                        'superviseur' => route('superviseur.dashboard'),
                                        'agent' => route('agent.dashboard'),
                                        'client' => route('client.dashboard'),
                                        default => '#'
                                    };
                                @endphp
                                <a href="{{ $dashboardRoute }}" class="btn btn-primary">Tableau de bord</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-success me-2">Connexion</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-primary">S'inscrire</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </nav>
    </header>

    <!-- Ajout d'un espace sous la navbar fixe -->
    <div style="padding-top: 90px;"></div>

    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row align-items-center mb-5">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="badge-wrapper mb-3">
                            <div class="d-inline-flex align-items-center rounded-pill border border-accent-light">
                                <div class="icon-circle me-2">
                                    <i class="bi bi-ticket-detailed"></i>
                                </div>
                                <span class="badge-text me-3">Assistance Professionnelle</span>
                            </div>
                        </div>

                        <h1 class="hero-title mb-4">Optimisez votre Support Client avec notre Système d'Assistance</h1>

                        <p class="hero-description mb-4">Gérez efficacement les demandes clients, suivez les tickets de support et offrez un service exceptionnel avec notre solution d'assistance complète.</p>

                        <div class="cta-wrapper">
                            @auth
                                <a href="{{ route('client.dashboard') }}" class="btn btn-primary">Aller au tableau de bord</a>
                            @else
                                <a href="{{ route('register') }}" class="btn btn-primary">Commencer</a>
                            @endauth
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="hero-image">
                            <img src="{{ asset('assets/img/illustration/illustration-16.png') }}" alt="Système d'Assistance" class="img-fluid" loading="lazy">
                        </div>
                    </div>
                </div>

                <div class="row feature-boxes">
                    <div class="col-lg-4 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="200">
                        <div class="feature-box">
                            <div class="feature-icon me-sm-4 mb-3 mb-sm-0">
                                <i class="bi bi-ticket-detailed"></i>
                            </div>
                            <div class="feature-content">
                                <h3 class="feature-title">Gestion des Tickets</h3>
                                <p class="feature-text">Créez, suivez et gérez les tickets de support efficacement avec notre interface intuitive.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="300">
                        <div class="feature-box">
                            <div class="feature-icon me-sm-4 mb-3 mb-sm-0">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="feature-content">
                                <h3 class="feature-title">Collaboration d'Équipe</h3>
                                <p class="feature-text">Permettez une collaboration fluide entre les agents de support et les départements.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="400">
                        <div class="feature-box">
                            <div class="feature-icon me-sm-4 mb-3 mb-sm-0">
                                <i class="bi bi-graph-up"></i>
                            </div>
                            <div class="feature-content">
                                <h3 class="feature-title">Analyses & Rapports</h3>
                                <p class="feature-text">Obtenez des insights sur les performances du support avec des analyses détaillées et des rapports.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="services section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Fonctionnalités Clés</h2>
                <p>Tout ce dont vous avez besoin pour fournir un support client exceptionnel</p>
            </div>

            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row justify-content-center g-5">
                    <div class="col-md-6" data-aos="fade-right" data-aos-delay="100">
                        <div class="service-item">
                            <div class="service-icon">
                                <i class="bi bi-ticket-detailed"></i>
                            </div>
                            <div class="service-content">
                                <h3>Gestion des Tickets</h3>
                                <p>Créez et gérez les tickets de support facilement. Suivez le statut des tickets, assignez des agents et maintenez un historique de communication détaillé.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6" data-aos="fade-left" data-aos-delay="100">
                        <div class="service-item">
                            <div class="service-icon">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="service-content">
                                <h3>Accès Basé sur les Rôles</h3>
                                <p>Différents niveaux d'accès pour les clients, agents et administrateurs. Gestion de flux de travail sécurisée et organisée.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6" data-aos="fade-right" data-aos-delay="200">
                        <div class="service-item">
                            <div class="service-icon">
                                <i class="bi bi-chat-dots"></i>
                            </div>
                            <div class="service-content">
                                <h3>Communication en Temps Réel</h3>
                                <p>Notifications instantanées et mises à jour. Tenez tout le monde informé des changements de statut des tickets et des nouveaux messages.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6" data-aos="fade-left" data-aos-delay="200">
                        <div class="service-item">
                            <div class="service-icon">
                                <i class="bi bi-graph-up"></i>
                            </div>
                            <div class="service-content">
                                <h3>Analyses de Performance</h3>
                                <p>Suivez les temps de réponse, les taux de résolution et la satisfaction client. Prenez des décisions basées sur les données pour améliorer le service.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section id="how-it-works" class="how-we-work section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Comment ça marche</h2>
                <p>Gestion simple et efficace des tickets de support</p>
            </div>

            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="steps-5">
                    <div class="process-container">
                        <div class="process-item" data-aos="fade-up" data-aos-delay="200">
                            <div class="content">
                                <span class="step-number">01</span>
                                <div class="card-body">
                                    <div class="step-icon">
                                        <i class="bi bi-ticket-detailed"></i>
                                    </div>
                                    <div class="step-content">
                                        <h3>Créer un Ticket</h3>
                                        <p>Soumettez votre demande de support via notre interface conviviale.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="process-item" data-aos="fade-up" data-aos-delay="300">
                            <div class="content">
                                <span class="step-number">02</span>
                                <div class="card-body">
                                    <div class="step-icon">
                                        <i class="bi bi-person-check"></i>
                                    </div>
                                    <div class="step-content">
                                        <h3>Attribution d'Agent</h3>
                                        <p>Votre ticket est automatiquement assigné à l'agent de support le plus approprié.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="process-item" data-aos="fade-up" data-aos-delay="400">
                            <div class="content">
                                <span class="step-number">03</span>
                                <div class="card-body">
                                    <div class="step-icon">
                                        <i class="bi bi-chat-dots"></i>
                                    </div>
                                    <div class="step-content">
                                        <h3>Communication</h3>
                                        <p>Échangez des messages et des mises à jour avec l'équipe de support en temps réel.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="process-item" data-aos="fade-up" data-aos-delay="500">
                            <div class="content">
                                <span class="step-number">04</span>
                                <div class="card-body">
                                    <div class="step-icon">
                                        <i class="bi bi-check-circle"></i>
                                    </div>
                                    <div class="step-content">
                                        <h3>Résolution</h3>
                                        <p>Obtenez la résolution de votre problème et donnez votre avis sur le service.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call To Action Section -->
        <section id="call-to-action" class="call-to-action-2 section light-background">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
                        <div class="cta-image-wrapper">
                            <img src="{{ asset('assets/img/cta/cta-4.webp') }}" alt="Équipe de Support" class="img-fluid rounded-4">
                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
                        <div class="cta-content">
                            <h2>Prêt à Transformer votre Support Client ?</h2>
                            <p class="lead">Rejoignez des milliers d'entreprises qui font confiance à notre système d'assistance pour leurs besoins de support client.</p>

                            <div class="cta-features">
                                <div class="feature-item" data-aos="zoom-in" data-aos-delay="400">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Gestion facile des tickets</span>
                                </div>
                                <div class="feature-item" data-aos="zoom-in" data-aos-delay="450">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Communication en temps réel</span>
                                </div>
                                <div class="feature-item" data-aos="zoom-in" data-aos-delay="500">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Analyses complètes</span>
                                </div>
                            </div>

                            <div class="cta-action mt-5">
                                @auth
                                    <a href="{{ route('client.dashboard') }}" class="btn btn-primary btn-lg">Aller au tableau de bord</a>
                                @else
                                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-3">Commencer</a>
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">Connexion</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer id="footer" class="footer light-background">
        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="{{ route('welcome') }}" class="logo d-flex align-items-center">
                        <span class="sitename">{{ config('app.name', 'SOS247') }}</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Système d'Assistance Professionnel</p>
                        <p>Optimisez votre support client</p>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Liens Rapides</h4>
                    <ul>
                        <li><a href="#hero">Accueil</a></li>
                        <li><a href="#features">Fonctionnalités</a></li>
                        <li><a href="#how-it-works">Comment ça marche</a></li>
                        <li><a href="#pricing">Tarifs</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Fonctionnalités</h4>
                    <ul>
                        <li><a href="#features">Gestion des Tickets</a></li>
                        <li><a href="#features">Collaboration d'Équipe</a></li>
                        <li><a href="#features">Analyses</a></li>
                        <li><a href="#features">Mises à jour en temps réel</a></li>
                        <li><a href="#features">Gestion des Rôles</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Support</h4>
                    <ul>
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Contacter le Support</a></li>
                        <li><a href="#">État du Système</a></li>
                        <li><a href="#">Mises à jour</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>&copy; {{ date('Y') }} <strong class="px-1">{{ config('app.name', 'SOS247') }}</strong>. Tous droits réservés</p>
        </div>
    </footer>

    <!-- Scroll Top Button -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Scripts -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>