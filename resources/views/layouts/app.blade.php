<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        html,
        body {
            margin: 0;
            background-color: #03101f;
        }
    </style>

    @include('partials.seo')
    @include('partials.favicon')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" media="print" onload="this.media='all'" />
    <noscript><link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /></noscript>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        #site-launch-loader {
            position: fixed;
            inset: 0;
            z-index: 99999;
            pointer-events: none;
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

        #site-launch-loader.is-leaving {
            opacity: 1;
            visibility: visible;
            transition: none;
        }

        .site-launch-loader__glow {
            position: absolute;
            width: min(70vw, 26rem);
            aspect-ratio: 1;
            border-radius: 999px;
            background: radial-gradient(circle, rgba(0, 184, 217, .16), transparent 70%);
            filter: blur(4px);
            animation: siteLoaderPulse 2.4s ease-in-out infinite;
        }

        .site-launch-loader__content {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.1rem;
            padding: 2rem;
            color: #fff;
            text-align: center;
        }

        .site-launch-loader__mark {
            position: relative;
            display: grid;
            width: 11rem;
            place-items: center;
            animation: siteLoaderFloat 2.4s ease-in-out infinite;
        }

        .site-launch-loader__mark img {
            width: 100%;
            height: auto;
            object-fit: contain;
            filter: drop-shadow(0 12px 24px rgba(0, 0, 0, .3));
        }

        .site-launch-loader__spinner {
            width: 2.1rem;
            height: 2.1rem;
            border-radius: 999px;
            border: 3px solid rgba(255, 255, 255, .18);
            border-top-color: #72e8ff;
            animation: siteLoaderSpin .8s linear infinite;
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

        @keyframes siteLoaderSpin { to { transform: rotate(360deg); } }
        @keyframes siteLoaderFloat { 50% { transform: translateY(-6px); } }
        @keyframes siteLoaderPulse { 50% { transform: scale(1.08); opacity: .5; } }

        @media (prefers-reduced-motion: reduce) {
            #site-launch-loader,
            .site-launch-loader__glow,
            .site-launch-loader__mark,
            .site-launch-loader__spinner {
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
                <img src="{{ asset('images/zuider-logo-white.png') }}" alt="Zuider Bank S.A">
            </div>
            <div class="site-launch-loader__spinner" aria-hidden="true"></div>
            <p class="site-launch-loader__status">Initialisation sécurisée</p>
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

            const hideLoader = () => {
                loader.classList.remove('is-leaving');
                loader.classList.add('is-ready');
            };
            const showLoader = () => {
                loader.classList.remove('is-ready');
                loader.classList.add('is-leaving');
            };
            const hideWhenReady = () => {
                window.requestAnimationFrame(() => window.requestAnimationFrame(hideLoader));
            };

            // Hard safety net: never let the loader stay stuck, even if rAF is
            // throttled/skipped (backgrounded tab, some mobile browsers).
            const hardTimeout = window.setTimeout(hideLoader, 4000);

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', hideWhenReady, { once: true });
            } else {
                hideWhenReady();
            }

            window.addEventListener('load', () => {
                window.clearTimeout(hardTimeout);
                hideLoader();
            }, { once: true });

            document.addEventListener('click', (event) => {
                if (event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;

                const link = event.target.closest('a[href]');
                if (!link || link.target === '_blank' || link.hasAttribute('download') || link.hasAttribute('data-ui-no-loading')) return;

                const url = new URL(link.href, window.location.href);
                const isSameDocumentAnchor = url.origin === window.location.origin
                    && url.pathname === window.location.pathname
                    && url.search === window.location.search
                    && url.hash;

                if (url.origin !== window.location.origin || isSameDocumentAnchor) return;

                queueMicrotask(() => {
                    if (!event.defaultPrevented) showLoader();
                });
            });

            document.addEventListener('submit', (event) => {
                queueMicrotask(() => {
                    if (!event.defaultPrevented) showLoader();
                });
            });

            window.addEventListener('pageshow', hideWhenReady);
            window.addEventListener('beforeunload', showLoader);
        })();
    </script>
</body>
</html>
