<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('partials.seo')
    @include('partials.favicon')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        #site-launch-loader {
            position: fixed;
            inset: 0;
            z-index: 99999;
            display: grid;
            place-items: center;
            overflow: hidden;
            background:
                radial-gradient(circle at 50% 35%, rgba(0, 184, 217, .18), transparent 28%),
                linear-gradient(145deg, #03101f 0%, #071d35 52%, #0b5cff 150%);
            opacity: 1;
            visibility: visible;
            transition: opacity .45s ease, visibility .45s ease;
        }

        #site-launch-loader.is-ready {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .site-launch-loader__glow {
            position: absolute;
            width: min(78vw, 34rem);
            aspect-ratio: 1;
            border: 1px solid rgba(140, 239, 255, .18);
            border-radius: 999px;
            box-shadow: 0 0 90px rgba(0, 184, 217, .16), inset 0 0 90px rgba(11, 92, 255, .12);
            animation: siteLoaderPulse 2.2s ease-in-out infinite;
        }

        .site-launch-loader__content {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            padding: 2rem;
            color: #fff;
            text-align: center;
        }

        .site-launch-loader__mark {
            position: relative;
            display: grid;
            width: 6.75rem;
            height: 6.75rem;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 2rem;
            background: rgba(255, 255, 255, .1);
            box-shadow: 0 24px 60px rgba(0, 0, 0, .26), inset 0 1px 0 rgba(255, 255, 255, .22);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            animation: siteLoaderFloat 2.4s ease-in-out infinite;
        }

        .site-launch-loader__mark::before {
            content: "";
            position: absolute;
            inset: -.55rem;
            border: 2px solid rgba(118, 231, 255, .7);
            border-top-color: transparent;
            border-radius: 2.35rem;
            animation: siteLoaderSpin 1.4s linear infinite;
        }

        .site-launch-loader__mark img {
            width: 4.25rem;
            height: 4.25rem;
            object-fit: contain;
            filter: drop-shadow(0 8px 16px rgba(0, 0, 0, .22));
        }

        .site-launch-loader__brand {
            margin: 0;
            font-family: Manrope, ui-sans-serif, system-ui, sans-serif;
            font-size: clamp(1.2rem, 3vw, 1.55rem);
            font-weight: 800;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .site-launch-loader__status {
            margin: 0;
            color: rgba(226, 244, 255, .72);
            font-family: Manrope, ui-sans-serif, system-ui, sans-serif;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .22em;
            text-transform: uppercase;
        }

        .site-launch-loader__progress {
            width: min(12rem, 58vw);
            height: .2rem;
            overflow: hidden;
            border-radius: 999px;
            background: rgba(255, 255, 255, .16);
        }

        .site-launch-loader__progress span {
            display: block;
            width: 42%;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, #72e8ff, #fff);
            box-shadow: 0 0 16px rgba(114, 232, 255, .8);
            animation: siteLoaderProgress 1.1s ease-in-out infinite;
        }

        @keyframes siteLoaderSpin { to { transform: rotate(360deg); } }
        @keyframes siteLoaderFloat { 50% { transform: translateY(-5px); } }
        @keyframes siteLoaderPulse { 50% { transform: scale(1.04); opacity: .68; } }
        @keyframes siteLoaderProgress { 0% { transform: translateX(-125%); } 100% { transform: translateX(310%); } }

        @media (prefers-reduced-motion: reduce) {
            #site-launch-loader,
            .site-launch-loader__glow,
            .site-launch-loader__mark,
            .site-launch-loader__mark::before,
            .site-launch-loader__progress span {
                animation: none;
            }
        }
    </style>

    <!-- Additional head content -->
    @stack('head')
</head>
<body class="antialiased">
    <div id="site-launch-loader" role="status" aria-live="polite" aria-label="Chargement du site">
        <div class="site-launch-loader__glow" aria-hidden="true"></div>
        <div class="site-launch-loader__content">
            <div class="site-launch-loader__mark">
                <img src="{{ asset('images/Logosite.png') }}" alt="Zuider Bank S.A">
            </div>
            <p class="site-launch-loader__brand">Zuider Bank S.A</p>
            <p class="site-launch-loader__status">Initialisation sécurisée</p>
            <div class="site-launch-loader__progress" aria-hidden="true"><span></span></div>
        </div>
    </div>

    <div id="app">
        @yield('content')
    </div>

    <!-- Additional body content -->
    @stack('scripts')

    <script>
        (() => {
            const loader = document.getElementById('site-launch-loader');
            if (!loader) return;

            const hideLoader = () => loader.classList.add('is-ready');
            const revealTimer = window.setTimeout(hideLoader, 850);

            if (document.readyState === 'complete') {
                window.clearTimeout(revealTimer);
                window.requestAnimationFrame(hideLoader);
            } else {
                window.addEventListener('load', () => {
                    window.clearTimeout(revealTimer);
                    window.setTimeout(hideLoader, 180);
                }, { once: true });
            }
        })();
    </script>
</body>
</html>
