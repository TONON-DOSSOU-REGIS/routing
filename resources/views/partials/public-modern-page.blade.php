@php
    $locale = app()->getLocale();
    $brandName = 'Zuider Bank S.A';
    $primaryCtaRoute = $page['primary_cta_route'] ?? 'register';
    $secondaryCtaRoute = $page['secondary_cta_route'] ?? 'support.nous-contacter';
    $accent = $page['accent'] ?? '#0b5cff';
    $accentAlt = $page['accent_alt'] ?? '#00b8d9';
    $heroImage = $page['hero_image'] ?? asset('images/happy-bank-customers.jpg');
    $shared = __('public_pages.shared');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('partials.seo')
    @include('partials.favicon')
    @vite(['resources/css/app.css', 'resources/js/button-feedback.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-navy: #06172c;
            --brand-ink: #0f172a;
            --brand-muted: #607086;
            --brand-line: #d9e3ef;
            --brand-paper: #f5f8fc;
            --page-accent: {{ $accent }};
            --page-accent-alt: {{ $accentAlt }};
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: 'Manrope', sans-serif;
            color: var(--brand-ink);
            background: var(--brand-navy);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .modern-page {
            overflow: hidden;
            background:
                radial-gradient(circle at top left, rgba(11, 92, 255, 0.12), transparent 30%),
                linear-gradient(180deg, var(--brand-navy) 0%, var(--brand-navy) 16%, #f7faff 52%, #ffffff 100%);
        }

        .page-container {
            width: min(100% - 48px, 1320px);
            margin: 0 auto;
        }

        .modern-nav {
            position: sticky;
            top: 0;
            z-index: 70;
            background: rgba(6, 23, 44, 0.88);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .modern-nav-inner {
            min-height: 78px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .modern-brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: #ffffff;
            font-family: 'Sora', sans-serif;
            font-weight: 700;
        }

        .modern-brand img {
            width: 52px;
            height: 52px;
            object-fit: contain;
        }

        .modern-nav-links {
            display: flex;
            align-items: center;
            gap: 18px;
            color: rgba(255, 255, 255, 0.74);
            font-size: 0.94rem;
            font-weight: 700;
        }

        .modern-nav-links a:hover {
            color: #ffffff;
        }

        .modern-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modern-mobile-toggle {
            display: none;
            width: 46px;
            height: 46px;
            border: 0;
            border-radius: 50%;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.12);
            cursor: pointer;
        }

        body.modern-mobile-menu-active {
            overflow: hidden;
        }

        .modern-mobile-backdrop {
            position: fixed;
            inset: 0;
            z-index: 89;
            display: none;
            opacity: 0;
            background: rgba(2, 6, 23, 0.54);
            backdrop-filter: blur(10px);
            transition: opacity .32s ease;
        }

        .modern-mobile-backdrop.open {
            display: block;
            opacity: 1;
        }

        .modern-mobile-menu {
            position: fixed;
            top: 14px;
            right: 14px;
            bottom: 14px;
            z-index: 90;
            display: flex;
            flex-direction: column;
            width: min(88vw, 390px);
            padding: 18px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 32px;
            background:
                radial-gradient(circle at top right, rgba(0, 184, 217, 0.18), transparent 36%),
                linear-gradient(180deg, rgba(6, 23, 44, 0.98), rgba(6, 17, 31, 0.96));
            box-shadow: -28px 0 80px rgba(2, 6, 23, 0.34);
            backdrop-filter: blur(24px);
            opacity: 0;
            pointer-events: none;
            transform: translateX(112%);
            transition: transform .42s cubic-bezier(.22, 1, .36, 1), opacity .26s ease;
            will-change: transform, opacity;
        }

        .modern-mobile-menu.open {
            opacity: 1;
            pointer-events: auto;
            transform: translateX(0);
        }

        .modern-mobile-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 4px 2px 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .modern-mobile-close {
            width: 42px;
            height: 42px;
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 50%;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.1);
            cursor: pointer;
        }

        .modern-mobile-links,
        .modern-mobile-foot {
            display: grid;
            gap: 8px;
        }

        .modern-mobile-links {
            padding: 18px 0;
        }

        .modern-mobile-foot {
            margin-top: auto;
            padding-top: 18px;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
        }

        .modern-mobile-menu a {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 13px 14px;
            border: 1px solid transparent;
            border-radius: 18px;
            color: #ffffff;
            font-weight: 800;
            background: rgba(255, 255, 255, 0.05);
            transition: transform .2s ease, background .2s ease, border-color .2s ease;
        }

        .modern-mobile-menu a:hover {
            transform: translateX(-4px);
            border-color: rgba(255, 255, 255, 0.14);
            background: rgba(255, 255, 255, 0.1);
        }

        .btn-modern {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 48px;
            padding: 0 20px;
            border-radius: 999px;
            border: 1px solid transparent;
            font-weight: 800;
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
        }

        .btn-primary-modern {
            color: #ffffff;
            background: linear-gradient(135deg, var(--page-accent), var(--page-accent-alt));
            box-shadow: 0 18px 38px rgba(11, 92, 255, 0.26);
        }

        .btn-light-modern {
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.24);
            background: rgba(255, 255, 255, 0.08);
        }

        .btn-soft-modern {
            color: var(--brand-ink);
            background: #ffffff;
            border-color: var(--brand-line);
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        }

        .hero-modern {
            position: relative;
            min-height: 620px;
            display: flex;
            align-items: center;
            color: #ffffff;
            background:
                linear-gradient(90deg, rgba(6, 23, 44, 0.96) 0%, rgba(6, 23, 44, 0.84) 48%, rgba(6, 23, 44, 0.48) 100%),
                url('{{ $heroImage }}') center / cover no-repeat;
        }

        .hero-modern::before {
            content: "";
            position: absolute;
            inset: auto 0 0;
            height: 38%;
            background: linear-gradient(180deg, transparent, #ffffff);
            pointer-events: none;
        }

        .hero-grid {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: minmax(0, 1.1fr) minmax(360px, 0.72fr);
            align-items: center;
            gap: clamp(32px, 5vw, 64px);
            padding: clamp(58px, 8vw, 92px) 0;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 999px;
            color: #aeeeff;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.18);
            font-size: .78rem;
            text-transform: uppercase;
            letter-spacing: .18em;
            font-weight: 800;
        }

        .hero-title {
            max-width: 850px;
            margin: 22px 0 0;
            font-family: 'Sora', sans-serif;
            font-size: clamp(2.35rem, 4.6vw, 4.9rem);
            line-height: 1.04;
            letter-spacing: -0.055em;
        }

        .hero-lead {
            max-width: 720px;
            margin: 20px 0 0;
            color: rgba(255, 255, 255, 0.78);
            font-size: clamp(1rem, 1.18vw, 1.16rem);
            line-height: 1.72;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 34px;
        }

        .hero-card {
            position: relative;
            min-height: 390px;
            border-radius: 34px;
            padding: 26px;
            background:
                linear-gradient(145deg, rgba(255, 255, 255, 0.16), rgba(255, 255, 255, 0.06)),
                radial-gradient(circle at top right, rgba(142, 233, 255, 0.22), transparent 40%);
            border: 1px solid rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(18px);
            box-shadow: 0 40px 90px rgba(0, 0, 0, 0.28);
            overflow: hidden;
        }

        .hero-card::after {
            content: "";
            position: absolute;
            right: -22%;
            bottom: -18%;
            width: 340px;
            height: 340px;
            border-radius: 999px;
            background: rgba(0, 184, 217, 0.18);
            filter: blur(12px);
        }

        .hero-card-icon {
            position: relative;
            z-index: 1;
            width: 74px;
            height: 74px;
            display: grid;
            place-items: center;
            border-radius: 24px;
            background: linear-gradient(135deg, var(--page-accent), var(--page-accent-alt));
            color: #ffffff;
            font-size: 1.7rem;
        }

        .hero-card h2 {
            position: relative;
            z-index: 1;
            margin: 22px 0 0;
            font-family: 'Sora', sans-serif;
            font-size: clamp(1.55rem, 2.35vw, 2.35rem);
            line-height: 1.12;
            letter-spacing: -0.05em;
        }

        .hero-card p {
            position: relative;
            z-index: 1;
            margin: 18px 0 0;
            color: rgba(255, 255, 255, 0.76);
            line-height: 1.75;
        }

        .metrics-grid {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            margin-top: 30px;
        }

        .metric-card {
            padding: 18px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.14);
        }

        .metric-card strong {
            display: block;
            font-size: 1.5rem;
            color: #ffffff;
        }

        .metric-card span {
            display: block;
            margin-top: 6px;
            color: rgba(255, 255, 255, 0.66);
            font-size: .88rem;
            line-height: 1.45;
        }

        .section-modern {
            padding: clamp(58px, 6.5vw, 92px) 0;
        }

        .section-heading {
            max-width: 820px;
            margin-bottom: 42px;
        }

        .section-heading.center {
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }

        .section-kicker {
            display: inline-flex;
            gap: 10px;
            align-items: center;
            color: var(--page-accent);
            font-size: .78rem;
            text-transform: uppercase;
            letter-spacing: .18em;
            font-weight: 900;
        }

        .section-heading h2 {
            margin: 12px 0 0;
            font-family: 'Sora', sans-serif;
            font-size: clamp(1.85rem, 3.1vw, 3.25rem);
            line-height: 1.1;
            letter-spacing: -0.045em;
        }

        .section-heading p {
            margin: 18px 0 0;
            color: var(--brand-muted);
            font-size: 1rem;
            line-height: 1.72;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 24px;
        }

        .content-card {
            position: relative;
            min-height: 100%;
            padding: 24px;
            border-radius: 30px;
            background: #ffffff;
            border: 1px solid var(--brand-line);
            box-shadow: 0 24px 70px rgba(15, 23, 42, 0.07);
            overflow: hidden;
        }

        .content-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto;
            height: 4px;
            background: linear-gradient(90deg, var(--page-accent), var(--page-accent-alt));
        }

        .card-icon {
            width: 56px;
            height: 56px;
            display: grid;
            place-items: center;
            border-radius: 20px;
            color: #ffffff;
            background: linear-gradient(135deg, var(--page-accent), var(--page-accent-alt));
            font-size: 1.2rem;
        }

        .content-card h3 {
            margin: 22px 0 0;
            font-family: 'Sora', sans-serif;
            font-size: 1.18rem;
            letter-spacing: -0.03em;
        }

        .content-card p {
            margin: 14px 0 0;
            color: var(--brand-muted);
            line-height: 1.75;
        }

        .feature-list {
            display: grid;
            gap: 10px;
            margin: 20px 0 0;
            padding: 0;
            list-style: none;
        }

        .feature-list li {
            display: flex;
            gap: 10px;
            color: #334155;
            line-height: 1.55;
        }

        .feature-list i {
            margin-top: 4px;
            color: #12b76a;
        }

        .split-panel {
            display: grid;
            grid-template-columns: minmax(0, 0.9fr) minmax(0, 1.1fr);
            gap: 34px;
            align-items: stretch;
        }

        .dark-panel {
            position: relative;
            min-height: 100%;
            padding: clamp(30px, 4vw, 48px);
            border-radius: 34px;
            color: #ffffff;
            background:
                radial-gradient(circle at top right, rgba(142, 233, 255, 0.24), transparent 36%),
                linear-gradient(135deg, #06172c, #0b2443);
            overflow: hidden;
        }

        .dark-panel h2 {
            margin: 0;
            font-family: 'Sora', sans-serif;
            font-size: clamp(1.75rem, 2.8vw, 2.8rem);
            line-height: 1.1;
            letter-spacing: -0.05em;
        }

        .dark-panel p {
            margin: 18px 0 0;
            color: rgba(255, 255, 255, 0.76);
            line-height: 1.78;
        }

        .steps-list {
            display: grid;
            gap: 18px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .step-item {
            display: grid;
            grid-template-columns: 62px 1fr;
            gap: 18px;
            align-items: start;
            padding: 24px;
            border-radius: 28px;
            background: #ffffff;
            border: 1px solid var(--brand-line);
            box-shadow: 0 20px 54px rgba(15, 23, 42, 0.06);
        }

        .step-number {
            width: 62px;
            height: 62px;
            display: grid;
            place-items: center;
            border-radius: 22px;
            color: #ffffff;
            font-family: 'Sora', sans-serif;
            font-weight: 800;
            background: linear-gradient(135deg, var(--page-accent), var(--page-accent-alt));
        }

        .step-item h3 {
            margin: 0;
            font-family: 'Sora', sans-serif;
        }

        .step-item p {
            margin: 8px 0 0;
            color: var(--brand-muted);
            line-height: 1.7;
        }

        .faq-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .faq-card {
            padding: 24px;
            border-radius: 26px;
            background: #ffffff;
            border: 1px solid var(--brand-line);
        }

        .faq-card h3 {
            margin: 0;
            font-family: 'Sora', sans-serif;
            font-size: 1.08rem;
        }

        .faq-card p {
            margin: 12px 0 0;
            color: var(--brand-muted);
            line-height: 1.7;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: minmax(0, .86fr) minmax(420px, 1fr);
            gap: 28px;
            align-items: start;
        }

        .contact-form {
            padding: 30px;
            border-radius: 32px;
            background: #ffffff;
            border: 1px solid var(--brand-line);
            box-shadow: 0 24px 70px rgba(15, 23, 42, 0.08);
        }

        .field-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .field {
            margin-bottom: 16px;
        }

        .field label {
            display: block;
            margin-bottom: 8px;
            color: #334155;
            font-weight: 800;
            font-size: .86rem;
        }

        .field input,
        .field select,
        .field textarea {
            width: 100%;
            border: 1px solid #cfd9e6;
            border-radius: 18px;
            padding: 14px 16px;
            font: inherit;
            color: var(--brand-ink);
            background: #f8fafc;
        }

        .field textarea {
            min-height: 150px;
            resize: vertical;
        }

        .legal-grid {
            display: grid;
            gap: 18px;
        }

        .legal-item {
            padding: 28px;
            border-radius: 28px;
            background: #ffffff;
            border: 1px solid var(--brand-line);
        }

        .legal-item h3 {
            margin: 0;
            font-family: 'Sora', sans-serif;
        }

        .legal-item p {
            margin: 12px 0 0;
            color: var(--brand-muted);
            line-height: 1.75;
        }

        .cta-modern {
            padding: clamp(36px, 4.5vw, 58px);
            border-radius: 36px;
            color: #ffffff;
            background:
                linear-gradient(90deg, rgba(6, 23, 44, 0.96), rgba(11, 92, 255, 0.76)),
                url('{{ asset('images/zuider-card-3d-hero.png') }}') right center / min(54vw, 720px) auto no-repeat;
            overflow: hidden;
        }

        .cta-modern h2 {
            max-width: 720px;
            margin: 0;
            font-family: 'Sora', sans-serif;
            font-size: clamp(1.9rem, 3.2vw, 3.2rem);
            line-height: 1.1;
            letter-spacing: -0.045em;
        }

        .cta-modern p {
            max-width: 620px;
            margin: 18px 0 30px;
            color: rgba(255, 255, 255, 0.78);
            line-height: 1.76;
        }

        .modern-footer {
            padding: 42px 0;
            color: rgba(255, 255, 255, 0.68);
            background: #06111f;
        }

        .footer-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        @media (max-width: 1080px) {
            .modern-nav-links,
            .modern-actions .btn-light-modern {
                display: none;
            }

            .modern-mobile-toggle {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .hero-grid,
            .split-panel,
            .contact-grid {
                grid-template-columns: 1fr;
            }

            .hero-modern {
                min-height: auto;
            }

            .cards-grid,
            .faq-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 720px) {
            .page-container {
                width: min(100% - 28px, 1320px);
            }

            .modern-nav-inner {
                min-height: 68px;
            }

            .modern-brand img {
                width: 44px;
                height: 44px;
            }

            .hero-grid {
                padding: 46px 0 64px;
            }

            .hero-title {
                font-size: clamp(2rem, 10vw, 2.85rem);
                letter-spacing: -0.045em;
            }

            .hero-lead {
                font-size: 0.98rem;
                line-height: 1.66;
            }

            .section-heading h2,
            .cta-modern h2 {
                font-size: clamp(1.7rem, 8vw, 2.35rem);
            }

            .hero-card {
                min-height: auto;
            }

            .cards-grid,
            .faq-grid,
            .field-grid,
            .metrics-grid {
                grid-template-columns: 1fr;
            }

            .contact-grid {
                display: block;
            }

            .contact-form {
                margin-top: 20px;
                padding: 22px;
            }
        }
    </style>
</head>
<body>
    @include('partials.site-launch-loader')
<div class="modern-page">
    <header class="modern-nav">
        <div class="page-container modern-nav-inner">
            <a class="modern-brand" href="{{ localized_route('home', ['locale' => $locale]) }}">
                <img src="{{ asset('images/zuider-logo-white.png') }}" alt="{{ $brandName }}">
                <span>{{ $brandName }}</span>
            </a>
            <nav class="modern-nav-links" aria-label="Navigation principale">
                <a href="{{ localized_route('home', ['locale' => $locale]) }}">{{ $shared['nav_home'] }}</a>
                <a href="{{ localized_route('services.comptes-professionnels', ['locale' => $locale]) }}">{{ $shared['nav_services'] }}</a>
                <a href="{{ localized_route('about.notre-histoire', ['locale' => $locale]) }}">{{ $shared['nav_about'] }}</a>
                <a href="{{ localized_route('support.centre-aide', ['locale' => $locale]) }}">{{ $shared['nav_support'] }}</a>
            </nav>
            <div class="modern-actions">
                <a class="btn-modern btn-light-modern" href="{{ localized_route('login', ['locale' => $locale]) }}">{{ $shared['client_area'] }}</a>
                <a class="btn-modern btn-primary-modern" href="{{ localized_route('register', ['locale' => $locale]) }}">{{ $shared['open_account'] }}</a>
            </div>
            <button class="modern-mobile-toggle" type="button" id="modern-mobile-menu-button" aria-label="Ouvrir le menu" aria-controls="modern-mobile-menu" aria-expanded="false">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <div class="modern-mobile-backdrop" id="modern-mobile-backdrop"></div>
        <div class="modern-mobile-menu" id="modern-mobile-menu" aria-hidden="true">
            <div class="modern-mobile-head">
                <a class="modern-brand" href="{{ localized_route('home', ['locale' => $locale]) }}">
                    <img src="{{ asset('images/zuider-logo-white.png') }}" alt="{{ $brandName }}">
                    <span>{{ $brandName }}</span>
                </a>
                <button class="modern-mobile-close" type="button" id="modern-mobile-menu-close" aria-label="Fermer le menu">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modern-mobile-links">
                <a href="{{ localized_route('home', ['locale' => $locale]) }}">{{ $shared['nav_home'] }} <i class="fas fa-arrow-left"></i></a>
                <a href="{{ localized_route('services.comptes-professionnels', ['locale' => $locale]) }}">{{ $shared['nav_services'] }} <i class="fas fa-arrow-left"></i></a>
                <a href="{{ localized_route('about.notre-histoire', ['locale' => $locale]) }}">{{ $shared['nav_about'] }} <i class="fas fa-arrow-left"></i></a>
                <a href="{{ localized_route('support.centre-aide', ['locale' => $locale]) }}">{{ $shared['nav_support'] }} <i class="fas fa-arrow-left"></i></a>
            </div>
            <div class="modern-mobile-foot">
                <a href="{{ localized_route('login', ['locale' => $locale]) }}">{{ $shared['client_area'] }}</a>
                <a href="{{ localized_route('register', ['locale' => $locale]) }}">{{ $shared['open_account'] }}</a>
            </div>
        </div>
    </header>

    <main>
        <section class="hero-modern">
            <div class="page-container hero-grid">
                <div>
                    <span class="eyebrow"><i class="{{ $page['eyebrow_icon'] ?? 'fas fa-sparkles' }}"></i>{{ $page['eyebrow'] }}</span>
                    <h1 class="hero-title">{{ $page['title'] }}</h1>
                    <p class="hero-lead">{{ $page['subtitle'] }}</p>
                    <div class="hero-actions">
                        <a class="btn-modern btn-primary-modern" href="{{ localized_route($primaryCtaRoute, ['locale' => $locale]) }}">
                            {{ $page['primary_cta'] ?? $shared['open_account'] }} <i class="fas fa-arrow-right"></i>
                        </a>
                        <a class="btn-modern btn-light-modern" href="{{ localized_route($secondaryCtaRoute, ['locale' => $locale]) }}">
                            {{ $page['secondary_cta'] ?? $shared['nav_support'] }}
                        </a>
                    </div>
                </div>
                <aside class="hero-card">
                    <div class="hero-card-icon"><i class="{{ $page['hero_icon'] ?? 'fas fa-landmark' }}"></i></div>
                    <h2>{{ $page['hero_card_title'] }}</h2>
                    <p>{{ $page['hero_card_text'] }}</p>
                    <div class="metrics-grid">
                        @foreach($page['metrics'] ?? [] as $metric)
                            <div class="metric-card">
                                <strong>{{ $metric['value'] }}</strong>
                                <span>{{ $metric['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </aside>
            </div>
        </section>

        @if(!empty($page['cards']))
            <section class="section-modern">
                <div class="page-container">
                    <div class="section-heading center">
                        <span class="section-kicker"><i class="fas fa-layer-group"></i>{{ $page['cards_kicker'] ?? $shared['nav_services'] }}</span>
                        <h2>{{ $page['cards_title'] }}</h2>
                        <p>{{ $page['cards_intro'] }}</p>
                    </div>
                    <div class="cards-grid">
                        @foreach($page['cards'] as $card)
                            <article class="content-card">
                                <div class="card-icon"><i class="{{ $card['icon'] }}"></i></div>
                                <h3>{{ $card['title'] }}</h3>
                                <p>{{ $card['text'] }}</p>
                                @if(!empty($card['items']))
                                    <ul class="feature-list">
                                        @foreach($card['items'] as $item)
                                            <li><i class="fas fa-check-circle"></i><span>{{ $item }}</span></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @if(!empty($page['steps']))
            <section class="section-modern" style="background: var(--brand-paper);">
                <div class="page-container split-panel">
                    <div class="dark-panel">
                        <span class="section-kicker" style="color:#8ee9ff;"><i class="fas fa-bolt"></i>{{ $page['steps_kicker'] ?? $shared['nav_services'] }}</span>
                        <h2>{{ $page['steps_title'] }}</h2>
                        <p>{{ $page['steps_intro'] }}</p>
                    </div>
                    <ol class="steps-list">
                        @foreach($page['steps'] as $step)
                            <li class="step-item">
                                <span class="step-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                <div>
                                    <h3>{{ $step['title'] }}</h3>
                                    <p>{{ $step['text'] }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </section>
        @endif

        @if(!empty($page['legal_items']))
            <section class="section-modern">
                <div class="page-container">
                    <div class="section-heading">
                        <span class="section-kicker"><i class="fas fa-scale-balanced"></i>{{ $page['legal_kicker'] ?? $shared['nav_support'] }}</span>
                        <h2>{{ $page['legal_title'] }}</h2>
                        <p>{{ $page['legal_intro'] }}</p>
                    </div>
                    <div class="legal-grid">
                        @foreach($page['legal_items'] as $item)
                            <article class="legal-item">
                                <h3>{{ $item['title'] }}</h3>
                                <p>{{ $item['text'] }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @if(!empty($page['contact']))
            <section class="section-modern">
                <div class="page-container contact-grid">
                    <div>
                        <div class="section-heading">
                            <span class="section-kicker"><i class="fas fa-headset"></i>{{ $page['contact']['kicker'] }}</span>
                            <h2>{{ $page['contact']['title'] }}</h2>
                            <p>{{ $page['contact']['intro'] }}</p>
                        </div>
                        <div class="cards-grid" style="grid-template-columns:1fr;">
                            @foreach($page['contact']['cards'] as $card)
                                <article class="content-card">
                                    <div class="card-icon"><i class="{{ $card['icon'] }}"></i></div>
                                    <h3>{{ $card['title'] }}</h3>
                                    <p>{{ $card['text'] }}</p>
                                </article>
                            @endforeach
                        </div>
                    </div>
                    <form method="POST" action="{{ localized_route('support.nous-contacter.store', ['locale' => $locale]) }}" class="contact-form">
                        @csrf
                        <div class="field-grid">
                            <div class="field">
                                <label for="first_name">{{ $shared['first_name'] }}</label>
                                <input id="first_name" name="first_name" type="text" required>
                            </div>
                            <div class="field">
                                <label for="last_name">{{ $shared['last_name'] }}</label>
                                <input id="last_name" name="last_name" type="text" required>
                            </div>
                        </div>
                        <div class="field-grid">
                            <div class="field">
                                <label for="email">{{ $shared['email'] }}</label>
                                <input id="email" name="email" type="email" required>
                            </div>
                            <div class="field">
                                <label for="phone">{{ $shared['phone'] }}</label>
                                <input id="phone" name="phone" type="tel">
                            </div>
                        </div>
                        <div class="field">
                            <label for="subject">{{ $shared['subject'] }}</label>
                            <select id="subject" name="subject" required>
                                <option value="">{{ $shared['choose_subject'] }}</option>
                                <option value="support">{{ $shared['subject_support'] }}</option>
                                <option value="commercial">{{ $shared['subject_commercial'] }}</option>
                                <option value="partnership">{{ $shared['subject_partnership'] }}</option>
                                <option value="press">{{ $shared['subject_press'] }}</option>
                                <option value="other">{{ $shared['subject_other'] }}</option>
                            </select>
                        </div>
                        <div class="field">
                            <label for="message">{{ $shared['message'] }}</label>
                            <textarea id="message" name="message" required placeholder="{{ $shared['message_placeholder'] }}"></textarea>
                        </div>
                        <div class="field">
                            <label style="display:flex;align-items:flex-start;gap:10px;font-weight:600;color:var(--brand-muted);">
                                <input type="checkbox" name="privacy_accepted" required style="width:auto;margin-top:4px;">
                                <span>{{ $shared['privacy_notice'] }}</span>
                            </label>
                        </div>
                        <button class="btn-modern btn-primary-modern" type="submit" style="width:100%;">{{ $shared['send_request'] }} <i class="fas fa-arrow-right"></i></button>
                    </form>
                </div>
            </section>
        @endif

        @if(!empty($page['faq']))
            <section class="section-modern" style="background: var(--brand-paper);">
                <div class="page-container">
                    <div class="section-heading center">
                        <span class="section-kicker"><i class="fas fa-circle-question"></i>{{ $page['faq_kicker'] ?? 'FAQ' }}</span>
                        <h2>{{ $page['faq_title'] ?? $shared['nav_support'] }}</h2>
                        <p>{{ $page['faq_intro'] ?? ($page['subtitle'] ?? '') }}</p>
                    </div>
                    <div class="faq-grid">
                        @foreach($page['faq'] as $faq)
                            <article class="faq-card">
                                <h3>{{ $faq['question'] }}</h3>
                                <p>{{ $faq['answer'] }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <section class="section-modern">
            <div class="page-container">
                <div class="cta-modern">
                    <h2>{{ $page['cta_title'] ?? $shared['open_account'] }}</h2>
                    <p>{{ $page['cta_text'] ?? ($page['subtitle'] ?? '') }}</p>
                    <a class="btn-modern btn-primary-modern" href="{{ localized_route($primaryCtaRoute, ['locale' => $locale]) }}">
                        {{ $page['primary_cta'] ?? $shared['open_account'] }} <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <footer class="modern-footer">
        <div class="page-container footer-row">
            <a class="modern-brand" href="{{ localized_route('home', ['locale' => $locale]) }}">
                <img src="{{ asset('images/zuider-logo-white.png') }}" alt="{{ $brandName }}">
                <span>{{ $brandName }}</span>
            </a>
            <p>&copy; {{ date('Y') }} {{ $brandName }}. {{ $shared['rights'] }}</p>
        </div>
    </footer>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('modern-mobile-menu-button');
        const menu = document.getElementById('modern-mobile-menu');
        const close = document.getElementById('modern-mobile-menu-close');
        const backdrop = document.getElementById('modern-mobile-backdrop');

        if (!toggle || !menu) return;

        const setMobileMenu = function (isOpen) {
            menu.classList.toggle('open', isOpen);
            backdrop?.classList.toggle('open', isOpen);
            document.body.classList.toggle('modern-mobile-menu-active', isOpen);
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            menu.setAttribute('aria-hidden', isOpen ? 'false' : 'true');

            const icon = toggle.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-bars', !isOpen);
                icon.classList.toggle('fa-times', isOpen);
            }
        };

        toggle.addEventListener('click', function () {
            setMobileMenu(!menu.classList.contains('open'));
        });

        close?.addEventListener('click', function () {
            setMobileMenu(false);
        });

        backdrop?.addEventListener('click', function () {
            setMobileMenu(false);
        });

        menu.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                setMobileMenu(false);
            });
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                setMobileMenu(false);
            }
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth >= 769) setMobileMenu(false);
        });
        window.addEventListener('pageshow', function () { setMobileMenu(false); });
        window.addEventListener('pagehide', function () { setMobileMenu(false); });
    });
</script>
</body>
</html>
