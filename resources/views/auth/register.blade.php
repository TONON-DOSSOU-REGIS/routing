@extends('layouts.app')

@php
    $countries = [
        'France' => __('auth.country_france'),
        'Allemagne' => __('auth.country_germany'),
        'Autriche' => __('auth.country_austria'),
        'Belgique' => __('auth.country_belgium'),
        'Bulgarie' => __('auth.country_bulgaria'),
        'Chypre' => __('auth.country_cyprus'),
        'Croatie' => __('auth.country_croatia'),
        'Danemark' => __('auth.country_denmark'),
        'Espagne' => __('auth.country_spain'),
        'Estonie' => __('auth.country_estonia'),
        'Finlande' => __('auth.country_finland'),
        'Grece' => __('auth.country_greece'),
        'Hongrie' => __('auth.country_hungary'),
        'Irlande' => __('auth.country_ireland'),
        'Italie' => __('auth.country_italy'),
        'Lettonie' => __('auth.country_latvia'),
        'Lituanie' => __('auth.country_lithuania'),
        'Luxembourg' => __('auth.country_luxembourg'),
        'Malte' => __('auth.country_malta'),
        'Pays-Bas' => __('auth.country_netherlands'),
        'Pologne' => __('auth.country_poland'),
        'Portugal' => __('auth.country_portugal'),
        'Republique Tcheque' => __('auth.country_czech'),
        'Roumanie' => __('auth.country_romania'),
        'Slovaquie' => __('auth.country_slovakia'),
        'Slovenie' => __('auth.country_slovenia'),
        'Suede' => __('auth.country_sweden'),
        'Suisse' => __('auth.country_switzerland'),
        'Norvege' => __('auth.country_norway'),
        'Islande' => __('auth.country_iceland'),
        'Royaume-Uni' => __('auth.country_uk'),
        'Albanie' => __('auth.country_albania'),
        'Bosnie-Herzegovine' => __('auth.country_bosnia'),
        'Serbie' => __('auth.country_serbia'),
        'Montenegro' => __('auth.country_montenegro'),
        'Macedoine du Nord' => __('auth.country_macedonia'),
        'Kosovo' => __('auth.country_kosovo'),
        'Andorre' => __('auth.country_andorra'),
        'Liechtenstein' => __('auth.country_liechtenstein'),
        'Monaco' => __('auth.country_monaco'),
        'Saint-Marin' => __('auth.country_san_marino'),
        'Vatican' => __('auth.country_vatican'),
        'Canada' => __('auth.country_canada'),
        'Autre' => __('auth.country_other'),
    ];
@endphp

@section('title', __('auth.register_page_title'))

