<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
            --navy: #06172c;
            --ink: #0f172a;
            --muted: #64748b;
            --line: #dbe5f0;
            --gold: #d9a441;
            --blue: #0b5cff;
            --cyan: #00b8d9;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Manrope', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 12% 10%, rgba(11, 92, 255, .15), transparent 28%),
                radial-gradient(circle at 88% 6%, rgba(217, 164, 65, .18), transparent 24%),
                linear-gradient(180deg, #06172c 0%, #0b1e36 34%, #f6f9fd 34%, #ffffff 100%);
        }

        .tf-shell {
            width: min(100% - 36px, 1220px);
            margin: 0 auto;
            padding: 28px 0 52px;
        }

        .tf-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 30px;
            padding: 14px 16px;
            border: 1px solid rgba(255, 255, 255, .14);
            border-radius: 28px;
            background: rgba(255, 255, 255, .08);
            backdrop-filter: blur(18px);
        }

        .tf-brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: #ffffff;
            font-family: 'Sora', sans-serif;
            font-weight: 800;
        }

        .tf-brand img {
            width: 48px;
            height: 48px;
            object-fit: contain;
        }

        .tf-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 46px;
            padding: 0 18px;
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 999px;
            color: #ffffff;
            font-size: .9rem;
            font-weight: 800;
            background: rgba(255, 255, 255, .08);
            transition: transform .2s ease, background .2s ease;
        }

        .tf-back:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, .14);
        }

        .tf-grid {
            display: grid;
            grid-template-columns: minmax(0, .82fr) minmax(0, 1.18fr);
            gap: 26px;
            align-items: stretch;
        }

        .tf-hero,
        .tf-panel,
        .tf-card {
            border: 1px solid rgba(219, 229, 240, .9);
            border-radius: 32px;
            box-shadow: 0 28px 80px rgba(15, 23, 42, .12);
        }

        .tf-hero {
            position: sticky;
            top: 24px;
            overflow: hidden;
            min-height: 640px;
            padding: clamp(26px, 3vw, 36px);
            color: #ffffff;
            background:
                radial-gradient(circle at 84% 14%, rgba(0, 184, 217, .26), transparent 28%),
                radial-gradient(circle at 16% 84%, rgba(217, 164, 65, .18), transparent 30%),
                linear-gradient(145deg, #06172c, #0b2340 62%, #071426);
        }

        .tf-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(90deg, rgba(255,255,255,.045) 1px, transparent 1px),
                linear-gradient(180deg, rgba(255,255,255,.04) 1px, transparent 1px);
            background-size: 76px 76px;
            mask-image: linear-gradient(180deg, #000 0%, transparent 78%);
            pointer-events: none;
        }

        .tf-hero > * {
            position: relative;
            z-index: 1;
        }

        .tf-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 13px;
            border: 1px solid rgba(255, 255, 255, .16);
            border-radius: 999px;
            color: #b9efff;
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: .18em;
            text-transform: uppercase;
            background: rgba(255, 255, 255, .08);
        }

        .tf-title {
            max-width: 560px;
            margin: 24px 0 0;
            font-family: 'Sora', sans-serif;
            font-size: clamp(2rem, 4vw, 3.55rem);
            line-height: 1.05;
            letter-spacing: -.055em;
        }

        .tf-lead {
            max-width: 560px;
            margin: 18px 0 0;
            color: rgba(255, 255, 255, .76);
            font-size: 1rem;
            line-height: 1.75;
        }

        .tf-status-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
            margin-top: 28px;
        }

        .tf-status-card {
            display: grid;
            grid-template-columns: 42px minmax(0, 1fr);
            column-gap: 14px;
            align-items: center;
            min-height: auto;
            padding: 16px;
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 24px;
            background: rgba(255, 255, 255, .07);
        }

        .tf-status-card span {
            display: inline-flex;
            width: 38px;
            height: 38px;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            color: #ffffff;
            background: linear-gradient(135deg, var(--blue), var(--cyan));
        }

        .tf-status-card strong {
            display: block;
            margin-top: 0;
            color: #ffffff;
            font-size: .95rem;
        }

        .tf-status-card p {
            grid-column: 2;
            margin: 5px 0 0;
            color: rgba(255, 255, 255, .62);
            font-size: .78rem;
            line-height: 1.5;
        }

        .tf-progress {
            margin-top: 28px;
            padding: 22px;
            border: 1px solid rgba(255, 255, 255, .14);
            border-radius: 28px;
            background: rgba(255, 255, 255, .08);
        }

        .tf-progress-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .tf-progress-bar {
            overflow: hidden;
            height: 10px;
            margin-top: 18px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .12);
        }

        .tf-progress-bar div {
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, var(--blue), var(--cyan), #2dd4bf);
        }

        .tf-note {
            margin-top: 22px;
            padding: 18px;
            border: 1px solid rgba(245, 158, 11, .26);
            border-radius: 24px;
            color: #fff7ed;
            background: rgba(245, 158, 11, .12);
        }

        .tf-note p {
            margin: 0;
            color: rgba(255, 247, 237, .86);
            font-size: .88rem;
            line-height: 1.65;
        }

        .tf-panel {
            overflow: hidden;
            background: rgba(255, 255, 255, .94);
            backdrop-filter: blur(18px);
        }

        .tf-panel-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            padding: clamp(22px, 3vw, 32px);
            border-bottom: 1px solid var(--line);
            background:
                radial-gradient(circle at top right, rgba(11, 92, 255, .08), transparent 32%),
                linear-gradient(180deg, #ffffff, #f8fbff);
        }

        .tf-panel-head h2,
        .tf-card h3 {
            margin: 0;
            font-family: 'Sora', sans-serif;
            color: #071426;
            letter-spacing: -.035em;
        }

        .tf-panel-head h2 {
            margin-top: 8px;
            font-size: clamp(1.35rem, 2.4vw, 2.05rem);
        }

        .tf-panel-head p,
        .tf-card p {
            color: var(--muted);
            line-height: 1.7;
        }

        .tf-panel-body {
            display: grid;
            gap: 18px;
            padding: clamp(20px, 3vw, 32px);
        }

        .tf-alert {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 15px;
            border-radius: 20px;
            font-size: .9rem;
            font-weight: 700;
            line-height: 1.55;
        }

        .tf-alert.success {
            color: #047857;
            border: 1px solid #a7f3d0;
            background: #ecfdf5;
        }

        .tf-alert.error {
            color: #b42318;
            border: 1px solid #fecaca;
            background: #fff1f2;
        }

        .tf-cards {
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            gap: 18px;
            align-items: stretch;
        }

        .tf-card {
            padding: clamp(18px, 2.2vw, 24px);
            background: #ffffff;
        }

        .tf-secret-card,
        .tf-backups {
            grid-column: 1 / -1;
        }

        .tf-enable-card,
        .tf-disable-card {
            grid-column: span 6;
        }

        .tf-card h3 {
            font-size: 1.12rem;
        }

        .tf-card p {
            margin: 8px 0 0;
            font-size: .92rem;
        }

        .tf-card-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 18px;
        }

        .tf-card-icon {
            flex: 0 0 auto;
            display: inline-flex;
            width: 48px;
            height: 48px;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            color: #ffffff;
            background: linear-gradient(135deg, var(--blue), var(--cyan));
            box-shadow: 0 16px 34px rgba(11, 92, 255, .22);
        }

        .tf-qr-layout {
            display: grid;
            grid-template-columns: minmax(220px, 250px) minmax(0, 1fr);
            gap: 20px;
            align-items: stretch;
        }

        .tf-qr-box {
            padding: 14px;
            border: 1px solid var(--line);
            border-radius: 24px;
            background: #f8fbff;
        }

        .tf-qr-inner {
            overflow: hidden;
            padding: 12px;
            border: 1px solid var(--line);
            border-radius: 20px;
            background: #ffffff;
        }

        .twofactor-qr-svg {
            display: block;
            width: 100%;
            height: auto;
        }

        .tf-secret-box,
        .tf-otpauth-box {
            padding: 18px;
            border: 1px solid var(--line);
            border-radius: 20px;
            background: #f8fbff;
        }

        .tf-label {
            margin: 0 0 8px;
            color: #94a3b8;
            font-size: .68rem;
            font-weight: 900;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .tf-secret-value,
        .tf-otpauth-value,
        .tf-backup-code {
            overflow-wrap: anywhere;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        }

        .tf-secret-value {
            color: #071426;
            font-size: 1.02rem;
            font-weight: 900;
            line-height: 1.7;
        }

        .tf-otpauth-value {
            color: #475569;
            font-size: .78rem;
            line-height: 1.65;
        }

        .tf-copy {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 12px;
            padding: 9px 12px;
            border: 1px solid #bfdbfe;
            border-radius: 999px;
            color: #1d4ed8;
            font-size: .78rem;
            font-weight: 900;
            background: #eff6ff;
            cursor: pointer;
        }

        .tf-code-input,
        .tf-password-input {
            width: 100%;
            border: 1px solid var(--line);
            outline: none;
            color: #071426;
            background: #ffffff;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .tf-code-input {
            min-height: 68px;
            border-radius: 22px;
            padding: 0 18px;
            text-align: center;
            font-size: clamp(1.25rem, 4vw, 2rem);
            font-weight: 900;
            letter-spacing: .42em;
        }

        .tf-password-input {
            min-height: 54px;
            border-radius: 18px;
            padding: 0 16px;
            font-size: .95rem;
        }

        .tf-code-input:focus,
        .tf-password-input:focus {
            border-color: rgba(11, 92, 255, .46);
            box-shadow: 0 0 0 5px rgba(11, 92, 255, .10);
        }

        .tf-button {
            display: inline-flex;
            width: 100%;
            min-height: 54px;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border: 0;
            border-radius: 18px;
            color: #ffffff;
            font-weight: 900;
            cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .tf-button:hover {
            transform: translateY(-2px);
        }

        .tf-button.primary {
            background: linear-gradient(135deg, var(--blue), var(--cyan));
            box-shadow: 0 18px 38px rgba(11, 92, 255, .24);
        }

        .tf-button.dark {
            background: #071426;
            box-shadow: 0 18px 34px rgba(15, 23, 42, .18);
        }

        .tf-help {
            margin-top: 16px;
            padding: 15px;
            border: 1px solid #dbeafe;
            border-radius: 20px;
            color: #475569;
            background: #f8fbff;
            font-size: .88rem;
            line-height: 1.65;
        }

        .tf-backups {
            border-color: #fde68a;
            background: linear-gradient(180deg, #fffbeb, #ffffff);
        }

        .tf-backup-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
            margin-top: 18px;
        }

        .tf-backup-code {
            padding: 12px;
            border: 1px solid #fde68a;
            border-radius: 16px;
            color: #92400e;
            text-align: center;
            font-size: .83rem;
            font-weight: 900;
            letter-spacing: .08em;
            background: #ffffff;
        }

        .tf-footer-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-top: 6px;
            padding-top: 18px;
            border-top: 1px solid var(--line);
        }

        .tf-footer-pill {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 11px 14px;
            border-radius: 999px;
            color: #475569;
            font-size: .86rem;
            font-weight: 800;
            background: #f1f5f9;
        }

        @media (max-width: 1120px) {
            body {
                background:
                    radial-gradient(circle at top left, rgba(11, 92, 255, .15), transparent 30%),
                    linear-gradient(180deg, #06172c 0%, #0b1e36 24%, #f6f9fd 24%, #ffffff 100%);
            }

            .tf-grid,
            .tf-cards {
                grid-template-columns: 1fr;
            }

            .tf-secret-card,
            .tf-enable-card,
            .tf-disable-card,
            .tf-backups {
                grid-column: 1 / -1;
            }

            .tf-hero {
                position: relative;
                top: auto;
                min-height: auto;
            }
        }

        @media (max-width: 720px) {
            .tf-shell {
                width: min(100% - 24px, 1220px);
                padding-top: 14px;
            }

            .tf-nav,
            .tf-panel-head,
            .tf-footer-row {
                align-items: stretch;
                flex-direction: column;
            }

            .tf-back,
            .tf-footer-pill {
                width: 100%;
            }

            .tf-title {
                font-size: 2.05rem;
            }

            .tf-status-grid,
            .tf-qr-layout,
            .tf-backup-grid {
                grid-template-columns: 1fr;
            }

            .tf-code-input {
                letter-spacing: .28em;
            }
        }
    </style>
</head>
<body>
@php
    $setupProgress = $user->two_factor_enabled ? 100 : 66;
    $backupCodeCount = is_array($backupCodes ?? null) ? count($backupCodes) : 10;
    $maskedSecret = $user->two_factor_secret
        ? substr($user->two_factor_secret, 0, 4) . ' •••• ' . substr($user->two_factor_secret, -4)
        : '----';
@endphp

<div class="tf-shell">
    <nav class="tf-nav" aria-label="{{ __('auth_ui.security') }}">
        <a class="tf-brand" href="{{ localized_route('home', ['locale' => app()->getLocale()]) }}">
            <img src="{{ asset('images/zuider-logo-white.png') }}" alt="Zuider Bank S.A">
            <span>Zuider Bank S.A</span>
        </a>
        <a class="tf-back" href="{{ $dashboardUrl }}">
            <i class="fas fa-arrow-left"></i>
            {{ __('auth.2fa_back_dashboard') }}
        </a>
    </nav>

    <main class="tf-grid">
        <aside class="tf-hero">
            <span class="tf-kicker">
                <i class="fas fa-shield-halved"></i>
                Zuider Secure Access
            </span>

            <h1 class="tf-title">{{ __('auth.2fa_setup_heading') }}</h1>
            <p class="tf-lead">{{ __('auth.2fa_setup_description') }}</p>

            @if (!empty($isAdminTwoFactorMandatory))
                <div class="tf-note">
                    <p><i class="fas fa-user-shield"></i> {{ __('auth.2fa_admin_mandatory_notice') }}</p>
                </div>
            @endif

            <div class="tf-status-grid">
                <article class="tf-status-card">
                    <span><i class="fas fa-key"></i></span>
                    <strong>{{ $maskedSecret }}</strong>
                    <p>{{ __('auth.2fa_secret_hint') }}</p>
                </article>
                <article class="tf-status-card">
                    <span><i class="fas fa-mobile-screen-button"></i></span>
                    <strong>6 digits</strong>
                    <p>{{ __('auth.2fa_enable_hint') }}</p>
                </article>
                <article class="tf-status-card">
                    <span><i class="fas fa-lock"></i></span>
                    <strong>{{ $backupCodeCount }}</strong>
                    <p>{{ __('auth.2fa_backup_hint') }}</p>
                </article>
            </div>

            <div class="tf-progress">
                <div class="tf-progress-head">
                    <div>
                        <p class="tf-label" style="color: rgba(255,255,255,.48); margin-bottom: 6px;">2FA progress</p>
                        <strong>{{ $user->two_factor_enabled ? __('auth.2fa_enabled') : __('auth.2fa_enable_title') }}</strong>
                    </div>
                    <strong style="color:#7dd3fc;font-size:1.45rem;">{{ $setupProgress }}%</strong>
                </div>
                <div class="tf-progress-bar" aria-hidden="true">
                    <div style="width: {{ $setupProgress }}%"></div>
                </div>
            </div>
        </aside>

        <section class="tf-panel">
            <div class="tf-panel-head">
                <div>
                    <p class="tf-label">Zuider Bank S.A</p>
                    <h2>{{ __('auth.2fa_setup_heading') }}</h2>
                    <p>{{ __('auth.2fa_setup_description') }}</p>
                </div>
                <div class="tf-footer-pill">
                    <i class="fas fa-user-lock text-blue-600"></i>
                    <span>{{ $user->email }}</span>
                </div>
            </div>

            <div class="tf-panel-body">
                @if (session('status'))
                    <div class="tf-alert success">
                        <i class="fas fa-circle-check"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="tf-alert error">
                        <i class="fas fa-triangle-exclamation"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <div class="tf-cards">
                    <article class="tf-card tf-secret-card">
                        <div class="tf-card-head">
                            <div>
                                <h3>{{ __('auth.2fa_secret_title') }}</h3>
                                <p>{{ __('auth.2fa_secret_hint') }}</p>
                            </div>
                            <span class="tf-card-icon"><i class="fas fa-qrcode"></i></span>
                        </div>

                        <div class="tf-qr-layout">
                            <div class="tf-qr-box">
                                <p class="tf-label">QR code</p>
                                <div class="tf-qr-inner">
                                    @if (!empty($qrSvg))
                                        {!! $qrSvg !!}
                                    @else
                                        <div style="aspect-ratio:1;display:grid;place-items:center;border-radius:16px;background:#f1f5f9;color:#94a3b8;">
                                            <i class="fas fa-qrcode" style="font-size:2rem;"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <div class="tf-secret-box">
                                    <p class="tf-label">{{ __('auth.2fa_secret_title') }}</p>
                                    <div class="tf-secret-value">{{ $user->two_factor_secret }}</div>
                                    <button
                                        type="button"
                                        class="tf-copy"
                                        data-copy-secret-button
                                        data-secret="{{ $user->two_factor_secret }}"
                                        data-label-default="{{ __('auth.2fa_copy_secret') }}"
                                        data-label-success="{{ __('auth.2fa_copy_secret_success') }}"
                                    >
                                        <i class="fas fa-copy"></i>
                                        <span>{{ __('auth.2fa_copy_secret') }}</span>
                                    </button>
                                    <p data-copy-secret-feedback class="hidden" style="margin:10px 0 0;color:#047857;font-size:.8rem;font-weight:800;" aria-live="polite">
                                        {{ __('auth.2fa_copy_secret_success') }}
                                    </p>
                                </div>

                                <div class="tf-otpauth-box" style="margin-top:14px;">
                                    <p class="tf-label">{{ __('auth.2fa_otpauth_label') }}</p>
                                    <div class="tf-otpauth-value">{{ $otpauth }}</div>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article class="tf-card tf-enable-card">
                        <div class="tf-card-head">
                            <div>
                                <h3>{{ __('auth.2fa_enable_title') }}</h3>
                                <p>{{ __('auth.2fa_enable_hint') }}</p>
                            </div>
                            <span class="tf-card-icon"><i class="fas fa-mobile-screen-button"></i></span>
                        </div>

                        <form method="POST" action="{{ localized_route('twofactor.enable', ['locale' => app()->getLocale()]) }}">
                            @csrf
                            <input
                                class="tf-code-input"
                                type="text"
                                name="code"
                                inputmode="numeric"
                                autocomplete="one-time-code"
                                maxlength="6"
                                spellcheck="false"
                                placeholder="{{ __('auth.2fa_code_placeholder') }}"
                            >
                            <button type="submit" class="tf-button primary" style="margin-top:14px;">
                                <i class="fas fa-shield-alt"></i>
                                {{ __('auth.2fa_enable_button') }}
                            </button>
                        </form>

                        <div class="tf-help">
                            <i class="fas fa-circle-info text-blue-600"></i>
                            {{ __('auth.2fa_enable_hint') }}
                        </div>
                    </article>

                @if (!empty($backupCodes))
                    <article class="tf-card tf-backups">
                        <div class="tf-card-head">
                            <div>
                                <h3>{{ __('auth.2fa_backup_title') }}</h3>
                                <p>{{ __('auth.2fa_backup_hint') }}</p>
                            </div>
                            <span class="tf-card-icon" style="background:linear-gradient(135deg,#d97706,#f59e0b);box-shadow:0 16px 34px rgba(217,119,6,.22);">
                                <i class="fas fa-vault"></i>
                            </span>
                        </div>

                        <div class="tf-backup-grid">
                            @foreach ($backupCodes as $code)
                                <div class="tf-backup-code">{{ $code }}</div>
                            @endforeach
                        </div>
                    </article>
                @endif

                @unless (!empty($isAdminTwoFactorMandatory))
                    <article class="tf-card tf-disable-card">
                        <div class="tf-card-head">
                            <div>
                                <h3>{{ __('auth.2fa_disable_title') }}</h3>
                                <p>{{ __('auth.2fa_disable_hint') }}</p>
                            </div>
                            <span class="tf-card-icon" style="background:linear-gradient(135deg,#0f172a,#334155);box-shadow:0 16px 34px rgba(15,23,42,.18);">
                                <i class="fas fa-power-off"></i>
                            </span>
                        </div>

                        <form method="POST" action="{{ localized_route('twofactor.disable', ['locale' => app()->getLocale()]) }}">
                            @csrf
                            <input
                                class="tf-password-input"
                                type="password"
                                name="password"
                                autocomplete="current-password"
                                placeholder="{{ __('auth.2fa_password_placeholder') }}"
                            >
                            <button type="submit" class="tf-button dark" style="margin-top:12px;">
                                <i class="fas fa-lock-open"></i>
                                {{ __('auth.2fa_disable_button') }}
                            </button>
                        </form>
                    </article>
                @endunless
                </div>

                <div class="tf-footer-row">
                    <a class="tf-back" href="{{ $dashboardUrl }}" style="color:#0f172a;background:#ffffff;border-color:var(--line);">
                        <i class="fas fa-arrow-left"></i>
                        {{ __('auth.2fa_back_dashboard') }}
                    </a>
                    <span class="tf-footer-pill">
                        <i class="fas fa-shield-check text-emerald-600"></i>
                        {{ __('auth.2fa_setup_heading') }}
                    </span>
                </div>
            </div>
        </section>
    </main>
</div>

<script>
    (() => {
        const copyButton = document.querySelector('[data-copy-secret-button]');
        const feedback = document.querySelector('[data-copy-secret-feedback]');

        if (!copyButton) return;

        const defaultLabel = copyButton.dataset.labelDefault || 'Copy key';
        const successLabel = copyButton.dataset.labelSuccess || 'Key copied';

        const setSuccess = () => {
            const label = copyButton.querySelector('span');
            if (label) label.textContent = successLabel;
            copyButton.style.borderColor = '#a7f3d0';
            copyButton.style.color = '#047857';
            copyButton.style.background = '#ecfdf5';
            feedback?.classList.remove('hidden');

            window.setTimeout(() => {
                if (label) label.textContent = defaultLabel;
                copyButton.style.borderColor = '#bfdbfe';
                copyButton.style.color = '#1d4ed8';
                copyButton.style.background = '#eff6ff';
                feedback?.classList.add('hidden');
            }, 2200);
        };

        const fallbackCopy = (value) => {
            const field = document.createElement('textarea');
            field.value = value;
            field.setAttribute('readonly', '');
            field.style.position = 'absolute';
            field.style.left = '-9999px';
            document.body.appendChild(field);
            field.select();
            document.execCommand('copy');
            document.body.removeChild(field);
        };

        copyButton.addEventListener('click', async () => {
            const secret = copyButton.dataset.secret || '';
            if (!secret) return;

            try {
                if (navigator.clipboard?.writeText) {
                    await navigator.clipboard.writeText(secret);
                } else {
                    fallbackCopy(secret);
                }
                setSuccess();
            } catch (error) {
                fallbackCopy(secret);
                setSuccess();
            }
        });
    })();
</script>
</body>
</html>
