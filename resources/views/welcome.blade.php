<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion Med — Réservation de Services Médicaux</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #4e73df;
            --primary-dark: #2e59d9;
            --success: #1cc88a;
            --info: #36b9cc;
        }
        body { font-family: 'Nunito', sans-serif; }

        /* ─── Navbar ─── */
        .navbar-vitrine {
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.07);
            padding: .85rem 0;
            transition: box-shadow .3s;
        }
        .navbar-vitrine.scrolled { box-shadow: 0 4px 25px rgba(0,0,0,0.13); }
        .navbar-vitrine .navbar-brand {
            font-weight: 900;
            font-size: 1.4rem;
            color: var(--primary) !important;
            letter-spacing: -.5px;
        }
        .navbar-vitrine .nav-link {
            color: #555 !important;
            font-weight: 600;
            transition: color .2s;
        }
        .navbar-vitrine .nav-link:hover { color: var(--primary) !important; }

        /* ─── Hero ─── */
        .hero {
            background: linear-gradient(135deg, #4e73df 0%, #36b9cc 60%, #1cc88a 100%);
            min-height: 92vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: -20%;
            right: -8%;
            width: 550px; height: 550px;
            background: rgba(255,255,255,0.07);
            border-radius: 50%;
        }
        .hero::after {
            content: '';
            position: absolute;
            bottom: -25%;
            left: -5%;
            width: 420px; height: 420px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }
        .hero h1 {
            font-size: clamp(2.2rem, 5vw, 3.2rem);
            font-weight: 900;
            color: #fff;
            line-height: 1.15;
        }
        .hero p.lead {
            color: rgba(255,255,255,0.88);
            font-size: 1.15rem;
        }
        .hero-icon-bg {
            width: 300px; height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            position: relative;
            z-index: 1;
            box-shadow: 0 0 0 40px rgba(255,255,255,0.05);
        }
        .hero-icon-bg i { font-size: 7.5rem; color: rgba(255,255,255,0.82); }

        /* ─── Pills hero ─── */
        .hero-pill {
            display: inline-flex;
            align-items: center;
            background: rgba(255,255,255,0.18);
            color: #fff;
            border-radius: 50px;
            padding: .4rem 1rem;
            font-size: .85rem;
            font-weight: 600;
            border: 1px solid rgba(255,255,255,0.25);
            gap: .4rem;
        }

        /* ─── Buttons hero ─── */
        .btn-hero-white {
            background: #fff;
            color: var(--primary);
            font-weight: 800;
            padding: .85rem 2rem;
            border-radius: 50px;
            border: none;
            font-size: 1rem;
            box-shadow: 0 8px 25px rgba(0,0,0,0.18);
            transition: all .25s;
            text-decoration: none;
        }
        .btn-hero-white:hover {
            background: #f0f4ff;
            color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 14px 35px rgba(0,0,0,0.22);
        }
        .btn-hero-outline {
            background: transparent;
            color: #fff;
            font-weight: 700;
            padding: .85rem 2rem;
            border-radius: 50px;
            border: 2px solid rgba(255,255,255,0.65);
            font-size: 1rem;
            transition: all .25s;
            text-decoration: none;
        }
        .btn-hero-outline:hover {
            background: rgba(255,255,255,0.18);
            border-color: #fff;
            color: #fff;
        }

        /* ─── Stats ─── */
        .stats-section {
            background: #fff;
            box-shadow: 0 6px 30px rgba(0,0,0,0.08);
            position: relative;
            z-index: 10;
        }
        .stat-col { padding: 2rem 1.5rem; border-right: 1px solid #eee; }
        .stat-col:last-child { border-right: none; }
        .stat-number {
            font-size: 2.6rem;
            font-weight: 900;
            background: linear-gradient(135deg, var(--primary), var(--info));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
        }
        .stat-label {
            color: #999;
            font-size: .82rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            margin-top: .3rem;
        }

        /* ─── Sections ─── */
        .section-tag {
            font-size: .82rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .1em;
        }
        .section-title {
            font-size: clamp(1.7rem, 3vw, 2.2rem);
            font-weight: 900;
            color: #1e2d3d;
        }
        .section-sub { color: #8a9ab0; font-size: 1.05rem; }

        /* ─── Service cards ─── */
        .service-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.07);
            transition: transform .3s, box-shadow .3s;
            overflow: hidden;
        }
        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 40px rgba(78,115,223,0.2);
        }
        .service-card-header {
            padding: 1.8rem;
            background: linear-gradient(135deg, var(--primary) 0%, #36b9cc 100%);
            text-align: center;
        }
        .service-card-header i { font-size: 2.2rem; color: rgba(255,255,255,0.88); }
        .service-card .card-body { padding: 1.5rem; }
        .service-card .card-title { font-weight: 800; color: #1e2d3d; font-size: 1.05rem; margin-bottom: .5rem; }

        .badge-price {
            background: linear-gradient(135deg, #1cc88a, #13855c);
            color: #fff;
            padding: .35rem .9rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: .82rem;
        }
        .badge-duration {
            background: #e8f6fd;
            color: var(--info);
            padding: .35rem .9rem;
            border-radius: 50px;
            font-size: .82rem;
            font-weight: 700;
        }

        /* ─── Steps ─── */
        .step-wrap { position: relative; }
        .step-icon {
            width: 80px; height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.2rem;
            font-size: 1.7rem;
            color: #fff;
        }
        .step-1 { background: linear-gradient(135deg, #4e73df, #224abe); }
        .step-2 { background: linear-gradient(135deg, #1cc88a, #13855c); }
        .step-3 { background: linear-gradient(135deg, #36b9cc, #1a7f8e); }
        .step-4 { background: linear-gradient(135deg, #f6c23e, #c99a0f); }
        .step-number {
            position: absolute;
            top: 0; right: calc(50% - 50px);
            width: 26px; height: 26px;
            background: var(--primary);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .75rem;
            font-weight: 800;
        }

        /* ─── CTA ─── */
        .cta-section {
            background: linear-gradient(135deg, #4e73df 0%, #36b9cc 100%);
            position: relative;
            overflow: hidden;
        }
        .cta-section::before {
            content:'';
            position:absolute;
            top:-50%; right:-10%;
            width:400px; height:400px;
            border-radius:50%;
            background: rgba(255,255,255,0.07);
        }

        /* ─── Footer ─── */
        .footer-main {
            background: #1a2332;
            color: rgba(255,255,255,0.65);
        }
        .footer-main h5, .footer-main h6 { color: #fff; }
        .footer-main a { color: rgba(255,255,255,0.65); text-decoration: none; transition: color .2s; }
        .footer-main a:hover { color: #fff; }
        .footer-brand-icon { color: var(--primary); }
        .footer-divider { border-color: rgba(255,255,255,0.1); }
    </style>
</head>
<body>

{{-- ════════════════ NAVBAR ════════════════ --}}
<nav class="navbar navbar-expand-lg navbar-vitrine fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="/">
            <i class="fas fa-hospital-alt me-2"></i>Gestion Med
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#services">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#fonctionnement">Comment ça marche</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                @guest
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i>Connexion
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn btn-primary px-4 rounded-pill fw-bold">
                            <i class="fas fa-user-plus me-1"></i>S'inscrire
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt me-1"></i>Mon espace
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger rounded-pill px-3 fw-semibold">
                                <i class="fas fa-sign-out-alt me-1"></i>Déconnexion
                            </button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

{{-- ════════════════ HERO ════════════════ --}}
<section class="hero" style="padding-top: 80px;">
    <div class="container">
        <div class="row align-items-center gy-5">
            <div class="col-lg-7" style="position:relative;z-index:1;">
                <span class="hero-pill mb-3 d-inline-flex">
                    <i class="fas fa-star text-warning"></i> Plateforme de santé numérique
                </span>
                <h1 class="mt-2 mb-3">
                    Votre santé,<br>
                    <span style="color:rgba(255,255,255,0.75);">simplifiée.</span>
                </h1>
                <p class="lead mb-4">
                    Réservez vos consultations médicales en quelques clics.<br>
                    Des médecins qualifiés, des créneaux flexibles, un suivi complet.
                </p>
                <div class="d-flex flex-wrap gap-3 mb-4">
                    @guest
                        <a href="{{ route('register') }}" class="btn-hero-white">
                            <i class="fas fa-calendar-plus me-2"></i>Prendre rendez-vous
                        </a>
                        <a href="#services" class="btn-hero-outline">
                            <i class="fas fa-stethoscope me-2"></i>Voir les services
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn-hero-white">
                            <i class="fas fa-tachometer-alt me-2"></i>Mon espace
                        </a>
                        <a href="/services" class="btn-hero-outline">
                            <i class="fas fa-stethoscope me-2"></i>Voir les services
                        </a>
                    @endguest
                </div>
                <div class="d-flex flex-wrap gap-4">
                    <span class="hero-pill"><i class="fas fa-shield-alt"></i> Données sécurisées</span>
                    <span class="hero-pill"><i class="fas fa-clock"></i> Disponible 24h/24</span>
                    <span class="hero-pill"><i class="fas fa-check-circle"></i> Confirmation instantanée</span>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-flex justify-content-center" style="position:relative;z-index:1;">
                <div class="hero-icon-bg">
                    <i class="fas fa-heartbeat"></i>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════ STATS ════════════════ --}}
<section class="stats-section">
    <div class="container">
        <div class="row text-center">
            <div class="col-6 col-md-3 stat-col">
                <div class="stat-number">{{ $stats['services'] }}+</div>
                <div class="stat-label">Services médicaux</div>
            </div>
            <div class="col-6 col-md-3 stat-col">
                <div class="stat-number">{{ $stats['medecins'] }}+</div>
                <div class="stat-label">Médecins qualifiés</div>
            </div>
            <div class="col-6 col-md-3 stat-col">
                <div class="stat-number">{{ $stats['patients'] }}+</div>
                <div class="stat-label">Patients inscrits</div>
            </div>
            <div class="col-6 col-md-3 stat-col">
                <div class="stat-number">{{ $stats['reservations'] }}+</div>
                <div class="stat-label">Réservations</div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════ SERVICES ════════════════ --}}
<section id="services" style="padding: 5rem 0; background: #f8f9fc;">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-tag text-primary">
                <i class="fas fa-stethoscope me-1"></i> Nos spécialités
            </span>
            <h2 class="section-title mt-2">Services médicaux disponibles</h2>
            <p class="section-sub">Consultez notre catalogue et réservez directement en ligne.</p>
        </div>

        @if($services->isEmpty())
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle me-2"></i>Aucun service disponible pour le moment.
            </div>
        @else
            <div class="row g-4">
                @php
                    $icons = ['heartbeat','user-md','pills','microscope','tooth','brain','lungs','stethoscope'];
                @endphp
                @foreach($services as $service)
                <div class="col-lg-4 col-md-6">
                    <div class="card service-card h-100">
                        <div class="service-card-header">
                            <i class="fas fa-{{ $icons[$loop->index % count($icons)] }}"></i>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $service->titre }}</h5>
                            <p class="text-muted small flex-grow-1">{{ Str::limit($service->description, 100) }}</p>

                            @if($service->medecin)
                            <div class="d-flex align-items-center mb-3 p-2 bg-light rounded-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-2"
                                     style="width:38px;height:38px;background:linear-gradient(135deg,#4e73df,#224abe);flex-shrink:0;">
                                    <i class="fas fa-user-md text-white" style="font-size:.75rem;"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark" style="font-size:.88rem;">Dr. {{ $service->medecin->name }}</div>
                                    <div class="text-muted" style="font-size:.75rem;">Médecin assigné</div>
                                </div>
                            </div>
                            @endif

                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="badge-price">{{ number_format($service->prix, 0, ',', ' ') }} FCFA</span>
                                <span class="badge-duration"><i class="fas fa-clock me-1"></i>{{ $service->duree }} min</span>
                            </div>

                            <div class="d-flex gap-2 mt-auto">
                                <a href="/services/{{ $service->id }}" class="btn btn-outline-primary btn-sm flex-fill rounded-pill">
                                    <i class="fas fa-eye me-1"></i>Détails
                                </a>
                                @auth
                                    @if(auth()->user()->role === 'patient')
                                        <a href="/reservation/{{ $service->id }}/create" class="btn btn-primary btn-sm flex-fill rounded-pill">
                                            <i class="fas fa-calendar-plus me-1"></i>Réserver
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm flex-fill rounded-pill">
                                        <i class="fas fa-sign-in-alt me-1"></i>Réserver
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <a href="/services" class="btn btn-primary btn-lg px-5 rounded-pill fw-bold">
                    <i class="fas fa-th-large me-2"></i>Voir tous les services
                </a>
            </div>
        @endif
    </div>
</section>

{{-- ════════════════ COMMENT ÇA MARCHE ════════════════ --}}
<section id="fonctionnement" style="padding: 5rem 0; background: #fff;">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-tag text-success">
                <i class="fas fa-route me-1"></i> Simple & rapide
            </span>
            <h2 class="section-title mt-2">Comment ça marche ?</h2>
            <p class="section-sub">Réservez votre consultation en 4 étapes.</p>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-3">
                <div class="step-wrap d-inline-block">
                    <div class="step-icon step-1">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <span class="step-number">1</span>
                </div>
                <h5 class="fw-bold mt-3">Créez votre compte</h5>
                <p class="text-muted small">Inscrivez-vous gratuitement en moins d'une minute.</p>
            </div>
            <div class="col-md-3">
                <div class="step-wrap d-inline-block">
                    <div class="step-icon step-2">
                        <i class="fas fa-search"></i>
                    </div>
                    <span class="step-number">2</span>
                </div>
                <h5 class="fw-bold mt-3">Choisissez un service</h5>
                <p class="text-muted small">Parcourez notre catalogue de services médicaux.</p>
            </div>
            <div class="col-md-3">
                <div class="step-wrap d-inline-block">
                    <div class="step-icon step-3">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <span class="step-number">3</span>
                </div>
                <h5 class="fw-bold mt-3">Réservez un créneau</h5>
                <p class="text-muted small">Sélectionnez la date et l'heure qui vous conviennent.</p>
            </div>
            <div class="col-md-3">
                <div class="step-wrap d-inline-block">
                    <div class="step-icon step-4">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <span class="step-number">4</span>
                </div>
                <h5 class="fw-bold mt-3">Confirmation immédiate</h5>
                <p class="text-muted small">Suivez l'état de votre réservation en temps réel.</p>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════ CTA ════════════════ --}}
@guest
<section class="cta-section py-6" style="padding: 5rem 0;">
    <div class="container text-center text-white py-2" style="position:relative;z-index:1;">
        <h2 class="fw-900" style="font-weight:900; font-size:2rem;">Prêt à prendre soin de votre santé ?</h2>
        <p class="lead mt-2 mb-4" style="color:rgba(255,255,255,0.85);">
            Rejoignez des patients qui gèrent leurs rendez-vous médicaux en ligne.
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('register') }}" class="btn-hero-white">
                <i class="fas fa-rocket me-2"></i>Commencer gratuitement
            </a>
            <a href="{{ route('login') }}" class="btn-hero-outline">
                <i class="fas fa-sign-in-alt me-2"></i>J'ai déjà un compte
            </a>
        </div>
    </div>
</section>
@endguest

{{-- ════════════════ FOOTER ════════════════ --}}
<footer class="footer-main py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-hospital-alt me-2 footer-brand-icon"></i>Gestion Med
                </h5>
                <p style="font-size:.9rem; line-height:1.7;">
                    Plateforme de réservation de services médicaux en ligne. Sécurisée, rapide et disponible 24h/24.
                </p>
                <div class="d-flex gap-2 mt-3">
                    <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <h6 class="fw-bold mb-3">Navigation</h6>
                <ul class="list-unstyled" style="font-size:.9rem;">
                    <li class="mb-2"><a href="/"><i class="fas fa-chevron-right me-1" style="font-size:.7rem;"></i>Accueil</a></li>
                    <li class="mb-2"><a href="/services"><i class="fas fa-chevron-right me-1" style="font-size:.7rem;"></i>Services</a></li>
                    <li class="mb-2"><a href="{{ route('login') }}"><i class="fas fa-chevron-right me-1" style="font-size:.7rem;"></i>Connexion</a></li>
                    <li class="mb-2"><a href="{{ route('register') }}"><i class="fas fa-chevron-right me-1" style="font-size:.7rem;"></i>Inscription</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6 class="fw-bold mb-3">Contact</h6>
                <ul class="list-unstyled" style="font-size:.9rem;">
                    <li class="mb-2">
                        <i class="fas fa-map-marker-alt me-2" style="color:var(--primary);"></i>Abidjan, Côte d'Ivoire
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-envelope me-2" style="color:var(--primary);"></i>contact@gestionmed.ci
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-phone me-2" style="color:var(--primary);"></i>+225 00 00 00 00
                    </li>
                </ul>
            </div>
        </div>
        <hr class="footer-divider mt-4 mb-3">
        <div class="text-center" style="font-size:.85rem;">
            &copy; {{ date('Y') }} <strong class="text-white">Gestion Med</strong> — Tous droits réservés.
        </div>
    </div>
</footer>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const t = document.querySelector(a.getAttribute('href'));
            if (t) { e.preventDefault(); window.scrollTo({ top: t.offsetTop - 72, behavior: 'smooth' }); }
        });
    });
    // Navbar scrolled class
    window.addEventListener('scroll', () => {
        document.getElementById('mainNav').classList.toggle('scrolled', window.scrollY > 30);
    });
</script>
</body>
</html>