@push('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .register-page,
        .register-page * {
            box-sizing: border-box;
        }

        .register-page {
            --register-navy: #071b33;
            --register-navy-light: #0d294a;
            --register-blue: #0b5bd3;
            --register-blue-dark: #0849a8;
            --register-text: #10213a;
            --register-muted: #586981;
            --register-border: #d9e1eb;
            min-height: 100vh;
            min-height: 100dvh;
            color: var(--register-text);
            background:
                linear-gradient(180deg, #eaf0f7 0, #f6f8fb 32rem, #f6f8fb 100%);
            font-family: "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: auto;
            -moz-osx-font-smoothing: auto;
        }

        .register-shell {
            width: min(calc(100% - 40px), 1320px);
            margin: 0 auto;
            padding: 20px 0 28px;
        }

        .register-topbar {
            position: relative;
            z-index: 20;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            min-height: 82px;
            padding: 14px 18px;
            border: 1px solid rgba(203, 213, 225, .92);
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 10px 28px rgba(15, 35, 60, .07);
        }

        .register-brand {
            display: inline-flex;
            min-width: 0;
            align-items: center;
            gap: 14px;
            color: var(--register-text);
            text-decoration: none;
        }

        .register-brand-logo {
            display: inline-flex;
            width: 52px;
            height: 52px;
            flex: 0 0 auto;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 1px solid #dce4ee;
            border-radius: 13px;
            background: #fff;
        }

        .register-brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: left center;
            transform: scale(1.28);
            transform-origin: left center;
        }

        .register-brand-name {
            display: block;
            font-size: 17px;
            font-weight: 750;
            line-height: 1.25;
            letter-spacing: -.015em;
        }

        .register-brand-subtitle {
            display: block;
            margin-top: 3px;
            color: #66758a;
            font-size: 13px;
            font-weight: 500;
            line-height: 1.35;
        }

        .register-navigation {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }

        .register-navigation .language-selector .language-btn {
            min-height: 46px;
            border-color: var(--register-border);
            background: #fff;
            box-shadow: none;
            backdrop-filter: none;
        }

        .register-nav-link {
            display: inline-flex;
            min-height: 46px;
            align-items: center;
            justify-content: center;
            padding: 0 18px;
            border: 1px solid var(--register-border);
            border-radius: 11px;
            color: #33445c;
            background: #fff;
            font-size: 14px;
            font-weight: 700;
            line-height: 1;
            text-decoration: none;
            transition: border-color .18s ease, background-color .18s ease, color .18s ease;
        }

        .register-nav-link:hover,
        .register-nav-link:focus-visible {
            border-color: #aebdce;
            color: var(--register-text);
            background: #f8fafc;
        }

        .register-nav-link--primary {
            border-color: var(--register-navy);
            color: #fff;
            background: var(--register-navy);
        }

        .register-nav-link--primary:hover,
        .register-nav-link--primary:focus-visible {
            border-color: var(--register-navy-light);
            color: #fff;
            background: var(--register-navy-light);
        }

        .register-main {
            display: grid;
            grid-template-columns: minmax(340px, 430px) minmax(0, 1fr);
            gap: 24px;
            align-items: start;
            margin-top: 24px;
        }

        .register-intro {
            position: sticky;
            top: 20px;
            min-height: 720px;
            overflow: hidden;
            padding: 48px 42px 40px;
            border-radius: 24px;
            color: #fff;
            background:
                radial-gradient(circle at 100% 0, rgba(66, 153, 225, .17), transparent 33%),
                linear-gradient(155deg, var(--register-navy-light), var(--register-navy) 58%);
            box-shadow: 0 20px 48px rgba(7, 27, 51, .17);
        }

        .register-intro::after {
            content: "";
            position: absolute;
            right: -120px;
            bottom: -155px;
            width: 340px;
            height: 340px;
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 50%;
            box-shadow:
                0 0 0 48px rgba(255, 255, 255, .025),
                0 0 0 96px rgba(255, 255, 255, .018);
            pointer-events: none;
        }

        .register-intro-content {
            position: relative;
            z-index: 1;
        }

        .register-security-label {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: #d8e8fa;
            font-size: 13px;
            font-weight: 700;
            line-height: 1.3;
        }

        .register-security-label::before {
            content: "";
            width: 8px;
            height: 8px;
            flex: 0 0 auto;
            border-radius: 50%;
            background: #5ad6a0;
            box-shadow: 0 0 0 5px rgba(90, 214, 160, .12);
        }

        .register-intro h1 {
            max-width: 360px;
            margin: 26px 0 0;
            color: #fff;
            font-size: clamp(36px, 3.5vw, 51px);
            font-weight: 760;
            line-height: 1.08;
            letter-spacing: -.045em;
        }

        .register-intro-description {
            max-width: 350px;
            margin: 20px 0 0;
            color: #c5d3e3;
            font-size: 17px;
            font-weight: 450;
            line-height: 1.65;
        }

        .register-steps {
            display: grid;
            gap: 0;
            margin: 42px 0 0;
            padding: 0;
            list-style: none;
        }

        .register-step {
            position: relative;
            display: grid;
            grid-template-columns: 44px minmax(0, 1fr);
            gap: 15px;
            min-height: 86px;
        }

        .register-step:not(:last-child)::before {
            content: "";
            position: absolute;
            top: 38px;
            bottom: 0;
            left: 21px;
            width: 1px;
            background: rgba(255, 255, 255, .17);
        }

        .register-step-number {
            display: inline-flex;
            width: 44px;
            height: 44px;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 12px;
            color: #fff;
            background: rgba(255, 255, 255, .08);
            font-size: 13px;
            font-weight: 800;
        }

        .register-step strong {
            display: block;
            padding-top: 2px;
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            line-height: 1.35;
        }

        .register-step p {
            margin: 5px 0 0;
            color: #9fb1c7;
            font-size: 14px;
            line-height: 1.45;
        }

        .register-trust {
            display: grid;
            grid-template-columns: 42px minmax(0, 1fr);
            gap: 14px;
            margin-top: 28px;
            padding: 18px;
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 16px;
            background: rgba(255, 255, 255, .055);
        }

        .register-trust-icon {
            display: inline-flex;
            width: 42px;
            height: 42px;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            color: #9be8c3;
            background: rgba(90, 214, 160, .11);
        }

        .register-trust-icon svg {
            width: 21px;
            height: 21px;
        }

        .register-trust strong {
            display: block;
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            line-height: 1.35;
        }

        .register-trust p {
            margin: 5px 0 0;
            color: #9fb1c7;
            font-size: 13px;
            line-height: 1.5;
        }

        .register-card {
            padding: 42px 46px 44px;
            border: 1px solid #dce3ec;
            border-radius: 24px;
            background: #fff;
            box-shadow: 0 20px 50px rgba(28, 45, 69, .10);
        }

        .register-card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 24px;
            padding-bottom: 30px;
            border-bottom: 1px solid #e5eaf0;
        }

        .register-eyebrow {
            margin: 0;
            color: var(--register-blue);
            font-size: 13px;
            font-weight: 800;
            line-height: 1.3;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .register-card h2 {
            margin: 8px 0 0;
            color: #0c1b30;
            font-size: clamp(29px, 3vw, 38px);
            font-weight: 760;
            line-height: 1.18;
            letter-spacing: -.035em;
        }

        .register-card-login {
            margin: 11px 0 0;
            color: var(--register-muted);
            font-size: 15px;
            line-height: 1.5;
        }

        .register-card-login a {
            color: var(--register-blue-dark);
            font-weight: 700;
            text-decoration: none;
        }

        .register-card-login a:hover {
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .register-secure-status {
            display: inline-flex;
            flex: 0 0 auto;
            align-items: center;
            gap: 8px;
            min-height: 38px;
            padding: 0 13px;
            border: 1px solid #cce9dc;
            border-radius: 10px;
            color: #176c48;
            background: #f0faf5;
            font-size: 13px;
            font-weight: 750;
        }

        .register-secure-status svg {
            width: 16px;
            height: 16px;
        }

        .register-error-summary {
            display: grid;
            grid-template-columns: 38px minmax(0, 1fr);
            gap: 13px;
            margin-top: 24px;
            padding: 17px 18px;
            border: 1px solid #f3c4c8;
            border-radius: 13px;
            color: #8f2430;
            background: #fff6f7;
        }

        .register-error-icon {
            display: inline-flex;
            width: 38px;
            height: 38px;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            color: #b42332;
            background: #fee6e9;
            font-size: 18px;
            font-weight: 800;
        }

        .register-error-summary strong {
            display: block;
            font-size: 14px;
            line-height: 1.4;
        }

        .register-error-summary ul {
            margin: 6px 0 0;
            padding-left: 18px;
            font-size: 13px;
            line-height: 1.55;
        }

        .register-form {
            margin-top: 30px;
        }

        .register-form-section {
            min-width: 0;
            margin: 0;
            padding: 0;
            border: 0;
        }

        .register-form-section + .register-form-section {
            margin-top: 34px;
            padding-top: 34px;
            border-top: 1px solid #e5eaf0;
        }

        .register-section-heading {
            display: flex;
            align-items: center;
            gap: 13px;
            width: 100%;
            margin: 0 0 24px;
            padding: 0;
        }

        .register-section-number {
            display: inline-flex;
            width: 38px;
            height: 38px;
            flex: 0 0 auto;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            color: #fff;
            background: var(--register-navy);
            font-size: 13px;
            font-weight: 800;
        }

        .register-section-title {
            display: block;
            color: #12233b;
            font-size: 18px;
            font-weight: 750;
            line-height: 1.3;
        }

        .register-section-subtitle {
            display: block;
            margin-top: 2px;
            color: #718096;
            font-size: 13px;
            font-weight: 500;
            line-height: 1.35;
        }

        .register-field-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 22px 20px;
        }

        .register-field {
            min-width: 0;
        }

        .register-field-label {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 8px;
            color: #263a55;
            font-size: 14px;
            font-weight: 700;
            line-height: 1.35;
        }

        .register-required {
            color: #c23a46;
        }

        .register-control-wrap {
            position: relative;
        }

        .register-control {
            display: block;
            width: 100%;
            min-height: 54px;
            padding: 13px 15px;
            border: 1px solid #cbd5e1;
            border-radius: 11px;
            outline: 0;
            color: #12233b;
            background: #fff;
            font-family: inherit;
            font-size: 16px;
            font-weight: 450;
            line-height: 1.4;
            box-shadow: 0 1px 2px rgba(15, 23, 42, .025);
            transition: border-color .16s ease, box-shadow .16s ease, background-color .16s ease;
        }

        .register-control::placeholder {
            color: #8c9aab;
            opacity: 1;
        }

        .register-control:hover {
            border-color: #9eafc2;
        }

        .register-control:focus {
            border-color: var(--register-blue);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(11, 91, 211, .12);
        }

        .register-control[aria-invalid="true"] {
            border-color: #d75a66;
            background: #fffafb;
        }

        select.register-control {
            cursor: pointer;
        }

        .register-control--password {
            padding-right: 52px;
        }

        .register-password-toggle {
            position: absolute;
            top: 50%;
            right: 7px;
            display: inline-flex;
            width: 40px;
            height: 40px;
            align-items: center;
            justify-content: center;
            padding: 0;
            border: 0;
            border-radius: 9px;
            color: #64748b;
            background: transparent;
            cursor: pointer;
            transform: translateY(-50%);
        }

        .register-password-toggle:hover,
        .register-password-toggle:focus-visible {
            color: var(--register-navy);
            background: #eef3f8;
        }

        .register-password-toggle svg {
            width: 20px;
            height: 20px;
        }

        .register-password-toggle .register-eye-closed,
        .register-password-toggle[aria-pressed="true"] .register-eye-open {
            display: none;
        }

        .register-password-toggle[aria-pressed="true"] .register-eye-closed {
            display: block;
        }

        .register-field-help,
        .register-field-error {
            display: block;
            margin-top: 7px;
            font-size: 12px;
            line-height: 1.45;
        }

        .register-field-help {
            color: #6c7b8f;
        }

        .register-field-error {
            color: #b42332;
            font-weight: 650;
        }

        .register-strength {
            margin-top: 12px;
        }

        .register-strength-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            color: #64748b;
            font-size: 12px;
            font-weight: 650;
            line-height: 1.3;
        }

        .register-strength-track {
            height: 6px;
            margin-top: 8px;
            overflow: hidden;
            border-radius: 999px;
            background: #e5eaf0;
        }

        .register-strength-bar {
            width: 0;
            height: 100%;
            border-radius: inherit;
            background: #c23a46;
            transition: width .2s ease, background-color .2s ease;
        }

        .register-strength[data-level="2"] .register-strength-bar {
            background: #d17a16;
        }

        .register-strength[data-level="3"] .register-strength-bar,
        .register-strength[data-level="4"] .register-strength-bar {
            background: #16835b;
        }

        .register-terms {
            display: grid;
            grid-template-columns: 20px minmax(0, 1fr);
            gap: 13px;
            margin-top: 32px;
            padding: 17px 18px;
            border: 1px solid #dce3ec;
            border-radius: 13px;
            color: #43546a;
            background: #f8fafc;
            font-size: 14px;
            line-height: 1.55;
            cursor: pointer;
        }

        .register-terms input {
            width: 18px;
            height: 18px;
            margin: 2px 0 0;
            accent-color: var(--register-blue);
        }

        .register-terms a {
            color: var(--register-blue-dark);
            font-weight: 700;
            text-decoration: none;
        }

        .register-terms a:hover {
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .register-form-footer {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 24px;
            align-items: center;
            margin-top: 26px;
        }

        .register-review-note {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin: 0;
            color: #66758a;
            font-size: 12px;
            line-height: 1.55;
        }

        .register-review-note svg {
            width: 18px;
            height: 18px;
            flex: 0 0 auto;
            margin-top: 1px;
            color: #16835b;
        }

        .register-submit {
            display: inline-flex;
            min-width: 190px;
            min-height: 54px;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 0 23px;
            border: 1px solid var(--register-blue);
            border-radius: 11px;
            color: #fff;
            background: var(--register-blue);
            font-family: inherit;
            font-size: 15px;
            font-weight: 750;
            line-height: 1;
            box-shadow: 0 9px 20px rgba(11, 91, 211, .18);
            cursor: pointer;
            transition: background-color .16s ease, border-color .16s ease, box-shadow .16s ease;
        }

        .register-submit:hover,
        .register-submit:focus-visible {
            border-color: var(--register-blue-dark);
            background: var(--register-blue-dark);
            box-shadow: 0 11px 24px rgba(11, 91, 211, .23);
        }

        .register-submit:disabled {
            cursor: wait;
            opacity: .72;
        }

        .register-submit svg {
            width: 18px;
            height: 18px;
        }

        .register-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 22px 4px 0;
            color: #66758a;
            font-size: 13px;
            line-height: 1.45;
        }

        .register-footer p {
            margin: 0;
        }

        .register-footer-links {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 18px;
        }

        .register-footer a {
            color: #526176;
            font-weight: 600;
            text-decoration: none;
        }

        .register-footer a:hover {
            color: var(--register-text);
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        @media (max-width: 1100px) {
            .register-main {
                grid-template-columns: minmax(0, 1fr);
            }

            .register-intro {
                position: relative;
                top: auto;
                min-height: auto;
                padding: 40px;
            }

            .register-intro h1,
            .register-intro-description {
                max-width: 760px;
            }

            .register-steps {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 16px;
                margin-top: 34px;
            }

            .register-step {
                grid-template-columns: 44px minmax(0, 1fr);
                min-height: auto;
            }

            .register-step:not(:last-child)::before {
                display: none;
            }

            .register-trust {
                max-width: 620px;
            }
        }

        @media (max-width: 760px) {
            .register-shell {
                width: min(calc(100% - 24px), 1320px);
                padding-top: 12px;
            }

            .register-topbar {
                align-items: flex-start;
                padding: 13px;
            }

            .register-brand-subtitle,
            .register-nav-home {
                display: none;
            }

            .register-navigation {
                gap: 8px;
            }

            .register-navigation .language-selector .language-btn {
                width: auto;
                min-height: 44px;
                padding-right: 10px;
                padding-left: 10px;
            }

            .register-navigation .language-selector .lang-code {
                display: none;
            }

            .register-nav-link {
                min-height: 44px;
                padding: 0 14px;
            }

            .register-main {
                margin-top: 14px;
            }

            .register-intro {
                padding: 32px 25px;
                border-radius: 18px;
            }

            .register-intro h1 {
                margin-top: 20px;
                font-size: clamp(32px, 10vw, 43px);
            }

            .register-intro-description {
                margin-top: 15px;
                font-size: 16px;
            }

            .register-steps {
                grid-template-columns: minmax(0, 1fr);
                gap: 0;
                margin-top: 30px;
            }

            .register-step {
                min-height: 78px;
            }

            .register-step:not(:last-child)::before {
                display: block;
            }

            .register-trust {
                margin-top: 18px;
            }

            .register-card {
                padding: 29px 23px 31px;
                border-radius: 18px;
            }

            .register-card-header {
                display: block;
                padding-bottom: 25px;
            }

            .register-secure-status {
                margin-top: 17px;
            }

            .register-field-grid {
                grid-template-columns: minmax(0, 1fr);
            }

            .register-form-footer {
                grid-template-columns: minmax(0, 1fr);
            }

            .register-submit {
                width: 100%;
            }

            .register-footer {
                flex-direction: column;
                align-items: flex-start;
            }

            .register-footer-links {
                justify-content: flex-start;
            }
        }

        @media (max-width: 430px) {
            .register-brand {
                gap: 9px;
            }

            .register-brand-logo {
                width: 44px;
                height: 44px;
            }

            .register-brand-logo img {
                width: 100%;
                height: 100%;
            }

            .register-brand-name {
                max-width: 96px;
                font-size: 14px;
            }

            .register-nav-link--primary {
                padding: 0 11px;
                font-size: 13px;
            }
        }

        @media (max-width: 360px) {
            .register-topbar {
                gap: 8px;
            }

            .register-brand-name {
                display: none;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .register-nav-link,
            .register-control,
            .register-submit,
            .register-strength-bar {
                transition: none;
            }
        }
    </style>
@endpush

@section('content')
    <div class="register-page">
        <div class="register-shell">
            <header class="register-topbar">
                <a href="{{ localized_route('home') }}" class="register-brand" aria-label="Zuider Bank S.A">
                    <span class="register-brand-logo">
                        <img src="{{ asset('images/Logosite.png') }}" alt="">
                    </span>
                    <span>
                        <span class="register-brand-name">Zuider Bank S.A</span>
                        <span class="register-brand-subtitle">{{ __('auth_ui.secure_client_access') }}</span>
                    </span>
                </a>

                <nav class="register-navigation" aria-label="{{ __('auth.nav_home') }}">
                    @include('components.language-selector')
                    <a href="{{ localized_route('home') }}" class="register-nav-link register-nav-home">
                        {{ __('auth.nav_home') }}
                    </a>
                    <a href="{{ localized_route('login', ['locale' => app()->getLocale()]) }}" class="register-nav-link register-nav-link--primary">
                        {{ __('auth.nav_login') }}
                    </a>
                </nav>
            </header>

            <main class="register-main">
                <aside class="register-intro" aria-labelledby="register-intro-title">
                    <div class="register-intro-content">
                        <span class="register-security-label">
                            {{ __('auth.register_feature_security') }} {{ __('auth.register_feature_security_bold') }}
                        </span>

                        <h1 id="register-intro-title">
                            {{ __('auth.register_hero_title_1') }}
                            {{ __('auth.register_hero_title_2') }}
                            {{ __('auth.register_hero_title_3') }}
                            {{ __('auth.register_hero_title_4') }}
                        </h1>

                        <p class="register-intro-description">
                            {{ __('auth.register_hero_description_1') }}
                            {{ __('auth.register_hero_description_2') }}
                            {{ __('auth.register_hero_description_3') }}
                            {{ __('auth.register_hero_description_4') }}.
                        </p>

                        <ol class="register-steps">
                            <li class="register-step">
                                <span class="register-step-number">01</span>
                                <div>
                                    <strong>{{ __('auth_ui.identity') }}</strong>
                                    <p>{{ __('auth.register_feature_fast') }} {{ __('auth.register_feature_fast_bold') }}</p>
                                </div>
                            </li>
                            <li class="register-step">
                                <span class="register-step-number">02</span>
                                <div>
                                    <strong>{{ __('auth_ui.validation') }}</strong>
                                    <p>{{ __('auth_ui.admin_review') }}</p>
                                </div>
                            </li>
                            <li class="register-step">
                                <span class="register-step-number">03</span>
                                <div>
                                    <strong>{{ __('auth_ui.activation') }}</strong>
                                    <p>{{ __('auth_ui.secure') }}</p>
                                </div>
                            </li>
                        </ol>

                        <div class="register-trust">
                            <span class="register-trust-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M12 3 5.5 5.7v5.6c0 4.2 2.7 8 6.5 9.7 3.8-1.7 6.5-5.5 6.5-9.7V5.7L12 3Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                    <path d="m9 12 2 2 4-4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <div>
                                <strong>{{ __('auth_ui.secure_client_access') }}</strong>
                                <p>{{ __('auth_ui.login_security_text') }}</p>
                            </div>
                        </div>
                    </div>
                </aside>

                <section class="register-card" aria-labelledby="register-form-title">
                    <div class="register-card-header">
                        <div>
                            <p class="register-eyebrow">{{ __('auth_ui.new_client') }}</p>
                            <h2 id="register-form-title">{{ __('auth.register_title') }}</h2>
                            <p class="register-card-login">
                                {{ __('auth.already_account') }}
                                <a href="{{ localized_route('login', ['locale' => app()->getLocale()]) }}">{{ __('auth.login_link') }}</a>
                            </p>
                        </div>
                        <span class="register-secure-status">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <rect x="5" y="10" width="14" height="10" rx="2.5" stroke="currentColor" stroke-width="1.8"/>
                                <path d="M8.5 10V7.5a3.5 3.5 0 0 1 7 0V10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                            {{ __('auth_ui.secure') }}
                        </span>
                    </div>

                    @if ($errors->any())
                        <div class="register-error-summary" role="alert">
                            <span class="register-error-icon" aria-hidden="true">!</span>
                            <div>
                                <strong>{{ __('auth.register_error_title') }}</strong>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form id="register-form" class="register-form" method="POST" action="{{ localized_route('register', ['locale' => app()->getLocale()]) }}">
                        @csrf

                        <fieldset class="register-form-section">
                            <legend class="register-section-heading">
                                <span class="register-section-number">01</span>
                                <span>
                                    <span class="register-section-title">{{ __('auth_ui.identity') }}</span>
                                    <span class="register-section-subtitle">{{ __('auth.register_feature_fast') }} {{ __('auth.register_feature_fast_bold') }}</span>
                                </span>
                            </legend>

                            <div class="register-field-grid">
                                <div class="register-field">
                                    <label for="first_name" class="register-field-label">
                                        <span>{{ __('auth.first_name') }} <span class="register-required" aria-hidden="true">*</span></span>
                                    </label>
                                    <input
                                        id="first_name"
                                        name="first_name"
                                        type="text"
                                        required
                                        autocomplete="given-name"
                                        value="{{ old('first_name') }}"
                                        placeholder="{{ __('auth.first_name_placeholder') }}"
                                        class="register-control"
                                        @error('first_name') aria-invalid="true" aria-describedby="first_name-error" @enderror
                                    >
                                    @error('first_name')
                                        <span id="first_name-error" class="register-field-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="register-field">
                                    <label for="last_name" class="register-field-label">
                                        <span>{{ __('auth.last_name') }} <span class="register-required" aria-hidden="true">*</span></span>
                                    </label>
                                    <input
                                        id="last_name"
                                        name="last_name"
                                        type="text"
                                        required
                                        autocomplete="family-name"
                                        value="{{ old('last_name') }}"
                                        placeholder="{{ __('auth.last_name_placeholder') }}"
                                        class="register-control"
                                        @error('last_name') aria-invalid="true" aria-describedby="last_name-error" @enderror
                                    >
                                    @error('last_name')
                                        <span id="last_name-error" class="register-field-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="register-field">
                                    <label for="email" class="register-field-label">
                                        <span>{{ __('auth.email_address') }} <span class="register-required" aria-hidden="true">*</span></span>
                                    </label>
                                    <input
                                        id="email"
                                        name="email"
                                        type="email"
                                        required
                                        autocomplete="email"
                                        inputmode="email"
                                        value="{{ old('email') }}"
                                        placeholder="{{ __('auth.email_address_placeholder') }}"
                                        class="register-control"
                                        @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                                    >
                                    @error('email')
                                        <span id="email-error" class="register-field-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="register-field">
                                    <label for="phone" class="register-field-label">{{ __('auth.phone') }}</label>
                                    <input
                                        id="phone"
                                        name="phone"
                                        type="tel"
                                        autocomplete="tel"
                                        inputmode="tel"
                                        value="{{ old('phone') }}"
                                        placeholder="{{ __('auth.phone_placeholder') }}"
                                        class="register-control"
                                        aria-describedby="phone-help{{ $errors->has('phone') ? ' phone-error' : '' }}"
                                        @error('phone') aria-invalid="true" @enderror
                                    >
                                    <span id="phone-help" class="register-field-help">{{ __('auth.phone_help') }}</span>
                                    @error('phone')
                                        <span id="phone-error" class="register-field-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="register-field">
                                    <label for="country" class="register-field-label">{{ __('auth.country') }}</label>
                                    <select
                                        id="country"
                                        name="country"
                                        autocomplete="country-name"
                                        class="register-control"
                                        @error('country') aria-invalid="true" aria-describedby="country-error" @enderror
                                    >
                                        <option value="">{{ __('auth.country_select') }}</option>
                                        @foreach ($countries as $value => $label)
                                            <option value="{{ $value }}" {{ old('country') === $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('country')
                                        <span id="country-error" class="register-field-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="register-field">
                                    <label for="date_of_birth" class="register-field-label">
                                        <span>{{ __('auth.date_of_birth') }} <span class="register-required" aria-hidden="true">*</span></span>
                                    </label>
                                    <input
                                        id="date_of_birth"
                                        name="date_of_birth"
                                        type="date"
                                        required
                                        autocomplete="bday"
                                        max="{{ now()->subDay()->toDateString() }}"
                                        value="{{ old('date_of_birth') }}"
                                        class="register-control"
                                        @error('date_of_birth') aria-invalid="true" aria-describedby="date_of_birth-error" @enderror
                                    >
                                    @error('date_of_birth')
                                        <span id="date_of_birth-error" class="register-field-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="register-field">
                                    <label for="id_type" class="register-field-label">
                                        <span>{{ __('auth.id_type') }} <span class="register-required" aria-hidden="true">*</span></span>
                                    </label>
                                    <select
                                        id="id_type"
                                        name="id_type"
                                        required
                                        class="register-control"
                                        @error('id_type') aria-invalid="true" aria-describedby="id_type-error" @enderror
                                    >
                                        <option value="">{{ __('auth.id_type_select') }}</option>
                                        <option value="CNI" {{ old('id_type') === 'CNI' ? 'selected' : '' }}>{{ __('auth.id_type_cni') }}</option>
                                        <option value="Passport" {{ old('id_type') === 'Passport' ? 'selected' : '' }}>{{ __('auth.id_type_passport') }}</option>
                                        <option value="Permis" {{ old('id_type') === 'Permis' ? 'selected' : '' }}>{{ __('auth.id_type_license') }}</option>
                                    </select>
                                    @error('id_type')
                                        <span id="id_type-error" class="register-field-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="register-field">
                                    <label for="id_number" class="register-field-label">
                                        <span>{{ __('auth.id_number') }} <span class="register-required" aria-hidden="true">*</span></span>
                                    </label>
                                    <input
                                        id="id_number"
                                        name="id_number"
                                        type="text"
                                        required
                                        autocomplete="off"
                                        value="{{ old('id_number') }}"
                                        placeholder="{{ __('auth.id_number_placeholder') }}"
                                        class="register-control"
                                        @error('id_number') aria-invalid="true" aria-describedby="id_number-error" @enderror
                                    >
                                    @error('id_number')
                                        <span id="id_number-error" class="register-field-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="register-form-section">
                            <legend class="register-section-heading">
                                <span class="register-section-number">02</span>
                                <span>
                                    <span class="register-section-title">{{ __('auth_ui.security') }}</span>
                                    <span class="register-section-subtitle">{{ __('auth.register_feature_security') }} {{ __('auth.register_feature_security_bold') }}</span>
                                </span>
                            </legend>

                            <div class="register-field-grid">
                                <div class="register-field">
                                    <label for="password" class="register-field-label">
                                        <span>{{ __('auth.password_field') }} <span class="register-required" aria-hidden="true">*</span></span>
                                    </label>
                                    <div class="register-control-wrap">
                                        <input
                                            id="password"
                                            name="password"
                                            type="password"
                                            required
                                            minlength="8"
                                            autocomplete="new-password"
                                            placeholder="{{ __('auth.password_placeholder') }}"
                                            class="register-control register-control--password"
                                            @error('password') aria-invalid="true" aria-describedby="password-error" @else aria-describedby="password-strength-label" @enderror
                                        >
                                        <button type="button" class="register-password-toggle" data-password-target="password" aria-label="{{ __('auth.password_field') }}" aria-pressed="false">
                                            <svg class="register-eye-open" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                <path d="M2.5 12s3.5-5 9.5-5 9.5 5 9.5 5-3.5 5-9.5 5-9.5-5-9.5-5Z" stroke="currentColor" stroke-width="1.7"/>
                                                <circle cx="12" cy="12" r="2.5" stroke="currentColor" stroke-width="1.7"/>
                                            </svg>
                                            <svg class="register-eye-closed" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                <path d="m4 4 16 16M10.6 7.1c.46-.07.93-.1 1.4-.1 6 0 9.5 5 9.5 5a16 16 0 0 1-2.3 2.6M6.2 8.1A16.3 16.3 0 0 0 2.5 12s3.5 5 9.5 5c1.15 0 2.2-.18 3.14-.48" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div id="password-strength" class="register-strength" data-level="0">
                                        <div class="register-strength-header">
                                            <span>{{ __('auth.password_strength') }}</span>
                                            <span id="password-strength-label">0%</span>
                                        </div>
                                        <div class="register-strength-track" aria-hidden="true">
                                            <div id="password-strength-bar" class="register-strength-bar"></div>
                                        </div>
                                    </div>
                                    @error('password')
                                        <span id="password-error" class="register-field-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="register-field">
                                    <label for="password_confirmation" class="register-field-label">
                                        <span>{{ __('auth.confirm_password') }} <span class="register-required" aria-hidden="true">*</span></span>
                                    </label>
                                    <div class="register-control-wrap">
                                        <input
                                            id="password_confirmation"
                                            name="password_confirmation"
                                            type="password"
                                            required
                                            minlength="8"
                                            autocomplete="new-password"
                                            placeholder="{{ __('auth.password_placeholder') }}"
                                            class="register-control register-control--password"
                                        >
                                        <button type="button" class="register-password-toggle" data-password-target="password_confirmation" aria-label="{{ __('auth.confirm_password') }}" aria-pressed="false">
                                            <svg class="register-eye-open" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                <path d="M2.5 12s3.5-5 9.5-5 9.5 5 9.5 5-3.5 5-9.5 5-9.5-5-9.5-5Z" stroke="currentColor" stroke-width="1.7"/>
                                                <circle cx="12" cy="12" r="2.5" stroke="currentColor" stroke-width="1.7"/>
                                            </svg>
                                            <svg class="register-eye-closed" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                <path d="m4 4 16 16M10.6 7.1c.46-.07.93-.1 1.4-.1 6 0 9.5 5 9.5 5a16 16 0 0 1-2.3 2.6M6.2 8.1A16.3 16.3 0 0 0 2.5 12s3.5 5 9.5 5c1.15 0 2.2-.18 3.14-.48" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <label for="terms" class="register-terms">
                            <input id="terms" name="terms" type="checkbox" value="1" required {{ old('terms') ? 'checked' : '' }}>
                            <span>
                                {{ __('auth.terms_accept') }}
                                <a href="{{ localized_route('support.mentions-legales') }}">{{ __('auth.terms_link') }}</a>
                                {{ __('auth.terms_and') }}
                                <a href="{{ localized_route('support.securite') }}">{{ __('auth.privacy_link') }}</a>.
                            </span>
                        </label>
                        @error('terms')
                            <span class="register-field-error">{{ $message }}</span>
                        @enderror

                        <div class="register-form-footer">
                            <p class="register-review-note">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M12 3 5.5 5.7v5.6c0 4.2 2.7 8 6.5 9.7 3.8-1.7 6.5-5.5 6.5-9.7V5.7L12 3Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                    <path d="m9 12 2 2 4-4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>{{ __('auth_ui.validation_text') }}</span>
                            </p>

                            <button id="register-submit" type="submit" class="register-submit">
                                <span>{{ __('auth.register_button') }}</span>
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M5 12h14m-5-5 5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </section>
            </main>

            <footer class="register-footer">
                <p>&copy; {{ date('Y') }} Zuider Bank S.A — {{ __('auth.footer_copyright') }}</p>
                <div class="register-footer-links">
                    <a href="{{ localized_route('support.nous-contacter') }}">{{ __('auth.footer_support') }}</a>
                    <a href="{{ localized_route('support.securite') }}">{{ __('auth.footer_terms') }}</a>
                    <a href="{{ localized_route('support.mentions-legales') }}">{{ __('auth.footer_privacy') }}</a>
                </div>
            </footer>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-password-target]').forEach(function (button) {
                button.addEventListener('click', function () {
                    const input = document.getElementById(button.dataset.passwordTarget);

                    if (!input) {
                        return;
                    }

                    const shouldShow = input.type === 'password';
                    input.type = shouldShow ? 'text' : 'password';
                    button.setAttribute('aria-pressed', shouldShow ? 'true' : 'false');
                });
            });

            const passwordInput = document.getElementById('password');
            const strength = document.getElementById('password-strength');
            const strengthBar = document.getElementById('password-strength-bar');
            const strengthLabel = document.getElementById('password-strength-label');

            const updatePasswordStrength = function () {
                if (!passwordInput || !strength || !strengthBar || !strengthLabel) {
                    return;
                }

                const password = passwordInput.value;
                let score = 0;

                if (password.length >= 8) score++;
                if (/[A-Z]/.test(password) && /[a-z]/.test(password)) score++;
                if (/[0-9]/.test(password)) score++;
                if (/[^A-Za-z0-9]/.test(password)) score++;

                const percentage = score * 25;
                strength.dataset.level = String(score);
                strengthBar.style.width = percentage + '%';
                strengthLabel.textContent = percentage + '%';
            };

            passwordInput?.addEventListener('input', updatePasswordStrength);
            updatePasswordStrength();

            const form = document.getElementById('register-form');
            const submitButton = document.getElementById('register-submit');

            form?.addEventListener('submit', function () {
                if (!submitButton) {
                    return;
                }

                submitButton.disabled = true;
                submitButton.setAttribute('aria-busy', 'true');
            });

            window.addEventListener('pageshow', function () {
                if (!submitButton) {
                    return;
                }

                submitButton.disabled = false;
                submitButton.removeAttribute('aria-busy');
            });
        });
    </script>
@endpush
