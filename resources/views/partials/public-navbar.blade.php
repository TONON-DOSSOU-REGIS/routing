@php
    // Shared public navigation. Section links only work on the home page, so on
    // inner pages they are rewritten to point back at the home page anchors.
    $navLocale = $navLocale ?? app()->getLocale();
    $isHomePage = request()->routeIs('home');
    $homeUrl = localized_route('home', ['locale' => $navLocale]);
    $anchor = fn (string $hash) => $isHomePage ? $hash : $homeUrl . $hash;

    $navItems = [
        ['label' => __('home.nav_home'), 'href' => $isHomePage ? '#home' : $homeUrl],
        ['label' => __('home.nav_about'), 'href' => $anchor('#about')],
        ['label' => __('home.nav_services'), 'href' => $anchor('#services')],
        ['label' => __('home.nav_cards'), 'href' => $anchor('#cards')],
        ['label' => __('home.partners_title'), 'href' => $anchor('#partners')],
        ['label' => __('home.nav_faq'), 'href' => $anchor('#faq')],
    ];

    $mobileNavItems = array_merge($navItems, [
        ['label' => __('home.trustpilot_badge'), 'href' => $anchor('#trustpilot')],
    ]);
@endphp

<header class="bank-nav">
    <div class="container-bank">
        <div class="bank-nav-inner">
            <a class="brand-mark" href="{{ $homeUrl }}">
                <img src="{{ asset('images/zuider-logo-white.png') }}" alt="Zuider Bank S.A" width="220" height="50">
                <span>Zuider Bank S.A</span>
            </a>

            <nav class="nav-links" aria-label="Navigation principale">
                @foreach($navItems as $item)
                    <a href="{{ $item['href'] }}">{{ $item['label'] }}</a>
                @endforeach
            </nav>

            <div class="nav-actions">
                @include('components.language-selector')
                <a class="btn btn-outline" href="{{ localized_route('login', ['locale' => $navLocale]) }}">{{ __('home.nav_login') }}</a>
                <a class="btn btn-primary" href="{{ localized_route('register', ['locale' => $navLocale]) }}">{{ __('home.nav_register') }}</a>
            </div>

            <button class="mobile-toggle" type="button" id="mobile-menu-button" aria-label="Ouvrir le menu" aria-controls="mobile-menu" aria-expanded="false">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <div class="mobile-menu-backdrop" id="mobile-menu-backdrop"></div>
        <div class="mobile-menu" id="mobile-menu" aria-hidden="true">
            <div class="mobile-menu-head">
                <span class="mobile-menu-brand">
                    <img src="{{ asset('images/zuider-logo-white.png') }}" alt="Zuider Bank S.A" width="42" height="42">
                    <span>Zuider Bank S.A</span>
                </span>
                <button class="mobile-close" type="button" id="mobile-menu-close" aria-label="Fermer le menu">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="mobile-menu-links">
                @foreach($mobileNavItems as $item)
                    <a href="{{ $item['href'] }}">{{ $item['label'] }} <i class="fas fa-arrow-left"></i></a>
                @endforeach
            </div>

            <div class="mobile-menu-foot">
                @include('components.language-selector')
                <a class="mobile-auth-link" href="{{ localized_route('login', ['locale' => $navLocale]) }}">{{ __('home.nav_login') }}</a>
                <a class="mobile-auth-link" href="{{ localized_route('register', ['locale' => $navLocale]) }}">{{ __('home.nav_register') }}</a>
            </div>
        </div>
    </div>
</header>
