<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @include('partials.seo')
  @vite(['resources/css/app.css', 'resources/js/button-feedback.js'])
  <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" media="print" onload="this.media='all'">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
  <noscript>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  </noscript>
  @include('partials.favicon')

  <style>
    :root {
      --ink: #101828;
      --muted: #667085;
      --line: #d9e2ef;
      --navy: #071a2f;
      --blue: #0b5cff;
      --cyan: #00b8d9;
      --green: #12b76a;
      --gold: #f5b544;
      --paper: #f7f9fc;
    }

    * {
      box-sizing: border-box;
    }

    html {
      scroll-behavior: smooth;
    }

    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      color: var(--ink);
      background: #071a2f;
      letter-spacing: 0;
    }

    a {
      text-decoration: none;
    }

    .site-shell {
      overflow: hidden;
      background:
        linear-gradient(180deg, #f8fbff 0%, #ffffff 42%, #f8fbff 100%);
    }

    .container-bank {
      width: min(1440px, calc(100% - clamp(24px, 4vw, 56px)));
      margin: 0 auto;
    }

    .bank-nav {
      position: fixed;
      z-index: 60;
      top: 0;
      left: 0;
      right: 0;
      padding-top: 14px;
      padding-bottom: 10px;
      pointer-events: none;
      background: linear-gradient(180deg, #071a2f 0%, rgba(7, 26, 47, 0.94) 64%, rgba(7, 26, 47, 0) 100%);
    }

    .bank-nav-inner {
      pointer-events: auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 18px;
      min-height: 74px;
      padding: 12px 16px 12px 20px;
      border: 1px solid rgba(255, 255, 255, 0.24);
      border-radius: 999px;
      background: rgba(7, 26, 47, 0.82);
      box-shadow: 0 24px 70px rgba(7, 26, 47, 0.2);
      backdrop-filter: blur(22px);
    }

    .brand-mark {
      display: inline-flex;
      align-items: center;
      gap: 0;
      min-width: 0;
      color: #ffffff;
      font-weight: 800;
      font-size: 1rem;
    }

    .brand-mark img {
      width: clamp(150px, 14vw, 220px);
      height: 50px;
      border-radius: 0;
      background: transparent;
      padding: 0;
      object-fit: contain;
      filter: drop-shadow(0 8px 18px rgba(0, 0, 0, 0.22));
    }

    .brand-mark span {
      position: absolute;
      width: 1px;
      height: 1px;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      white-space: nowrap;
    }

    .nav-links {
      display: flex;
      align-items: center;
      gap: clamp(14px, 1.6vw, 26px);
    }

    .nav-links a {
      color: rgba(255, 255, 255, 0.82);
      font-size: 0.93rem;
      font-weight: 600;
      transition: color 0.2s ease;
      white-space: nowrap;
    }

    .nav-links a:hover {
      color: #ffffff;
    }

    .nav-actions {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      min-height: 46px;
      padding: 0 18px;
      border-radius: 999px;
      font-weight: 800;
      font-size: 0.94rem;
      transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
      white-space: nowrap;
    }

    .btn:hover {
      transform: translateY(-2px);
    }

    .btn-primary {
      color: #071a2f;
      background: #ffffff;
      box-shadow: 0 14px 34px rgba(255, 255, 255, 0.2);
    }

    .btn-accent {
      color: #ffffff;
      background: linear-gradient(135deg, #0b5cff 0%, #00b8d9 100%);
      box-shadow: 0 20px 40px rgba(11, 92, 255, 0.28);
    }

    .btn-outline {
      color: #ffffff;
      border: 1px solid rgba(255, 255, 255, 0.28);
      background: rgba(255, 255, 255, 0.08);
    }

    .mobile-toggle {
      display: none;
      width: 46px;
      height: 46px;
      border: 0;
      border-radius: 50%;
      color: #ffffff;
      background: rgba(255, 255, 255, 0.12);
      cursor: pointer;
    }

    body.mobile-menu-active {
      overflow: hidden;
    }

    .mobile-menu-backdrop {
      position: fixed;
      inset: 0;
      z-index: 89;
      display: none;
      background: rgba(2, 6, 23, 0.52);
      opacity: 0;
      backdrop-filter: blur(10px);
      transition: opacity .32s ease;
    }

    .mobile-menu-backdrop.open {
      display: block;
      opacity: 1;
    }

    .mobile-menu {
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
        linear-gradient(180deg, rgba(7, 26, 47, 0.98), rgba(6, 23, 44, 0.96));
      box-shadow: -28px 0 80px rgba(2, 6, 23, 0.34);
      backdrop-filter: blur(24px);
      opacity: 0;
      pointer-events: none;
      transform: translateX(112%);
      transition: transform .42s cubic-bezier(.22, 1, .36, 1), opacity .26s ease;
      will-change: transform, opacity;
    }

    .mobile-menu.open {
      opacity: 1;
      pointer-events: auto;
      transform: translateX(0);
    }

    .mobile-menu-head {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 14px;
      padding: 4px 2px 18px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.12);
    }

    .mobile-menu-brand {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      color: #ffffff;
      font-family: 'Sora', sans-serif;
      font-weight: 800;
      letter-spacing: -0.02em;
    }

    .mobile-menu-brand img {
      width: 42px;
      height: 42px;
      object-fit: contain;
    }

    .mobile-close {
      width: 42px;
      height: 42px;
      border: 1px solid rgba(255, 255, 255, 0.14);
      border-radius: 50%;
      color: #ffffff;
      background: rgba(255, 255, 255, 0.1);
      cursor: pointer;
    }

    .mobile-menu-links {
      display: grid;
      gap: 8px;
      padding: 18px 0;
    }

    .mobile-menu a {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      color: #ffffff;
      padding: 13px 14px;
      border: 1px solid transparent;
      border-radius: 18px;
      font-weight: 700;
      background: rgba(255, 255, 255, 0.05);
      transition: transform .2s ease, background .2s ease, border-color .2s ease;
    }

    .mobile-menu a:hover {
      transform: translateX(-4px);
      border-color: rgba(255, 255, 255, 0.14);
      background: rgba(255, 255, 255, 0.1);
    }

    .mobile-menu-foot {
      display: grid;
      gap: 10px;
      margin-top: auto;
      padding-top: 18px;
      border-top: 1px solid rgba(255, 255, 255, 0.12);
    }

    .mobile-menu-foot .language-selector {
      width: 100%;
    }

    .mobile-menu-foot .language-selector .language-btn {
      width: 100%;
      justify-content: center;
    }

    .mobile-menu-foot .mobile-auth-link {
      justify-content: center;
    }

    .hero {
      position: relative;
      min-height: 94vh;
      padding: 148px 0 78px;
      color: #ffffff;
      background:
        linear-gradient(120deg, rgba(7, 26, 47, 0.98) 0%, rgba(8, 41, 75, 0.94) 54%, rgba(7, 26, 47, 0.98) 100%);
    }

    .hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background:
        linear-gradient(90deg, rgba(7, 26, 47, 0.98) 0%, rgba(7, 26, 47, 0.74) 45%, rgba(7, 26, 47, 0.32) 100%),
        repeating-linear-gradient(90deg, rgba(255, 255, 255, 0.06) 0, rgba(255, 255, 255, 0.06) 1px, transparent 1px, transparent 92px);
      pointer-events: none;
    }

    .hero::after {
      content: '';
      position: absolute;
      left: 0;
      right: 0;
      bottom: 0;
      height: 120px;
      background: linear-gradient(180deg, transparent 0%, #ffffff 100%);
      pointer-events: none;
    }

    .hero-layout {
      position: relative;
      z-index: 2;
      display: grid;
      grid-template-columns: minmax(0, 1.02fr) minmax(420px, 0.84fr);
      align-items: center;
      gap: clamp(48px, 6vw, 112px);
    }

    .eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 9px;
      padding: 9px 14px;
      border: 1px solid rgba(255, 255, 255, 0.26);
      border-radius: 999px;
      color: rgba(255, 255, 255, 0.9);
      background: rgba(255, 255, 255, 0.1);
      font-weight: 800;
      font-size: 0.84rem;
    }

    .hero h1 {
      max-width: 680px;
      margin: 24px 0 20px;
      font-size: clamp(2.35rem, 4.5vw, 4.75rem);
      line-height: 1.06;
      letter-spacing: 0;
      font-weight: 800;
    }

    .hero-subtitle {
      max-width: 620px;
      margin: 0;
      color: #8ee9ff;
      font-size: clamp(1.16rem, 1.7vw, 1.5rem);
      font-weight: 700;
      line-height: 1.35;
      opacity: 1;
      filter: blur(0);
      transform: translateY(0);
      transition: opacity 0.48s ease, transform 0.48s ease, filter 0.48s ease;
    }

    .hero-title-slider {
      display: flex;
      flex-direction: column;
      justify-content: center;
      max-width: 650px;
      min-height: clamp(86px, 8vw, 112px);
      margin-bottom: 12px;
    }

    .hero-subtitle.is-fading {
      opacity: 0;
      filter: blur(5px);
      transform: translateY(-10px);
    }

    .hero-title-slider-meta {
      display: flex;
      align-items: center;
      gap: 12px;
      width: min(100%, 330px);
      margin-top: 13px;
    }

    .hero-title-counter {
      min-width: 47px;
      color: rgba(255, 255, 255, 0.52);
      font-size: 0.68rem;
      font-weight: 800;
      letter-spacing: 0.12em;
    }

    .hero-title-progress {
      position: relative;
      flex: 1;
      height: 2px;
      overflow: hidden;
      border-radius: 999px;
      background: rgba(255, 255, 255, 0.16);
    }

    .hero-title-progress span {
      position: absolute;
      inset: 0;
      background: linear-gradient(90deg, #8ee9ff, #ffffff);
      transform: scaleX(0);
      transform-origin: left center;
    }

    .hero-title-progress span.is-running {
      animation: heroTitleProgress 5.6s linear forwards;
    }

    @keyframes heroTitleProgress {
      to { transform: scaleX(1); }
    }

    .hero-copy {
      max-width: 650px;
      color: rgba(255, 255, 255, 0.78);
      font-size: clamp(1.05rem, 1.4vw, 1.24rem);
      line-height: 1.8;
    }

    .hero-actions {
      display: flex;
      flex-wrap: wrap;
      gap: 14px;
      margin-top: 34px;
    }

    .hero-proof {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 14px;
      max-width: 720px;
      margin-top: 42px;
    }

    .proof-item {
      padding: 18px;
      border: 1px solid rgba(255, 255, 255, 0.18);
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(14px);
    }

    .proof-item strong {
      display: block;
      color: #ffffff;
      font-size: 1.35rem;
      font-weight: 800;
      font-variant-numeric: tabular-nums;
    }

    .proof-item span {
      display: block;
      margin-top: 6px;
      color: rgba(255, 255, 255, 0.67);
      font-size: 0.85rem;
      line-height: 1.45;
    }

    .card-stage {
      position: relative;
      min-height: 520px;
      perspective: 1400px;
    }

    .hero-card-image {
      position: absolute;
      inset: 34px -24px auto auto;
      width: min(690px, 112%);
      max-width: none;
      filter: drop-shadow(0 45px 70px rgba(0, 0, 0, 0.42));
      transform-origin: 50% 55%;
      animation: cardTurn 11s ease-in-out infinite;
      will-change: transform;
    }

    @keyframes cardTurn {
      0%, 100% { transform: rotateX(8deg) rotateY(-22deg) rotateZ(-2deg) translateY(0); }
      50% { transform: rotateX(3deg) rotateY(18deg) rotateZ(2deg) translateY(-18px); }
    }

    .section {
      position: relative;
      padding: clamp(82px, 8vw, 124px) 0;
    }

    #about {
      color: var(--ink);
      background: #ffffff;
    }

    #about .section-heading h2 {
      color: #0b1220;
    }

    #about .section-heading p,
    #about .lead-text {
      color: #475467;
    }

    .section.soft {
      background: var(--paper);
    }

    .section.dark {
      color: #ffffff;
      background: #071a2f;
    }

    .section-heading {
      max-width: 920px;
      margin-bottom: 48px;
    }

    .section-kicker {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: var(--blue);
      font-size: 0.82rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.08em;
    }

    .section h2 {
      margin: 14px 0 0;
      font-size: clamp(2.15rem, 4vw, 4rem);
      line-height: 1.04;
      font-weight: 800;
      letter-spacing: 0;
    }

    .section-heading p {
      margin: 18px 0 0;
      color: var(--muted);
      font-size: 1.08rem;
      line-height: 1.75;
    }

    .dark .section-heading p {
      color: rgba(255, 255, 255, 0.7);
    }

    .about-grid {
      display: grid;
      grid-template-columns: minmax(0, 1fr) minmax(360px, 0.72fr);
      gap: clamp(48px, 6vw, 96px);
      align-items: start;
    }

    .about-copy {
      max-width: 820px;
    }

    .lead-text {
      color: #475467;
      font-size: 1.05rem;
      line-height: 1.85;
    }

    .about-values {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: clamp(32px, 3.2vw, 56px);
      grid-column: 1 / -1;
      margin-top: clamp(10px, 2vw, 28px);
    }

    .value-box,
    .service-card,
    .review-card,
    .faq-item {
      border: 1px solid var(--line);
      border-radius: 8px;
      background: #ffffff;
      box-shadow: 0 18px 46px rgba(16, 24, 40, 0.06);
    }

    .value-box {
      padding: clamp(28px, 2.4vw, 36px);
      min-height: 100%;
    }

    .value-box p {
      max-width: 42rem;
    }

    .value-box i,
    .service-icon {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 44px;
      height: 44px;
      border-radius: 8px;
      color: #ffffff;
      background: linear-gradient(135deg, var(--blue), var(--cyan));
    }

    .value-box h3,
    .service-card h3 {
      margin: 16px 0 8px;
      color: var(--ink);
      font-size: 1.16rem;
      font-weight: 800;
    }

    .value-box p,
    .service-card p {
      margin: 0;
      color: var(--muted);
      line-height: 1.65;
    }

    .happy-client-visual {
      position: relative;
      min-height: 540px;
      border-radius: 8px;
      isolation: isolate;
    }

    .happy-client-visual::before,
    .happy-client-visual::after {
      content: '';
      position: absolute;
      border-radius: 999px;
      pointer-events: none;
    }

    .happy-client-visual::before {
      inset: -24px 28px 42px -18px;
      z-index: -2;
      border: 1px solid rgba(11, 92, 255, 0.2);
      background: linear-gradient(135deg, rgba(11, 92, 255, 0.18), rgba(0, 184, 217, 0.12));
      animation: happyGlow 7s ease-in-out infinite;
    }

    .happy-client-visual::after {
      right: -18px;
      bottom: 42px;
      z-index: 2;
      width: 132px;
      height: 132px;
      border: 1px solid rgba(18, 183, 106, 0.34);
      background: rgba(18, 183, 106, 0.12);
      box-shadow: 0 24px 55px rgba(18, 183, 106, 0.18);
      animation: happyOrbit 8s ease-in-out infinite;
    }

    .happy-client-frame {
      position: relative;
      overflow: hidden;
      height: 100%;
      min-height: 540px;
      border-radius: 8px;
      border: 1px solid rgba(11, 92, 255, 0.14);
      background: #ffffff;
      box-shadow: 0 34px 80px rgba(16, 24, 40, 0.16);
    }

    .happy-client-frame img {
      display: block;
      width: 100%;
      height: 100%;
      min-height: 540px;
      object-fit: cover;
      object-position: center;
    }

    .happy-client-slide {
      position: absolute;
      inset: 0;
      opacity: 0;
      filter: saturate(0.9) contrast(1.02);
      transform: scale(1.075);
      transition:
        opacity 1.45s cubic-bezier(0.22, 1, 0.36, 1),
        filter 1.45s ease,
        transform 7.2s cubic-bezier(0.16, 1, 0.3, 1);
      will-change: opacity, transform;
    }

    .happy-client-slide.is-active {
      z-index: 1;
      opacity: 1;
      filter: saturate(1.06) contrast(1.01);
      transform: scale(1.015);
    }

    .happy-carousel-status {
      position: absolute;
      z-index: 3;
      top: 18px;
      right: 18px;
      display: flex;
      align-items: center;
      width: 64px;
      padding: 9px 12px;
      border: 1px solid rgba(255, 255, 255, 0.48);
      border-radius: 999px;
      background: rgba(7, 26, 47, 0.58);
      box-shadow: 0 12px 30px rgba(7, 26, 47, 0.18);
      backdrop-filter: blur(14px);
    }

    .happy-carousel-progress {
      position: relative;
      flex: 1;
      height: 2px;
      overflow: hidden;
      border-radius: 999px;
      background: rgba(255, 255, 255, 0.28);
    }

    .happy-carousel-progress span {
      position: absolute;
      inset: 0;
      background: #8ee9ff;
      transform: scaleX(0);
      transform-origin: left center;
    }

    .happy-carousel-progress span.is-running {
      animation: happyCarouselProgress 6.4s linear forwards;
    }

    @keyframes happyCarouselProgress {
      to { transform: scaleX(1); }
    }

    .happy-client-frame::before {
      content: '';
      position: absolute;
      inset: 0;
      z-index: 2;
      background: linear-gradient(180deg, rgba(7, 26, 47, 0) 42%, rgba(7, 26, 47, 0.26) 100%);
      pointer-events: none;
    }

    .happy-client-badge {
      position: absolute;
      z-index: 3;
      left: -18px;
      bottom: 34px;
      display: inline-flex;
      align-items: center;
      gap: 12px;
      max-width: 310px;
      padding: 16px 18px;
      border: 1px solid rgba(255, 255, 255, 0.54);
      border-radius: 8px;
      color: #ffffff;
      background: rgba(7, 26, 47, 0.78);
      box-shadow: 0 24px 56px rgba(7, 26, 47, 0.24);
      backdrop-filter: blur(16px);
    }

    .happy-client-badge i {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      flex: 0 0 42px;
      width: 42px;
      height: 42px;
      border-radius: 50%;
      color: #071a2f;
      background: #8ee9ff;
    }

    .happy-client-badge strong {
      display: block;
      font-size: 0.98rem;
      line-height: 1.35;
    }

    .happy-client-badge span {
      display: block;
      margin-top: 3px;
      color: rgba(255, 255, 255, 0.72);
      font-size: 0.82rem;
      line-height: 1.35;
    }

    @keyframes happyGlow {
      0%, 100% { transform: rotate(-4deg) scale(1); opacity: 0.8; }
      50% { transform: rotate(3deg) scale(1.04); opacity: 1; }
    }

    @keyframes happyOrbit {
      0%, 100% { transform: translate3d(0, 0, 0) scale(1); }
      50% { transform: translate3d(-18px, -20px, 0) scale(1.08); }
    }

    @keyframes happyImageFloat {
      0%, 100% { transform: scale(1.02) translateY(0); }
      50% { transform: scale(1.055) translateY(-8px); }
    }

    .services-grid {
      display: grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: clamp(18px, 2vw, 28px);
    }

    .service-card {
      display: flex;
      flex-direction: column;
      min-height: 405px;
      padding: clamp(24px, 2.2vw, 34px);
    }

    .service-card ul {
      display: grid;
      gap: 12px;
      margin: 24px 0;
      padding: 0;
      list-style: none;
    }

    .service-card li {
      display: flex;
      gap: 10px;
      color: #475467;
      font-size: 0.94rem;
      line-height: 1.5;
    }

    .service-card li i {
      margin-top: 3px;
      color: var(--green);
    }

    .service-card a {
      margin-top: auto;
      color: var(--blue);
      font-weight: 800;
    }

    .cards-showcase {
      position: relative;
      overflow: hidden;
      color: #ffffff;
      background:
        radial-gradient(circle at 12% 18%, rgba(0, 184, 217, 0.18), transparent 28%),
        radial-gradient(circle at 88% 8%, rgba(245, 181, 68, 0.15), transparent 25%),
        linear-gradient(145deg, #06111f 0%, #0a2039 52%, #071a2f 100%);
      isolation: isolate;
    }

    .cards-showcase::before {
      content: '';
      position: absolute;
      inset: 0;
      z-index: -1;
      opacity: 0.22;
      background-image:
        linear-gradient(rgba(255, 255, 255, 0.045) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, 0.045) 1px, transparent 1px);
      background-size: 52px 52px;
      mask-image: linear-gradient(to bottom, #000, transparent 86%);
    }

    .cards-heading {
      display: grid;
      grid-template-columns: minmax(0, 0.75fr) minmax(320px, 0.55fr);
      gap: 36px;
      align-items: end;
      margin-bottom: clamp(42px, 6vw, 78px);
    }

    .cards-heading h2 {
      max-width: 780px;
      margin: 14px 0 0;
      font-size: clamp(2.35rem, 4.6vw, 5rem);
      line-height: 0.98;
      letter-spacing: -0.045em;
    }

    .cards-heading p {
      margin: 0;
      color: rgba(255, 255, 255, 0.68);
      font-size: 1.04rem;
      line-height: 1.75;
    }

    .bank-cards-grid {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: clamp(18px, 2.2vw, 34px);
      align-items: stretch;
    }

    .bank-card-product {
      --card-accent: #60a5fa;
      --card-glow: rgba(59, 130, 246, 0.28);
      position: relative;
      display: flex;
      flex-direction: column;
      min-width: 0;
      padding: clamp(18px, 2vw, 26px);
      border: 1px solid rgba(255, 255, 255, 0.13);
      border-radius: 28px;
      background: rgba(255, 255, 255, 0.065);
      box-shadow: 0 32px 80px rgba(0, 0, 0, 0.24);
      backdrop-filter: blur(18px);
      transition: border-color 0.3s ease, background-color 0.3s ease, transform 0.3s ease;
    }

    .bank-card-product:hover {
      border-color: color-mix(in srgb, var(--card-accent) 58%, transparent);
      background: rgba(255, 255, 255, 0.09);
      transform: translateY(-8px);
    }

    .bank-card-product--premium {
      --card-accent: #e2e8f0;
      --card-glow: rgba(203, 213, 225, 0.3);
    }

    .bank-card-product--vip {
      --card-accent: #f7d774;
      --card-glow: rgba(245, 181, 68, 0.34);
      border-color: rgba(247, 215, 116, 0.28);
    }

    .card-popular-badge {
      position: absolute;
      z-index: 5;
      top: 18px;
      right: 18px;
      display: inline-flex;
      align-items: center;
      gap: 7px;
      padding: 8px 11px;
      border-radius: 999px;
      color: #071a2f;
      background: var(--card-accent);
      box-shadow: 0 10px 28px var(--card-glow);
      font-size: 0.69rem;
      font-weight: 800;
      letter-spacing: 0.08em;
      text-transform: uppercase;
    }

    .bank-card-scene {
      --rx: 5deg;
      --ry: -8deg;
      position: relative;
      display: grid;
      place-items: center;
      min-height: 270px;
      perspective: 1200px;
    }

    .bank-card-scene::after {
      content: '';
      position: absolute;
      right: 10%;
      bottom: 17px;
      left: 10%;
      height: 28px;
      border-radius: 50%;
      background: var(--card-glow);
      filter: blur(20px);
      transform: rotate(-2deg);
      transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .bank-card-3d {
      position: relative;
      z-index: 2;
      width: min(100%, 370px);
      aspect-ratio: 1.586 / 1;
      overflow: hidden;
      padding: 22px;
      border: 1px solid rgba(255, 255, 255, 0.3);
      border-radius: 21px;
      color: #ffffff;
      background:
        radial-gradient(circle at 85% 16%, rgba(255, 255, 255, 0.24), transparent 27%),
        linear-gradient(140deg, #163866 0%, #0a2142 54%, #071326 100%);
      box-shadow:
        -16px 24px 45px rgba(0, 0, 0, 0.35),
        inset 0 1px 0 rgba(255, 255, 255, 0.32),
        inset 0 -1px 0 rgba(0, 0, 0, 0.24);
      transform: rotateX(var(--rx)) rotateY(var(--ry)) translateZ(0);
      transform-style: preserve-3d;
      transition: transform 0.18s ease-out, box-shadow 0.3s ease;
      will-change: transform;
    }

    .bank-card-product--premium .bank-card-3d {
      color: #172033;
      background:
        radial-gradient(circle at 82% 14%, rgba(255, 255, 255, 0.82), transparent 24%),
        linear-gradient(135deg, #f8fafc 0%, #aeb8c5 38%, #eef2f6 67%, #8d99a8 100%);
      border-color: rgba(255, 255, 255, 0.72);
      box-shadow: -16px 24px 48px rgba(3, 14, 29, 0.38), inset 0 1px 0 #ffffff;
    }

    .bank-card-product--vip .bank-card-3d {
      color: #231804;
      background:
        radial-gradient(circle at 83% 14%, rgba(255, 255, 255, 0.54), transparent 22%),
        linear-gradient(135deg, #fff2a9 0%, #bf8120 34%, #f5d36a 61%, #8a570d 100%);
      border-color: rgba(255, 245, 191, 0.7);
      box-shadow: -16px 24px 52px rgba(82, 49, 3, 0.4), inset 0 1px 0 #fff6cb;
    }

    .bank-card-3d::before,
    .bank-card-3d::after {
      content: '';
      position: absolute;
      pointer-events: none;
    }

    .bank-card-3d::before {
      inset: -45% -30%;
      background: linear-gradient(110deg, transparent 36%, rgba(255, 255, 255, 0.32) 47%, transparent 58%);
      transform: translateX(-55%) rotate(8deg);
      transition: transform 0.7s ease;
    }

    .bank-card-product:hover .bank-card-3d::before {
      transform: translateX(58%) rotate(8deg);
    }

    .bank-card-3d::after {
      inset: 0;
      opacity: 0.28;
      background-image: repeating-linear-gradient(120deg, rgba(255,255,255,0.12) 0, rgba(255,255,255,0.12) 1px, transparent 1px, transparent 9px);
    }

    .bank-card-top,
    .bank-card-chip-row,
    .bank-card-bottom {
      position: relative;
      z-index: 2;
      display: flex;
      align-items: center;
      justify-content: space-between;
      transform: translateZ(24px);
    }

    .bank-card-brand {
      font-size: 0.85rem;
      font-weight: 800;
      letter-spacing: 0.04em;
    }

    .bank-card-tier {
      font-size: 0.65rem;
      font-weight: 800;
      letter-spacing: 0.16em;
      text-transform: uppercase;
    }

    .bank-card-chip-row {
      margin-top: 28px;
    }

    .bank-card-chip {
      width: 47px;
      height: 35px;
      border: 1px solid rgba(76, 57, 12, 0.28);
      border-radius: 8px;
      background:
        linear-gradient(90deg, transparent 46%, rgba(69, 49, 6, 0.28) 48%, rgba(69, 49, 6, 0.28) 52%, transparent 54%),
        linear-gradient(0deg, transparent 44%, rgba(69, 49, 6, 0.22) 46%, rgba(69, 49, 6, 0.22) 52%, transparent 54%),
        linear-gradient(135deg, #f7e39a, #b88c29);
    }

    .bank-card-contactless {
      font-size: 1.35rem;
      transform: rotate(90deg);
    }

    .bank-card-number {
      position: relative;
      z-index: 2;
      margin-top: 23px;
      font-family: 'Courier New', monospace;
      font-size: clamp(0.95rem, 1.45vw, 1.22rem);
      font-weight: 700;
      letter-spacing: 0.11em;
      transform: translateZ(28px);
    }

    .bank-card-bottom {
      margin-top: 18px;
      font-size: 0.62rem;
      letter-spacing: 0.08em;
      text-transform: uppercase;
    }

    .bank-card-bottom strong {
      display: block;
      margin-top: 4px;
      font-size: 0.72rem;
      letter-spacing: 0.1em;
    }

    .card-product-copy {
      display: flex;
      flex: 1;
      flex-direction: column;
      padding: 8px 5px 4px;
    }

    .card-product-label {
      color: var(--card-accent);
      font-size: 0.72rem;
      font-weight: 800;
      letter-spacing: 0.13em;
      text-transform: uppercase;
    }

    .card-product-copy h3 {
      margin: 9px 0 10px;
      font-size: 1.65rem;
    }

    .card-product-copy > p {
      min-height: 76px;
      margin: 0;
      color: rgba(255, 255, 255, 0.64);
      font-size: 0.93rem;
      line-height: 1.65;
    }

    .card-features {
      display: grid;
      gap: 12px;
      margin: 22px 0 26px;
      padding: 20px 0 0;
      border-top: 1px solid rgba(255, 255, 255, 0.11);
      list-style: none;
    }

    .card-features li {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      color: rgba(255, 255, 255, 0.82);
      font-size: 0.88rem;
      line-height: 1.5;
    }

    .card-features i {
      margin-top: 4px;
      color: var(--card-accent);
    }

    .card-select-link {
      display: inline-flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      width: 100%;
      min-height: 50px;
      margin-top: auto;
      padding: 0 18px;
      border: 1px solid color-mix(in srgb, var(--card-accent) 42%, transparent);
      border-radius: 999px;
      color: #ffffff;
      background: color-mix(in srgb, var(--card-accent) 12%, transparent);
      font-size: 0.88rem;
      font-weight: 800;
      transition: background-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
    }

    .card-select-link:hover {
      color: #071a2f;
      background: var(--card-accent);
      transform: translateY(-2px);
    }

    .cards-security-note {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      max-width: 880px;
      margin: 34px auto 0;
      color: rgba(255, 255, 255, 0.52);
      font-size: 0.78rem;
      line-height: 1.6;
      text-align: center;
    }

    .cards-security-note i {
      color: #8ee9ff;
    }

    .partners-slider {
      position: relative;
      overflow: hidden;
      padding: 10px 0;
    }

    .partners-slider::before,
    .partners-slider::after {
      content: '';
      position: absolute;
      z-index: 2;
      top: 0;
      bottom: 0;
      width: min(150px, 16vw);
      pointer-events: none;
    }

    .partners-slider::before {
      left: 0;
      background: linear-gradient(90deg, #071a2f 0%, rgba(7, 26, 47, 0) 100%);
    }

    .partners-slider::after {
      right: 0;
      background: linear-gradient(270deg, #071a2f 0%, rgba(7, 26, 47, 0) 100%);
    }

    .partners-track {
      display: flex;
      width: max-content;
      gap: clamp(18px, 2.4vw, 34px);
      animation: partnersMarquee 34s linear infinite;
    }

    .partners-slider:hover .partners-track {
      animation-play-state: paused;
    }

    .partner-logo {
      display: flex;
      align-items: center;
      justify-content: center;
      flex: 0 0 clamp(168px, 15vw, 230px);
      height: 118px;
      padding: 24px 30px;
      border: 1px solid rgba(255, 255, 255, 0.15);
      border-radius: 8px;
      background: #ffffff;
      box-shadow: 0 24px 54px rgba(0, 0, 0, 0.2);
    }

    .partner-logo img {
      display: block;
      max-width: 100%;
      max-height: 58px;
      object-fit: contain;
    }

    @keyframes partnersMarquee {
      from { transform: translateX(0); }
      to { transform: translateX(calc(-50% - clamp(9px, 1.2vw, 17px))); }
    }

    .trust-layout {
      display: grid;
      grid-template-columns: minmax(320px, 0.65fr) minmax(0, 1fr);
      gap: clamp(28px, 4vw, 64px);
      align-items: stretch;
    }

    .trust-score {
      padding: 34px;
      border: 1px solid #c8f6e3;
      border-radius: 8px;
      background: linear-gradient(180deg, #ffffff 0%, #f0fff8 100%);
    }

    .trust-score strong {
      display: block;
      color: #00a878;
      font-size: 4.5rem;
      line-height: 1;
      font-weight: 800;
    }

    .stars {
      color: #00b67a;
      letter-spacing: 0;
    }

    .reviews-grid {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: clamp(16px, 2vw, 26px);
    }

    .review-card {
      padding: 24px;
    }

    .review-card p {
      color: #475467;
      line-height: 1.65;
    }

    .faq-layout {
      display: grid;
      grid-template-columns: minmax(300px, 0.58fr) minmax(0, 1fr);
      gap: clamp(40px, 5vw, 80px);
      align-items: start;
    }

    .faq-list {
      display: grid;
      gap: 14px;
    }

    .faq-item {
      overflow: hidden;
    }

    .faq-question {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 18px;
      width: 100%;
      padding: 22px 24px;
      border: 0;
      color: var(--ink);
      background: transparent;
      cursor: pointer;
      text-align: left;
      font: inherit;
      font-weight: 800;
    }

    .faq-question i {
      transition: transform 0.2s ease;
    }

    .faq-item.active .faq-question i {
      transform: rotate(180deg);
    }

    .faq-answer {
      display: none;
      padding: 0 24px 24px;
      color: var(--muted);
      line-height: 1.7;
    }

    .faq-item.active .faq-answer {
      display: block;
    }

    .cta-band {
      position: relative;
      overflow: hidden;
      padding: clamp(44px, 5vw, 82px);
      border-radius: 8px;
      color: #ffffff;
      background: #071a2f;
      isolation: isolate;
    }

    .cta-band::before {
      content: "";
      position: absolute;
      inset: 0;
      z-index: -2;
      background-image: url('{{ asset('images/happy-bank-customers.webp') }}');
      background-size: cover;
      background-position: center;
      opacity: 0;
      transform: scale(1.04);
      animation: ctaBackgroundFadeIn 1.25s ease-out forwards;
    }

    .cta-band::after {
      content: "";
      position: absolute;
      inset: 0;
      z-index: -1;
      background:
        linear-gradient(90deg, rgba(7, 26, 47, 0.96) 0%, rgba(7, 26, 47, 0.84) 48%, rgba(11, 92, 255, 0.58) 100%),
        radial-gradient(circle at 88% 18%, rgba(142, 233, 255, 0.24), transparent 34%);
    }

    @keyframes ctaBackgroundFadeIn {
      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    .cta-band h2 {
      max-width: 720px;
      margin: 0;
      font-size: clamp(2.1rem, 4vw, 4.4rem);
      line-height: 1.03;
      font-weight: 800;
    }

    .cta-band p {
      max-width: 620px;
      margin: 20px 0 30px;
      color: rgba(255, 255, 255, 0.78);
      line-height: 1.7;
      font-size: 1.08rem;
    }

    .bank-footer {
      padding: 64px 0 34px;
      color: rgba(255, 255, 255, 0.7);
      background: #06111f;
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

    .footer-bottom {
      margin-top: 42px;
      padding-top: 24px;
      border-top: 1px solid rgba(255, 255, 255, 0.12);
      font-size: 0.92rem;
    }

    @media (prefers-reduced-motion: reduce) {
      html {
        scroll-behavior: auto;
      }

      .hero-card-image {
        animation: none;
      }

      .hero-subtitle {
        transition: none;
      }

      .hero-title-progress {
        display: none;
      }

      .happy-client-slide {
        transition: none;
      }

      .happy-carousel-status {
        display: none;
      }

      .bank-card-product,
      .bank-card-3d {
        transition: none;
      }

      .bank-card-3d {
        transform: none;
      }
    }

    @media (max-width: 1080px) {
      .container-bank {
        width: min(100% - 32px, 1440px);
      }

      .nav-links,
      .nav-actions {
        display: none;
      }

      .mobile-toggle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
      }

      .hero-layout,
      .about-grid,
      .cards-heading,
      .trust-layout,
      .faq-layout {
        grid-template-columns: 1fr;
      }

      .bank-cards-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }

      .bank-card-product--vip {
        grid-column: 1 / -1;
        width: min(100%, 620px);
        justify-self: center;
      }

      .about-values {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 24px;
      }

      .card-stage {
        min-height: 390px;
      }

      .hero-card-image {
        right: 8%;
        width: min(600px, 94vw);
      }

      .services-grid,
      .reviews-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }

      .partners-strip,
      .footer-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }
    }

    @media (max-width: 700px) {
      .container-bank {
        width: min(100% - 18px, 1440px);
      }

      .bank-nav {
        top: 0;
        padding-top: 8px;
        padding-bottom: 8px;
      }

      .bank-nav-inner {
        padding: 10px 12px;
        border-radius: 20px;
      }

      .brand-mark span {
        display: none;
      }

      .hero {
        min-height: auto;
        padding: 118px 0 54px;
        background-position: 66% center;
      }

      .hero::before {
        background: linear-gradient(180deg, rgba(7, 26, 47, 0.96) 0%, rgba(7, 26, 47, 0.82) 62%, rgba(7, 26, 47, 0.7) 100%);
      }

      .hero h1 {
        font-size: clamp(2.3rem, 10vw, 3.55rem);
      }

      .hero-proof,
      .about-values,
      .bank-cards-grid,
      .services-grid,
      .reviews-grid,
      .partners-strip,
      .footer-grid {
        grid-template-columns: 1fr;
      }

      .bank-card-product--vip {
        grid-column: auto;
        width: 100%;
      }

      .cards-heading {
        gap: 18px;
      }

      .bank-card-scene {
        min-height: 245px;
      }

      .bank-card-3d {
        padding: 19px;
      }

      .hero-actions .btn,
      .cta-band .btn {
        width: 100%;
      }

      .card-stage {
        min-height: 300px;
      }

      .hero-card-image {
        top: 44px;
        right: -14%;
        width: 108vw;
        opacity: 0.92;
      }

      .happy-client-visual,
      .happy-client-frame,
      .happy-client-frame img {
        min-height: 390px;
      }

      .happy-client-badge {
        left: 12px;
        right: 12px;
        bottom: 16px;
        max-width: none;
      }

      .section {
        padding: 66px 0;
      }

      .service-card {
        min-height: auto;
      }

      .cta-band {
        padding: 34px 24px;
      }
    }
  </style>
</head>

<body>
  @include('partials.site-launch-loader')
@php
  $locale = app()->getLocale();
  $heroSliderTitles = trans('home.hero_slider_titles');
  $heroSliderTitles = is_array($heroSliderTitles) && count($heroSliderTitles) > 0
    ? array_values($heroSliderTitles)
    : [__('home.hero_title_2')];
  $happyCustomerImages = array_merge(
    ['images/happy-bank-customers.webp'],
    array_map(fn ($index) => sprintf('images/customer-carousel/happy-customer-%02d.webp', $index), range(1, 11))
  );
  $serviceRoutes = [
    ['icon' => 'fa-building-columns', 'route' => 'services.comptes-professionnels', 'title' => __('home.services_1_title'), 'text' => __('home.services_1_text'), 'points' => [__('home.services_1_point_1'), __('home.services_1_point_2'), __('home.services_1_point_3')]],
    ['icon' => 'fa-earth-europe', 'route' => 'services.virements-internationaux', 'title' => __('home.services_2_title'), 'text' => __('home.services_2_text'), 'points' => [__('home.services_2_point_1'), __('home.services_2_point_2'), __('home.services_2_point_3')]],
    ['icon' => 'fa-chart-line', 'route' => 'services.gestion-tresorerie', 'title' => __('home.services_3_title'), 'text' => __('home.services_3_text'), 'points' => [__('home.services_3_point_1'), __('home.services_3_point_2'), __('home.services_3_point_3')]],
    ['icon' => 'fa-credit-card', 'route' => 'services.cartes-paiement', 'title' => __('home.services_4_title'), 'text' => __('home.services_4_text'), 'points' => [__('home.services_4_point_1'), __('home.services_4_point_2'), __('home.services_4_point_3')]],
  ];
  $bankCards = [
    ['variant' => 'standard', 'name' => __('home.cards_standard_name'), 'label' => __('home.cards_standard_label'), 'description' => __('home.cards_standard_description'), 'number' => '4892  ••••  ••••  2418', 'features' => [__('home.cards_standard_feature_1'), __('home.cards_standard_feature_2'), __('home.cards_standard_feature_3')]],
    ['variant' => 'premium', 'name' => __('home.cards_premium_name'), 'label' => __('home.cards_premium_label'), 'description' => __('home.cards_premium_description'), 'number' => '5417  ••••  ••••  8062', 'badge' => __('home.cards_popular'), 'features' => [__('home.cards_premium_feature_1'), __('home.cards_premium_feature_2'), __('home.cards_premium_feature_3')]],
    ['variant' => 'vip', 'name' => __('home.cards_vip_name'), 'label' => __('home.cards_vip_label'), 'description' => __('home.cards_vip_description'), 'number' => '7841  ••••  ••••  0097', 'badge' => __('home.cards_signature'), 'features' => [__('home.cards_vip_feature_1'), __('home.cards_vip_feature_2'), __('home.cards_vip_feature_3')]],
  ];
  $partnerBanks = [
    ['name' => 'BNP Paribas', 'image' => asset('images/partners/bnp-paribas.svg')],
    ['name' => 'Deutsche Bank', 'image' => asset('images/partners/deutsche-bank.svg')],
    ['name' => 'HSBC', 'image' => asset('images/partners/hsbc.svg')],
    ['name' => 'Barclays', 'image' => asset('images/partners/barclays.svg')],
    ['name' => 'Santander', 'image' => asset('images/partners/santander.svg')],
  ];
  $faqItems = [1, 2, 3, 4, 5, 6];
@endphp

<div class="site-shell">
  <header class="bank-nav">
    <div class="container-bank">
      <div class="bank-nav-inner">
        <a class="brand-mark" href="{{ localized_route('home', ['locale' => $locale]) }}">
          <img src="{{ asset('images/zuider-logo-white.png') }}" alt="Zuider Bank S.A">
          <span>Zuider Bank S.A</span>
        </a>

        <nav class="nav-links" aria-label="Navigation principale">
          <a href="{{ localized_route('home', ['locale' => $locale]) }}">{{ __('home.nav_home') }}</a>
          <a href="#about">{{ __('home.nav_about') }}</a>
          <a href="#services">{{ __('home.nav_services') }}</a>
          <a href="#cards">{{ __('home.nav_cards') }}</a>
          <a href="#partners">{{ __('home.partners_title') }}</a>
          <a href="#faq">{{ __('home.nav_faq') }}</a>
        </nav>

        <div class="nav-actions">
          @include('components.language-selector')
          <a class="btn btn-outline" href="{{ localized_route('login', ['locale' => $locale]) }}">{{ __('home.nav_login') }}</a>
          <a class="btn btn-primary" href="{{ localized_route('register', ['locale' => $locale]) }}">{{ __('home.nav_register') }}</a>
        </div>

        <button class="mobile-toggle" type="button" id="mobile-menu-button" aria-label="Ouvrir le menu" aria-controls="mobile-menu" aria-expanded="false">
          <i class="fas fa-bars"></i>
        </button>
      </div>

      <div class="mobile-menu-backdrop" id="mobile-menu-backdrop"></div>
      <div class="mobile-menu" id="mobile-menu" aria-hidden="true">
        <div class="mobile-menu-head">
          <span class="mobile-menu-brand">
            <img src="{{ asset('images/zuider-logo-white.png') }}" alt="Zuider Bank S.A">
            <span>Zuider Bank S.A</span>
          </span>
          <button class="mobile-close" type="button" id="mobile-menu-close" aria-label="Fermer le menu">
            <i class="fas fa-times"></i>
          </button>
        </div>

        <div class="mobile-menu-links">
          <a href="{{ localized_route('home', ['locale' => $locale]) }}">{{ __('home.nav_home') }} <i class="fas fa-arrow-left"></i></a>
          <a href="#about">{{ __('home.nav_about') }} <i class="fas fa-arrow-left"></i></a>
          <a href="#services">{{ __('home.nav_services') }} <i class="fas fa-arrow-left"></i></a>
          <a href="#cards">{{ __('home.nav_cards') }} <i class="fas fa-arrow-left"></i></a>
          <a href="#partners">{{ __('home.partners_title') }} <i class="fas fa-arrow-left"></i></a>
          <a href="#trustpilot">{{ __('home.trustpilot_badge') }} <i class="fas fa-arrow-left"></i></a>
          <a href="#faq">{{ __('home.nav_faq') }} <i class="fas fa-arrow-left"></i></a>
        </div>

        <div class="mobile-menu-foot">
          @include('components.language-selector')
          <a class="mobile-auth-link" href="{{ localized_route('login', ['locale' => $locale]) }}">{{ __('home.nav_login') }}</a>
          <a class="mobile-auth-link" href="{{ localized_route('register', ['locale' => $locale]) }}">{{ __('home.nav_register') }}</a>
        </div>
      </div>
    </div>
  </header>

  <main>
    <section class="hero" id="home">
      <div class="container-bank hero-layout">
        <div>
          <span class="eyebrow"><i class="fas fa-shield-halved"></i>{{ __('home.hero_badge') }}</span>
          <h1>Zuider Bank S.A</h1>
          <div class="hero-title-slider" aria-live="polite" aria-atomic="true">
            <p class="hero-subtitle" id="hero-rotating-title">{{ $heroSliderTitles[0] }}</p>
            <div class="hero-title-slider-meta" aria-hidden="true">
              <span class="hero-title-counter" id="hero-title-counter">01 / {{ str_pad((string) count($heroSliderTitles), 2, '0', STR_PAD_LEFT) }}</span>
              <span class="hero-title-progress"><span class="is-running" id="hero-title-progress"></span></span>
            </div>
          </div>
          <p class="hero-copy">{{ __('home.hero_description') }}</p>

          <div class="hero-actions">
            <a class="btn btn-accent" href="{{ localized_route('register', ['locale' => $locale]) }}">
              {{ __('home.hero_cta_register') }} <i class="fas fa-arrow-right"></i>
            </a>
            <a class="btn btn-outline" href="{{ localized_route('login', ['locale' => $locale]) }}">
              {{ __('home.hero_cta_login') }}
            </a>
          </div>

          <div class="hero-proof" aria-label="Indicateurs de confiance">
            <div class="proof-item">
              <strong class="hero-counter" data-counter-target="10000" data-counter-decimals="0" data-counter-suffix="+" aria-label="{{ __('home.about_stat_4_value') }}">{{ __('home.about_stat_4_value') }}</strong>
              <span>{{ __('home.about_stat_4_label') }}</span>
            </div>
            <div class="proof-item">
              <strong class="hero-counter" data-counter-target="27" data-counter-decimals="0" aria-label="{{ __('home.about_stat_2_value') }}">{{ __('home.about_stat_2_value') }}</strong>
              <span>{{ __('home.about_stat_2_label') }}</span>
            </div>
            <div class="proof-item">
              <strong class="hero-counter" data-counter-target="4.7" data-counter-decimals="1" data-counter-suffix="/5" aria-label="{{ __('home.trustpilot_score') }}/5">{{ __('home.trustpilot_score') }}/5</strong>
              <span>{{ __('home.trustpilot_score_label') }} Trustpilot</span>
            </div>
          </div>
        </div>

        <div class="card-stage" aria-hidden="true">
          <img class="hero-card-image" src="{{ asset('images/zuider-card-3d-hero.webp') }}" alt="" width="1000" height="667" fetchpriority="high" decoding="async">
        </div>
      </div>
    </section>

    <section class="section" id="about">
      <div class="container-bank about-grid">
        <div class="about-copy">
          <div class="section-heading">
            <span class="section-kicker"><i class="fas fa-landmark"></i>{{ __('home.about_badge') }}</span>
            <h2>{{ __('home.about_title_1') }} {{ __('home.about_title_2') }}</h2>
            <p>{{ __('home.about_description') }}</p>
          </div>
          <p class="lead-text">{{ __('home.about_paragraph_1') }}</p>
          <p class="lead-text">{{ __('home.about_paragraph_2') }}</p>
        </div>

        <div class="happy-client-visual">
          <div class="happy-client-frame" id="happy-customer-carousel" role="img" aria-label="{{ __('home.about_stat_4_value') }} {{ __('home.about_stat_4_label') }}">
            @foreach ($happyCustomerImages as $customerImage)
              <img
                class="happy-client-slide {{ $loop->first ? 'is-active' : '' }}"
                src="{{ asset($customerImage) }}"
                alt=""
                loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                decoding="async"
                aria-hidden="{{ $loop->first ? 'false' : 'true' }}"
              >
            @endforeach
            <div class="happy-carousel-status" aria-hidden="true">
              <span class="happy-carousel-progress"><span class="is-running" id="happy-carousel-progress"></span></span>
            </div>
          </div>
          <div class="happy-client-badge">
            <i class="fas fa-heart"></i>
            <div>
              <strong>{{ __('home.about_stat_4_value') }} {{ __('home.about_stat_4_label') }}</strong>
              <span>{{ __('home.trustpilot_score_label') }} Trustpilot</span>
            </div>
          </div>
        </div>

        <div class="about-values">
          <div class="value-box">
            <i class="fas fa-bullseye"></i>
            <h3>{{ __('home.about_mission_title') }}</h3>
            <p>{{ __('home.about_mission_text') }}</p>
          </div>
          <div class="value-box">
            <i class="fas fa-compass"></i>
            <h3>{{ __('home.about_vision_title') }}</h3>
            <p>{{ __('home.about_vision_text') }}</p>
          </div>
          <div class="value-box">
            <i class="fas fa-chart-simple"></i>
            <h3>{{ __('home.about_objective_title') }}</h3>
            <p>{{ __('home.about_objective_text') }}</p>
          </div>
        </div>
      </div>
    </section>

    <section class="section soft" id="services">
      <div class="container-bank">
        <div class="section-heading">
          <span class="section-kicker"><i class="fas fa-layer-group"></i>{{ __('home.services_badge') }}</span>
          <h2>{{ __('home.services_title') }}</h2>
          <p>{{ __('home.services_intro') }}</p>
        </div>

        <div class="services-grid">
          @foreach ($serviceRoutes as $service)
            <article class="service-card">
              <span class="service-icon"><i class="fas {{ $service['icon'] }}"></i></span>
              <h3>{{ $service['title'] }}</h3>
              <p>{{ $service['text'] }}</p>
              <ul>
                @foreach ($service['points'] as $point)
                  <li><i class="fas fa-check-circle"></i><span>{{ $point }}</span></li>
                @endforeach
              </ul>
              <a href="{{ localized_route($service['route'], ['locale' => $locale]) }}">
                {{ __('home.services_cta') }} <i class="fas fa-arrow-right"></i>
              </a>
            </article>
          @endforeach
        </div>
      </div>
    </section>

    <section class="section cards-showcase" id="cards">
      <div class="container-bank">
        <div class="cards-heading">
          <div>
            <span class="section-kicker" style="color:#8ee9ff"><i class="fas fa-credit-card"></i>{{ __('home.cards_badge') }}</span>
            <h2>{{ __('home.cards_title') }}</h2>
          </div>
          <p>{{ __('home.cards_description') }}</p>
        </div>

        <div class="bank-cards-grid">
          @foreach ($bankCards as $card)
            <article class="bank-card-product bank-card-product--{{ $card['variant'] }}" data-bank-card>
              @isset($card['badge'])
                <span class="card-popular-badge"><i class="fas {{ $card['variant'] === 'vip' ? 'fa-crown' : 'fa-star' }}"></i>{{ $card['badge'] }}</span>
              @endisset

              <div class="bank-card-scene" aria-label="{{ $card['name'] }}">
                <div class="bank-card-3d">
                  <div class="bank-card-top">
                    <span class="bank-card-brand">Zuider Bank</span>
                    <span class="bank-card-tier">{{ $card['label'] }}</span>
                  </div>
                  <div class="bank-card-chip-row">
                    <span class="bank-card-chip" aria-hidden="true"></span>
                    <i class="fas fa-wifi bank-card-contactless" aria-hidden="true"></i>
                  </div>
                  <div class="bank-card-number">{{ $card['number'] }}</div>
                  <div class="bank-card-bottom">
                    <span>{{ __('home.cards_holder_label') }}<strong>J. DUPONT</strong></span>
                    <span>{{ __('home.cards_valid_thru') }}<strong>09/30</strong></span>
                  </div>
                </div>
              </div>

              <div class="card-product-copy">
                <span class="card-product-label">{{ $card['label'] }}</span>
                <h3>{{ $card['name'] }}</h3>
                <p>{{ $card['description'] }}</p>
                <ul class="card-features">
                  @foreach ($card['features'] as $feature)
                    <li><i class="fas fa-check-circle"></i><span>{{ $feature }}</span></li>
                  @endforeach
                </ul>
                <a class="card-select-link" href="{{ localized_route('register', ['locale' => $locale]) }}">
                  {{ __('home.cards_choose') }} <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </article>
          @endforeach
        </div>

        <p class="cards-security-note"><i class="fas fa-shield-halved"></i>{{ __('home.cards_security_note') }}</p>
      </div>
    </section>

    <section class="section dark" id="partners">
      <div class="container-bank">
        <div class="section-heading">
          <span class="section-kicker" style="color:#8ee9ff"><i class="fas fa-network-wired"></i>{{ __('home.partners_title') }}</span>
          <h2>{{ __('home.certifications_title') }}</h2>
          <p>{{ __('home.partners_description') }}</p>
        </div>

        <div class="partners-slider" aria-label="{{ __('home.partners_title') }}">
          <div class="partners-track">
            @for ($loopIndex = 0; $loopIndex < 2; $loopIndex++)
              @foreach ($partnerBanks as $partner)
                <div class="partner-logo">
                  <img src="{{ $partner['image'] }}" alt="{{ $partner['name'] }}" loading="lazy">
                </div>
              @endforeach
            @endfor
          </div>
        </div>
      </div>
    </section>

    <section class="section" id="trustpilot">
      <div class="container-bank">
        <div class="trust-layout">
          <div class="trust-score">
            <span class="section-kicker"><i class="fas fa-star"></i>{{ __('home.trustpilot_badge') }}</span>
            <strong>{{ __('home.trustpilot_score') }}</strong>
            <div class="stars" aria-label="{{ __('home.trustpilot_score_label') }}">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star-half-stroke"></i>
            </div>
            <h2 style="font-size:2rem;margin-top:22px">{{ __('home.trustpilot_score_label') }}</h2>
            <p style="color:#475467;line-height:1.7">{{ __('home.trustpilot_description') }}</p>
            <a style="color:#008f68;font-weight:800" href="https://www.trustpilot.com" target="_blank" rel="noopener noreferrer">
              {{ __('home.trustpilot_cta') }} <i class="fas fa-arrow-up-right-from-square"></i>
            </a>
          </div>

          <div>
            <div class="section-heading" style="margin-bottom:24px">
              <h2>{{ __('home.trustpilot_title') }}</h2>
              <p>{{ __('home.trustpilot_reviews_count') }}</p>
            </div>

            <div class="reviews-grid">
              @for ($i = 1; $i <= 3; $i++)
                <article class="review-card">
                  <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                  </div>
                  <p>&laquo; {{ __('home.trustpilot_review_' . $i . '_text') }} &raquo;</p>
                  <strong>{{ __('home.trustpilot_review_' . $i . '_name') }}</strong>
                  <small style="display:block;color:#98a2b3;margin-top:6px">{{ __('home.trustpilot_review_' . $i . '_date') }}</small>
                </article>
              @endfor
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section soft" id="faq">
      <div class="container-bank faq-layout">
        <div class="section-heading">
          <span class="section-kicker"><i class="fas fa-circle-question"></i>{{ __('home.nav_faq') }}</span>
          <h2>{{ __('home.faq_title') }}</h2>
          <p>{{ __('home.faq_description') }}</p>
        </div>

        <div class="faq-list" id="faq-list">
          @foreach ($faqItems as $faqIndex)
            <article class="faq-item {{ $loop->first ? 'active' : '' }}">
              <button class="faq-question" type="button">
                <span>{{ __('home.faq_' . $faqIndex . '_question') }}</span>
                <i class="fas fa-chevron-down"></i>
              </button>
              <div class="faq-answer">
                {{ __('home.faq_' . $faqIndex . '_answer') }}
              </div>
            </article>
          @endforeach
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container-bank">
        <div class="cta-band">
          <h2>{{ __('home.cta_title') }}</h2>
          <p>{{ __('home.cta_description') }}</p>
          <a class="btn btn-primary" href="{{ localized_route('register', ['locale' => $locale]) }}">
            {{ __('home.cta_button') }} <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
    </section>
  </main>

  <footer class="bank-footer">
    <div class="container-bank">
      <div class="footer-grid">
        <div>
          <a class="brand-mark" href="{{ localized_route('home', ['locale' => $locale]) }}">
            <img src="{{ asset('images/zuider-logo-white.png') }}" alt="Zuider Bank S.A">
            <span>Zuider Bank S.A</span>
          </a>
          <p style="max-width:380px;line-height:1.7;margin-top:18px">{{ __('home.footer_description') }}</p>
        </div>

        <div>
          <h3>{{ __('home.footer_services') }}</h3>
          <ul>
            @foreach ($serviceRoutes as $service)
              <li><a href="{{ localized_route($service['route'], ['locale' => $locale]) }}">{{ $service['title'] }}</a></li>
            @endforeach
          </ul>
        </div>

        <div>
          <h3>{{ __('home.footer_about') }}</h3>
          <ul>
            <li><a href="{{ localized_route('about.notre-histoire', ['locale' => $locale]) }}">{{ __('home.footer_our_story') }}</a></li>
            <li><a href="{{ localized_route('about.carrieres', ['locale' => $locale]) }}">{{ __('home.footer_careers') }}</a></li>
            <li><a href="{{ localized_route('about.presse', ['locale' => $locale]) }}">{{ __('home.footer_press') }}</a></li>
            <li><a href="{{ localized_route('about.blog', ['locale' => $locale]) }}">{{ __('home.footer_blog') }}</a></li>
          </ul>
        </div>

        <div>
          <h3>{{ __('home.footer_support') }}</h3>
          <ul>
            <li><a href="{{ localized_route('support.centre-aide', ['locale' => $locale]) }}">{{ __('home.footer_help_center') }}</a></li>
            <li><a href="{{ localized_route('support.nous-contacter', ['locale' => $locale]) }}">{{ __('home.footer_contact_us') }}</a></li>
            <li><a href="{{ localized_route('support.securite', ['locale' => $locale]) }}">{{ __('home.footer_security') }}</a></li>
            <li><a href="{{ localized_route('support.mentions-legales', ['locale' => $locale]) }}">{{ __('home.footer_legal') }}</a></li>
          </ul>
        </div>
      </div>

      <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} Zuider Bank S.A. {{ __('home.footer_copyright') }}</p>
        <p>{{ __('home.footer_disclaimer') }}</p>
      </div>
    </div>
  </footer>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');
    const close = document.getElementById('mobile-menu-close');
    const backdrop = document.getElementById('mobile-menu-backdrop');

    if (toggle && menu) {
      const setMobileMenu = function (isOpen) {
        menu.classList.toggle('open', isOpen);
        backdrop?.classList.toggle('open', isOpen);
        document.body.classList.toggle('mobile-menu-active', isOpen);
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
    }

    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const finePointer = window.matchMedia('(pointer: fine)').matches;
    const heroTitles = @json($heroSliderTitles);
    const rotatingTitle = document.getElementById('hero-rotating-title');
    const titleCounter = document.getElementById('hero-title-counter');
    const titleProgress = document.getElementById('hero-title-progress');

    if (!reduceMotion && rotatingTitle && heroTitles.length > 1) {
      let titleIndex = 0;
      let rotationTimer = null;

      const restartTitleProgress = function () {
        if (!titleProgress) return;
        titleProgress.classList.remove('is-running');
        void titleProgress.offsetWidth;
        titleProgress.classList.add('is-running');
      };

      const scheduleTitleRotation = function () {
        window.clearTimeout(rotationTimer);
        rotationTimer = window.setTimeout(function () {
          rotatingTitle.classList.add('is-fading');

          window.setTimeout(function () {
            titleIndex = (titleIndex + 1) % heroTitles.length;
            rotatingTitle.textContent = heroTitles[titleIndex];
            titleCounter.textContent = String(titleIndex + 1).padStart(2, '0') + ' / ' + String(heroTitles.length).padStart(2, '0');
            rotatingTitle.classList.remove('is-fading');
            restartTitleProgress();
            scheduleTitleRotation();
          }, 480);
        }, 5120);
      };

      scheduleTitleRotation();

      document.addEventListener('visibilitychange', function () {
        if (document.hidden) {
          window.clearTimeout(rotationTimer);
          return;
        }

        restartTitleProgress();
        scheduleTitleRotation();
      });
    }

    const heroCounters = document.querySelectorAll('.hero-counter[data-counter-target]');

    if (!reduceMotion && heroCounters.length > 0) {
      const numberLocale = document.documentElement.lang || 'fr';

      const animateCounter = function (counter) {
        const target = Number.parseFloat(counter.dataset.counterTarget || '0');
        const decimals = Number.parseInt(counter.dataset.counterDecimals || '0', 10);
        const suffix = counter.dataset.counterSuffix || '';
        const duration = target >= 1000 ? 2200 : 1700;
        const formatter = new Intl.NumberFormat(numberLocale, {
          minimumFractionDigits: decimals,
          maximumFractionDigits: decimals
        });
        const startedAt = performance.now();

        const renderFrame = function (now) {
          const progress = Math.min((now - startedAt) / duration, 1);
          const easedProgress = 1 - Math.pow(1 - progress, 3);
          const currentValue = target * easedProgress;
          counter.textContent = formatter.format(decimals > 0 ? currentValue : Math.floor(currentValue)) + suffix;

          if (progress < 1) {
            requestAnimationFrame(renderFrame);
            return;
          }

          counter.textContent = formatter.format(target) + suffix;
        };

        counter.textContent = formatter.format(0) + suffix;
        requestAnimationFrame(renderFrame);
      };

      if ('IntersectionObserver' in window) {
        const counterObserver = new IntersectionObserver(function (entries, observer) {
          entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;
            animateCounter(entry.target);
            observer.unobserve(entry.target);
          });
        }, { threshold: 0.35 });

        heroCounters.forEach(function (counter) {
          counterObserver.observe(counter);
        });
      } else {
        heroCounters.forEach(animateCounter);
      }
    }

    const customerCarousel = document.getElementById('happy-customer-carousel');

    if (!reduceMotion && customerCarousel) {
      const customerSlides = Array.from(customerCarousel.querySelectorAll('.happy-client-slide'));
      const customerProgress = document.getElementById('happy-carousel-progress');
      let customerIndex = 0;
      let customerTimer = null;

      const preloadCustomerSlide = function (index) {
        const slide = customerSlides[index];
        if (!slide || slide.complete) return;
        const preload = new Image();
        preload.src = slide.currentSrc || slide.src;
      };

      const restartCustomerProgress = function () {
        if (!customerProgress) return;
        customerProgress.classList.remove('is-running');
        void customerProgress.offsetWidth;
        customerProgress.classList.add('is-running');
      };

      const scheduleCustomerSlide = function () {
        window.clearTimeout(customerTimer);
        customerTimer = window.setTimeout(function () {
          const currentSlide = customerSlides[customerIndex];
          customerIndex = (customerIndex + 1) % customerSlides.length;
          const nextSlide = customerSlides[customerIndex];

          currentSlide.classList.remove('is-active');
          currentSlide.setAttribute('aria-hidden', 'true');
          nextSlide.classList.add('is-active');
          nextSlide.setAttribute('aria-hidden', 'false');

          preloadCustomerSlide((customerIndex + 1) % customerSlides.length);
          restartCustomerProgress();
          scheduleCustomerSlide();
        }, 6400);
      };

      if (customerSlides.length > 1) {
        preloadCustomerSlide(1);
        scheduleCustomerSlide();

        document.addEventListener('visibilitychange', function () {
          if (document.hidden) {
            window.clearTimeout(customerTimer);
            return;
          }

          restartCustomerProgress();
          scheduleCustomerSlide();
        });
      }
    }

    if (!reduceMotion && finePointer) {
      document.querySelectorAll('[data-bank-card] .bank-card-scene').forEach(function (scene) {
        let animationFrame = null;

        scene.addEventListener('pointermove', function (event) {
          const bounds = scene.getBoundingClientRect();
          const pointerX = (event.clientX - bounds.left) / bounds.width;
          const pointerY = (event.clientY - bounds.top) / bounds.height;

          if (animationFrame) cancelAnimationFrame(animationFrame);
          animationFrame = requestAnimationFrame(function () {
            scene.style.setProperty('--rx', ((0.5 - pointerY) * 14).toFixed(2) + 'deg');
            scene.style.setProperty('--ry', ((pointerX - 0.5) * 18).toFixed(2) + 'deg');
          });
        });

        scene.addEventListener('pointerleave', function () {
          if (animationFrame) cancelAnimationFrame(animationFrame);
          scene.style.setProperty('--rx', '5deg');
          scene.style.setProperty('--ry', '-8deg');
        });
      });
    }

    document.querySelectorAll('#faq-list .faq-item').forEach(function (item) {
      const button = item.querySelector('.faq-question');
      if (!button) return;

      button.addEventListener('click', function () {
        document.querySelectorAll('#faq-list .faq-item').forEach(function (otherItem) {
          if (otherItem !== item) {
            otherItem.classList.remove('active');
          }
        });
        item.classList.toggle('active');
      });
    });
  });
</script>
</body>
</html>
