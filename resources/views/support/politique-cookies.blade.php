@php
    $locale = app()->getLocale();
    $cookieRows = [
        ['name' => __('cookies.cookie_session_name'), 'purpose' => __('cookies.cookie_session_purpose'), 'duration' => __('cookies.cookie_session_duration'), 'category' => __('cookies.category_necessary_title')],
        ['name' => __('cookies.cookie_csrf_name'), 'purpose' => __('cookies.cookie_csrf_purpose'), 'duration' => __('cookies.cookie_csrf_duration'), 'category' => __('cookies.category_necessary_title')],
        ['name' => __('cookies.cookie_consent_name'), 'purpose' => __('cookies.cookie_consent_purpose'), 'duration' => __('cookies.cookie_consent_duration'), 'category' => __('cookies.category_necessary_title')],
        ['name' => __('cookies.cookie_locale_name'), 'purpose' => __('cookies.cookie_locale_purpose'), 'duration' => __('cookies.cookie_locale_duration'), 'category' => __('cookies.category_functional_title')],
        ['name' => __('cookies.cookie_analytics_name'), 'purpose' => __('cookies.cookie_analytics_purpose'), 'duration' => __('cookies.cookie_analytics_duration'), 'category' => __('cookies.category_analytics_title')],
        ['name' => __('cookies.cookie_marketing_name'), 'purpose' => __('cookies.cookie_marketing_purpose'), 'duration' => __('cookies.cookie_marketing_duration'), 'category' => __('cookies.category_marketing_title')],
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('partials.seo')
    @include('partials.favicon')
    @vite(['resources/css/app.css', 'resources/js/button-feedback.js'])
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" media="print" onload="this.media='all'">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&family=Sora:wght@500;600;700;800&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&family=Sora:wght@500;600;700;800&display=swap" rel="stylesheet">
    </noscript>
    <style>
        :root {
            --brand-navy: #06172c;
            --brand-ink: #0f172a;
            --brand-muted: #607086;
            --brand-line: #d9e3ef;
            --brand-paper: #f5f8fc;
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            font-family: 'Manrope', sans-serif;
            color: var(--brand-ink);
            background: var(--brand-navy);
        }

        html, body {
            overflow-x: hidden;
            max-width: 100%;
        }

        img, svg { max-width: 100%; height: auto; }

        a { color: inherit; text-decoration: none; }

        .cookies-page {
            overflow: hidden;
            background: #ffffff;
        }

        .page-container {
            width: min(100% - 48px, 1180px);
            margin: 0 auto;
        }

        .cookies-hero {
            position: relative;
            padding: 148px 0 64px;
            color: #ffffff;
            background:
                radial-gradient(circle at top left, rgba(11, 92, 255, 0.2), transparent 36%),
                linear-gradient(135deg, var(--brand-navy), #0b2c52);
        }

        .cookies-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 9px 16px;
            border: 1px solid rgba(255, 255, 255, 0.26);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            font-weight: 800;
            font-size: 0.82rem;
        }

        .cookies-hero h1 {
            max-width: 720px;
            margin: 22px 0 14px;
            font-size: clamp(2.1rem, 4vw, 3.1rem);
            line-height: 1.12;
            font-weight: 800;
        }

        .cookies-hero p {
            max-width: 680px;
            margin: 0;
            color: rgba(255, 255, 255, 0.78);
            font-size: 1.05rem;
            line-height: 1.7;
        }

        .cookies-updated {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 22px;
            padding: 8px 16px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .cookies-manage-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 26px;
            padding: 13px 24px;
            border-radius: 999px;
            background: linear-gradient(135deg, #0b5cff, #00b8d9);
            color: #fff;
            font-weight: 800;
            font-size: 0.92rem;
            box-shadow: 0 16px 34px rgba(11, 92, 255, 0.3);
            border: 0;
            cursor: pointer;
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .cookies-manage-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 42px rgba(11, 92, 255, 0.38);
        }

        .cookies-toc {
            background: #ffffff;
            border-radius: 28px;
            padding: 8px;
            margin-top: -18px;
            position: relative;
            z-index: 2;
            box-shadow: 0 30px 70px rgba(15, 23, 42, 0.12);
        }

        .cookies-toc-inner {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 6px;
            padding: 18px;
        }

        .cookies-toc a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 18px;
            font-size: 0.86rem;
            font-weight: 700;
            color: var(--brand-ink);
            transition: background-color .16s ease;
        }

        .cookies-toc a:hover {
            background: var(--brand-paper);
        }

        .cookies-toc a i {
            color: #0b5cff;
            width: 16px;
            text-align: center;
        }

        .cookies-section {
            padding: 64px 0;
            border-bottom: 1px solid var(--brand-line);
        }

        .cookies-section:last-of-type {
            border-bottom: none;
        }

        .cookies-section-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #0b5cff;
        }

        .cookies-section h2 {
            margin: 12px 0 16px;
            font-size: clamp(1.5rem, 2.4vw, 2rem);
            font-weight: 800;
            color: var(--brand-ink);
        }

        .cookies-section p {
            max-width: 820px;
            margin: 0 0 12px;
            color: var(--brand-muted);
            font-size: 1rem;
            line-height: 1.75;
        }

        .cookies-table-wrap {
            margin-top: 28px;
            overflow-x: auto;
            border-radius: 22px;
            border: 1px solid var(--brand-line);
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.06);
        }

        .cookies-table {
            width: 100%;
            min-width: 720px;
            border-collapse: collapse;
            background: #ffffff;
            font-size: 0.88rem;
        }

        .cookies-table thead th {
            text-align: left;
            padding: 16px 18px;
            background: var(--brand-navy);
            color: #fff;
            font-weight: 700;
            font-size: 0.76rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .cookies-table tbody td {
            padding: 16px 18px;
            border-bottom: 1px solid var(--brand-line);
            color: var(--brand-ink);
            vertical-align: top;
        }

        .cookies-table tbody tr:last-child td {
            border-bottom: none;
        }

        .cookies-table tbody tr:nth-child(even) {
            background: var(--brand-paper);
        }

        .cookies-table .cookie-name {
            font-weight: 700;
            font-family: 'SFMono-Regular', Consolas, monospace;
            font-size: 0.82rem;
            color: #0b5cff;
            white-space: nowrap;
        }

        .cookies-table .cookie-category-pill {
            display: inline-flex;
            padding: 4px 10px;
            border-radius: 999px;
            background: #e0e7ff;
            color: #3730a3;
            font-size: 0.72rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .cookies-contact-card {
            margin-top: 8px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 28px 32px;
            border-radius: 26px;
            background: linear-gradient(135deg, var(--brand-navy), #0b2c52);
            color: #fff;
        }

        .cookies-contact-card p {
            margin: 0;
            color: rgba(255, 255, 255, 0.78);
            max-width: 520px;
        }

        .cookies-contact-card h3 {
            margin: 0 0 8px;
            font-size: 1.2rem;
            font-weight: 800;
            color: #fff;
        }

        .cookies-contact-cta {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 13px 22px;
            border-radius: 999px;
            background: #fff;
            color: var(--brand-navy);
            font-weight: 800;
            font-size: 0.9rem;
            white-space: nowrap;
        }

        @media (max-width: 720px) {
            .page-container {
                width: min(100% - 28px, 1180px);
            }

            .cookies-hero {
                padding: 104px 0 44px;
            }

            .cookies-section {
                padding: 44px 0;
            }

            .cookies-contact-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .cookies-table-wrap {
                overflow: visible;
                border: 0;
                border-radius: 0;
                box-shadow: none;
            }

            .cookies-table {
                min-width: 0;
                border-collapse: separate;
                background: transparent;
            }

            .cookies-table thead {
                position: absolute;
                width: 1px;
                height: 1px;
                overflow: hidden;
                clip: rect(0, 0, 0, 0);
                white-space: nowrap;
            }

            .cookies-table tbody {
                display: grid;
                gap: 16px;
            }

            .cookies-table tbody tr {
                display: block;
                overflow: hidden;
                border: 1px solid var(--brand-line);
                border-radius: 20px;
                background: #ffffff !important;
                box-shadow: 0 16px 38px rgba(15, 23, 42, 0.07);
            }

            .cookies-table tbody td {
                display: grid;
                grid-template-columns: minmax(92px, 0.65fr) minmax(0, 1fr);
                gap: 12px;
                padding: 14px 16px;
            }

            .cookies-table tbody td::before {
                content: attr(data-label);
                color: var(--brand-muted);
                font-family: 'Manrope', sans-serif;
                font-size: 0.7rem;
                font-weight: 800;
                letter-spacing: 0.04em;
                text-transform: uppercase;
            }

            .cookies-table tbody tr:last-child td {
                border-bottom: 1px solid var(--brand-line);
            }

            .cookies-table tbody tr td:last-child,
            .cookies-table tbody tr:last-child td:last-child {
                border-bottom: 0;
            }

            .cookies-table .cookie-name {
                overflow-wrap: anywhere;
                white-space: normal;
            }

            .cookies-table .cookie-category-pill {
                max-width: 100%;
                justify-self: start;
                white-space: normal;
            }
        }
    </style>
    @include('partials.public-navbar-styles')
</head>
<body>
<div class="cookies-page">
    @include('partials.public-navbar')

    <main>
        <section class="cookies-hero">
            <div class="page-container">
                <span class="cookies-eyebrow"><i class="fas fa-cookie-bite"></i> {{ __('cookies.page_eyebrow') }}</span>
                <h1>{{ __('cookies.page_heading') }}</h1>
                <p>{{ __('cookies.page_intro') }}</p>
                <div class="cookies-updated">
                    <i class="fas fa-circle-check" style="color:#34d399;"></i>
                    {{ __('cookies.page_updated') }} {{ now()->translatedFormat('d F Y') }}
                </div>
                <br>
                <button type="button" class="cookies-manage-btn" data-cookie-open-preferences>
                    <i class="fas fa-sliders"></i> {{ __('cookies.manage_preferences_link') }}
                </button>
            </div>
        </section>

        <nav class="page-container cookies-toc" aria-label="Sommaire">
            <div class="cookies-toc-inner">
                <a href="#what-is"><i class="fas fa-circle-question"></i> {{ __('cookies.section_what_title') }}</a>
                <a href="#why"><i class="fas fa-bullseye"></i> {{ __('cookies.section_why_title') }}</a>
                <a href="#types"><i class="fas fa-layer-group"></i> {{ __('cookies.section_types_title') }}</a>
                <a href="#legal-basis"><i class="fas fa-scale-balanced"></i> {{ __('cookies.section_legal_basis_title') }}</a>
                <a href="#rights"><i class="fas fa-user-shield"></i> {{ __('cookies.section_rights_title') }}</a>
                <a href="#third-party"><i class="fas fa-share-nodes"></i> {{ __('cookies.section_thirdparty_title') }}</a>
            </div>
        </nav>

        <div class="page-container">
            <section class="cookies-section" id="what-is">
                <span class="cookies-section-kicker"><i class="fas fa-circle-question"></i> 01</span>
                <h2>{{ __('cookies.section_what_title') }}</h2>
                <p>{{ __('cookies.section_what_text') }}</p>
            </section>

            <section class="cookies-section" id="why">
                <span class="cookies-section-kicker"><i class="fas fa-bullseye"></i> 02</span>
                <h2>{{ __('cookies.section_why_title') }}</h2>
                <p>{{ __('cookies.section_why_text') }}</p>
            </section>

            <section class="cookies-section" id="types">
                <span class="cookies-section-kicker"><i class="fas fa-layer-group"></i> 03</span>
                <h2>{{ __('cookies.section_types_title') }}</h2>
                <p>{{ __('cookies.preferences_intro') }}</p>

                <div class="cookies-table-wrap">
                    <table class="cookies-table">
                        <thead>
                            <tr>
                                <th>{{ __('cookies.table_name') }}</th>
                                <th>{{ __('cookies.table_category') }}</th>
                                <th>{{ __('cookies.table_purpose') }}</th>
                                <th>{{ __('cookies.table_duration') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cookieRows as $row)
                                <tr>
                                    <td class="cookie-name" data-label="{{ __('cookies.table_name') }}">{{ $row['name'] }}</td>
                                    <td data-label="{{ __('cookies.table_category') }}"><span class="cookie-category-pill">{{ $row['category'] }}</span></td>
                                    <td data-label="{{ __('cookies.table_purpose') }}">{{ $row['purpose'] }}</td>
                                    <td data-label="{{ __('cookies.table_duration') }}">{{ $row['duration'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="cookies-section" id="legal-basis">
                <span class="cookies-section-kicker"><i class="fas fa-scale-balanced"></i> 04</span>
                <h2>{{ __('cookies.section_legal_basis_title') }}</h2>
                <p>{{ __('cookies.section_legal_basis_text') }}</p>
            </section>

            <section class="cookies-section" id="rights">
                <span class="cookies-section-kicker"><i class="fas fa-user-shield"></i> 05</span>
                <h2>{{ __('cookies.section_rights_title') }}</h2>
                <p>{{ __('cookies.section_rights_text') }}</p>
            </section>

            <section class="cookies-section" id="third-party">
                <span class="cookies-section-kicker"><i class="fas fa-share-nodes"></i> 06</span>
                <h2>{{ __('cookies.section_thirdparty_title') }}</h2>
                <p>{{ __('cookies.section_thirdparty_text') }}</p>
            </section>

            <section class="cookies-section">
                <span class="cookies-section-kicker"><i class="fas fa-arrows-rotate"></i> 07</span>
                <h2>{{ __('cookies.section_changes_title') }}</h2>
                <p>{{ __('cookies.section_changes_text') }}</p>
            </section>

            <section class="cookies-section" style="border-bottom:none;">
                <div class="cookies-contact-card">
                    <div>
                        <h3>{{ __('cookies.section_contact_title') }}</h3>
                        <p>{{ __('cookies.section_contact_text') }}</p>
                    </div>
                    <a href="{{ localized_route('support.nous-contacter', ['locale' => $locale]) }}" class="cookies-contact-cta">
                        <i class="fas fa-paper-plane"></i> {{ __('cookies.section_contact_cta') }}
                    </a>
                </div>
            </section>
        </div>
    </main>

    @include('partials.public-footer')
</div>
@include('partials.public-navbar-scripts')
@include('components.cookie-consent')
</body>
</html>
