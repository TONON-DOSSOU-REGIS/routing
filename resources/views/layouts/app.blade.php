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
            /* Neutral, close to every inner page's real background so the
               brief gap between navigations never flashes a jarring color. */
            background-color: #f5f8fc;
        }

        /* Soften the unavoidable gap between navigations: instead of the raw
           background flashing before paint, content eases in. Kept tiny so it
           never feels like a "loading" step. */
        #app {
            animation: appEnter .22s ease-out both;
        }

        @keyframes appEnter {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @media (prefers-reduced-motion: reduce) {
            #app { animation: none; }
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

    <!-- Additional head content -->
    @stack('head')
</head>
<body class="antialiased">
    <div id="app">
        @yield('content')
    </div>

    @include('components.cookie-consent')

    <!-- Additional body content -->
    @stack('scripts')
</body>
</html>
