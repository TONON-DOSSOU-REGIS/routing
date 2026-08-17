@php
    $footerLocale = app()->getLocale();
    $footerServices = [
        ['route' => 'services.comptes-professionnels', 'title' => __('home.services_1_title')],
        ['route' => 'services.virements-internationaux', 'title' => __('home.services_2_title')],
        ['route' => 'services.gestion-tresorerie', 'title' => __('home.services_3_title')],
        ['route' => 'services.cartes-paiement', 'title' => __('home.services_4_title')],
    ];
@endphp

<style>
    .bank-footer {
        padding: 64px 0 34px;
        color: rgba(255, 255, 255, 0.7);
        background: #06111f;
        font-family: 'Inter', sans-serif;
    }

    .bank-footer > .container-bank {
        width: min(1440px, calc(100% - clamp(24px, 4vw, 56px)));
        margin: 0 auto;
    }

    .footer-grid {
        display: grid;
        grid-template-columns: 1.25fr repeat(3, 0.72fr);
        gap: 32px;
    }

    .bank-footer h3 {
        margin: 0 0 16px;
        color: #ffffff;
        font-size: 1rem;
        font-weight: 800;
    }

    .bank-footer ul {
        display: grid;
        gap: 10px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .bank-footer a {
        color: rgba(255, 255, 255, 0.68);
    }

    .footer-description {
        max-width: 380px;
        margin: 18px 0 0;
        line-height: 1.7;
    }

    .footer-phone {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-top: 20px;
        padding: 10px 14px;
        border: 1px solid rgba(255, 255, 255, 0.14);
        border-radius: 12px;
        color: #ffffff !important;
        background: rgba(255, 255, 255, 0.06);
        font-weight: 700;
        letter-spacing: 0.02em;
        transition: border-color 180ms ease, background-color 180ms ease, transform 180ms ease;
    }

    .footer-phone:hover,
    .footer-phone:focus-visible {
        border-color: rgba(255, 255, 255, 0.35);
        background: rgba(255, 255, 255, 0.11);
        transform: translateY(-1px);
    }

    .footer-phone-flag {
        width: 24px;
        height: 18px;
        overflow: hidden;
        flex: 0 0 auto;
        border-radius: 3px;
        box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.16);
    }

    .footer-bottom {
        margin-top: 42px;
        padding-top: 24px;
        border-top: 1px solid rgba(255, 255, 255, 0.12);
        font-size: 0.92rem;
    }

    @media (max-width: 1080px) {
        .bank-footer > .container-bank {
            width: min(100% - 32px, 1440px);
        }

        .footer-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 700px) {
        .bank-footer > .container-bank {
            width: min(100% - 18px, 1440px);
        }

        .footer-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .footer-phone {
            transition: none;
        }
    }
</style>

<footer class="bank-footer" data-public-footer>
    <div class="container-bank">
        <div class="footer-grid">
            <div>
                <a class="brand-mark" href="{{ localized_route('home', ['locale' => $footerLocale]) }}">
                    <img src="{{ asset('images/nexalune-logo-white.png') }}" alt="NEXALUNE BANK">
                    <span>NEXALUNE BANK</span>
                </a>
                <p class="footer-description">{{ __('home.footer_description') }}</p>
                <a class="footer-phone" href="tel:+33635786812" aria-label="{{ __('support.contact_phone') }} : {{ __('support.contact_phone_number') }}">
                    <svg class="footer-phone-flag" viewBox="0 0 3 2" aria-hidden="true" focusable="false">
                        <path fill="#002654" d="M0 0h1v2H0z"/>
                        <path fill="#fff" d="M1 0h1v2H1z"/>
                        <path fill="#CE1126" d="M2 0h1v2H2z"/>
                    </svg>
                    <span>{{ __('support.contact_phone_number') }}</span>
                </a>
            </div>

            <div>
                <h3>{{ __('home.footer_services') }}</h3>
                <ul>
                    @foreach ($footerServices as $service)
                        <li><a href="{{ localized_route($service['route'], ['locale' => $footerLocale]) }}">{{ $service['title'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h3>{{ __('home.footer_about') }}</h3>
                <ul>
                    <li><a href="{{ localized_route('about.notre-histoire', ['locale' => $footerLocale]) }}">{{ __('home.footer_our_story') }}</a></li>
                    <li><a href="{{ localized_route('about.carrieres', ['locale' => $footerLocale]) }}">{{ __('home.footer_careers') }}</a></li>
                    <li><a href="{{ localized_route('about.presse', ['locale' => $footerLocale]) }}">{{ __('home.footer_press') }}</a></li>
                    <li><a href="{{ localized_route('about.blog', ['locale' => $footerLocale]) }}">{{ __('home.footer_blog') }}</a></li>
                </ul>
            </div>

            <div>
                <h3>{{ __('home.footer_support') }}</h3>
                <ul>
                    <li><a href="{{ localized_route('support.centre-aide', ['locale' => $footerLocale]) }}">{{ __('home.footer_help_center') }}</a></li>
                    <li><a href="{{ localized_route('support.nous-contacter', ['locale' => $footerLocale]) }}">{{ __('home.footer_contact_us') }}</a></li>
                    <li><a href="{{ localized_route('support.securite', ['locale' => $footerLocale]) }}">{{ __('home.footer_security') }}</a></li>
                    <li><a href="{{ localized_route('support.mentions-legales', ['locale' => $footerLocale]) }}">{{ __('home.footer_legal') }}</a></li>
                    <li><a href="{{ localized_route('support.politique-cookies', ['locale' => $footerLocale]) }}">{{ __('cookies.footer_link_label') }}</a></li>
                    <li><a href="#" data-cookie-open-preferences>{{ __('cookies.manage_preferences_link') }}</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} NEXALUNE BANK. {{ __('home.footer_copyright') }}</p>
            <p>{{ __('home.footer_disclaimer') }}</p>
        </div>
    </div>
</footer>
