@extends('layouts.premium-dashboard')

@section('title', 'Administration - NEXALUNE BANK')
@section('dashboard_theme', 'admin')
@section('dashboard_page_title', __('admin_pages.dashboard_title'))
@section('dashboard_page_subtitle', __('admin_pages.dashboard_subtitle'))
@section('dashboard_section_label', __('admin_pages.admin_pilotage'))
@section('dashboard_search_placeholder', __('admin_pages.search_admin_placeholder'))
@section('dashboard_brand_title', 'NEXALUNE BANK Admin')
@section('dashboard_brand_subtitle', __('admin_pages.control_center'))
@section('sidebar_primary_title', __('admin_dashboard.sidebar_navigation'))

@section('sidebar_primary')
    <a href="{{ localized_route('admin.dashboard') }}" class="premium-nav-item is-active flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-900">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-blue-700 shadow-sm ring-1 ring-slate-200">
            <i class="fas fa-chart-line"></i>
        </span>
        <span>{{ __('admin_pages.dashboard') }}</span>
    </a>
    <a href="{{ localized_route('admin.users') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-users"></i>
        </span>
        <span>{{ __('admin_pages.users') }}</span>
    </a>
    <a href="{{ localized_route('admin.transactions') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-exchange-alt"></i>
        </span>
        <span>{{ __('admin_pages.transfers') }}</span>
    </a>
    <a href="{{ localized_route('admin.deposit') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-plus-circle"></i>
        </span>
        <span>{{ __('admin_pages.deposit') }}</span>
    </a>
@endsection

@section('sidebar_secondary_title', __('admin_dashboard.sidebar_operations'))
@section('sidebar_secondary')
    <a href="{{ localized_route('admin.settings') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-gear"></i>
        </span>
        <span>{{ __('admin_pages.settings') }}</span>
    </a>
    <a href="{{ localized_route('admin.export.pdf') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-file-pdf"></i>
        </span>
        <span>{{ __('admin_pages.export_pdf') }}</span>
    </a>
    <a href="{{ localized_route('admin.export.excel') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-file-excel"></i>
        </span>
        <span>{{ __('admin_pages.export_excel') }}</span>
    </a>
    <a href="{{ localized_route('home') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-arrow-left"></i>
        </span>
        <span>{{ __('admin_dashboard.nav_back') }}</span>
    </a>
    <form method="POST" action="{{ localized_route('logout') }}">
        @csrf
        <button type="submit" class="premium-nav-item flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-semibold text-slate-600">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
                <i class="fas fa-right-from-bracket"></i>
            </span>
            <span>{{ __('admin_dashboard.nav_logout') }}</span>
        </button>
    </form>
@endsection

@section('sidebar_footer')
    <div class="premium-gradient-card premium-grid-glow relative overflow-hidden rounded-[26px] p-5">
        <div class="relative z-10">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-white/65">{{ __('admin_pages.governance') }}</p>
            <h3 class="mt-3 premium-brand-title text-xl font-semibold">{{ __('admin_dashboard.active_coverage') }}</h3>
            <p class="mt-2 text-sm leading-6 text-white/78">
                {{ __('admin_dashboard.active_coverage_text', ['rate' => $activeUsersRate]) }}
            </p>
            <div class="mt-5 h-2 rounded-full bg-white/10">
                <div class="h-2 rounded-full bg-gradient-to-r from-cyan-300 to-emerald-300" style="width: {{ $activeUsersRate }}%"></div>
            </div>
            <a href="{{ localized_route('admin.users') }}" class="mt-4 inline-flex items-center gap-2 text-xs font-semibold text-white/80 transition hover:text-white">
                {{ __('admin_pages.manage_users') }}
                <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>
    </div>
@endsection

@section('topbar_actions')
    <div class="hidden items-center gap-2 rounded-full bg-white/85 px-3 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500 ring-1 ring-slate-200 md:inline-flex">
        <span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span>
        {{ __('admin_dashboard.active_supervision') }}
    </div>
@endsection

@section('dashboard_header_actions')
    <a href="{{ localized_route('admin.deposit') }}" class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-indigo-700 to-cyan-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-950/20 transition hover:-translate-y-0.5 hover:shadow-xl">
        <i class="fas fa-plus text-xs"></i>
        {{ __('admin_pages.new_deposit') }}
    </a>
    <a href="{{ localized_route('admin.export.excel') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
        <i class="fas fa-file-export text-xs"></i>
        {{ __('admin_pages.export') }}
    </a>
@endsection

@push('premium_dashboard_head')
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
    <style>
        .admin-command-center {
            display: grid;
            gap: 1.5rem;
            align-items: stretch;
        }

        .admin-command-card,
        .admin-priority-card,
        .admin-metric-suite {
            min-width: 0;
        }

        .admin-command-card {
            position: relative;
            isolation: isolate;
            overflow: hidden;
            padding: clamp(1.35rem, 2.4vw, 2.25rem);
            border: 1px solid rgba(151, 205, 255, 0.2);
            border-radius: 2rem;
            color: #ffffff;
            background:
                radial-gradient(circle at 88% 10%, rgba(73, 162, 255, 0.24), transparent 29%),
                radial-gradient(circle at 12% 100%, rgba(28, 200, 184, 0.13), transparent 32%),
                linear-gradient(135deg, #041225 0%, #082747 54%, #0d355c 100%);
            box-shadow: 0 30px 70px rgba(4, 22, 42, 0.26), inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .admin-command-card::before {
            content: "";
            position: absolute;
            z-index: -2;
            inset: 0;
            opacity: 0.32;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.04) 1px, transparent 1px);
            background-size: 30px 30px;
            mask-image: linear-gradient(120deg, #000 0%, transparent 78%);
        }

        .admin-command-card::after {
            content: "";
            position: absolute;
            z-index: -1;
            top: -10rem;
            right: -8rem;
            width: 28rem;
            height: 28rem;
            border: 1px solid rgba(142, 233, 255, 0.12);
            border-radius: 50%;
            box-shadow: 0 0 0 4rem rgba(91, 155, 255, 0.025), 0 0 0 8rem rgba(91, 155, 255, 0.02);
        }

        .admin-command-header,
        .admin-priority-header,
        .admin-metric-card__top,
        .admin-signal-card__top,
        .admin-flow-card__top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
        }

        .admin-command-status,
        .admin-command-seal,
        .admin-priority-count {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            border-radius: 999px;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        .admin-command-status {
            color: #bbf7d0;
        }

        .admin-command-status__dot {
            width: 0.55rem;
            height: 0.55rem;
            border-radius: 50%;
            background: #34d399;
            box-shadow: 0 0 0 0.3rem rgba(52, 211, 153, 0.12), 0 0 1.1rem rgba(52, 211, 153, 0.7);
        }

        .admin-command-seal {
            padding: 0.55rem 0.8rem;
            border: 1px solid rgba(255, 255, 255, 0.11);
            color: rgba(255, 255, 255, 0.66);
            background: rgba(255, 255, 255, 0.055);
            letter-spacing: 0.1em;
        }

        .admin-command-hero {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: clamp(1.5rem, 3vw, 3.5rem);
            align-items: center;
            margin-top: clamp(1.75rem, 3vw, 3rem);
        }

        .admin-command-title {
            max-width: 42rem;
            margin: 0;
            font-family: 'Sora', sans-serif;
            font-size: clamp(2rem, 4vw, 4rem);
            font-weight: 650;
            line-height: 0.98;
            letter-spacing: -0.06em;
            text-wrap: balance;
        }

        .admin-command-intro {
            max-width: 42rem;
            margin-top: 1rem;
            color: rgba(226, 238, 250, 0.72);
            font-size: 0.95rem;
            line-height: 1.75;
        }

        .admin-coverage {
            max-width: 32rem;
            margin-top: 1.6rem;
        }

        .admin-coverage__meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            color: rgba(226, 238, 250, 0.65);
            font-size: 0.75rem;
            font-weight: 700;
        }

        .admin-coverage__meta strong {
            color: #ffffff;
            font-family: 'Sora', sans-serif;
            font-size: 0.85rem;
        }

        .admin-coverage__track {
            height: 0.45rem;
            margin-top: 0.65rem;
            overflow: hidden;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.1);
        }

        .admin-coverage__bar {
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, #65d7ff, #5ee5bd);
            box-shadow: 0 0 1.25rem rgba(94, 229, 189, 0.38);
        }

        .admin-command-score {
            display: grid;
            gap: 0.85rem;
            justify-items: center;
            width: 10.5rem;
        }

        .admin-command-ring {
            --score: 0;
            position: relative;
            display: grid;
            width: 9.4rem;
            aspect-ratio: 1;
            place-items: center;
            border-radius: 50%;
            background: conic-gradient(#62e6bd calc(var(--score) * 1%), rgba(255, 255, 255, 0.1) 0);
            box-shadow: 0 20px 44px rgba(0, 8, 20, 0.28);
        }

        .admin-command-ring::before {
            content: "";
            position: absolute;
            inset: 0.65rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: inherit;
            background: linear-gradient(145deg, #071a30, #0b2b4c);
        }

        .admin-command-ring__value {
            position: relative;
            display: grid;
            gap: 0.25rem;
            justify-items: center;
            text-align: center;
        }

        .admin-command-ring__value strong {
            font-family: 'Sora', sans-serif;
            font-size: 2rem;
            line-height: 1;
            letter-spacing: -0.05em;
        }

        .admin-command-ring__value span,
        .admin-command-score > p {
            color: rgba(226, 238, 250, 0.62);
            font-size: 0.65rem;
            font-weight: 800;
            line-height: 1.35;
            letter-spacing: 0.1em;
            text-align: center;
            text-transform: uppercase;
        }

        .admin-signal-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.8rem;
            margin-top: 2rem;
        }

        .admin-signal-card,
        .admin-flow-card {
            min-width: 0;
            border: 1px solid rgba(255, 255, 255, 0.09);
            background: rgba(255, 255, 255, 0.065);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .admin-signal-card {
            display: grid;
            grid-template-columns: auto minmax(0, 1fr) auto;
            gap: 0.85rem;
            align-items: center;
            padding: 1rem;
            border-radius: 1.25rem;
        }

        .admin-signal-card__icon,
        .admin-priority-item__icon,
        .admin-metric-card__icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
        }

        .admin-signal-card__icon {
            width: 2.6rem;
            height: 2.6rem;
            border-radius: 0.9rem;
            color: #9de9ff;
            background: rgba(111, 210, 255, 0.1);
        }

        .admin-signal-card__copy {
            min-width: 0;
        }

        .admin-signal-card__copy strong,
        .admin-flow-card strong {
            color: #ffffff;
            font-size: 0.82rem;
            font-weight: 750;
        }

        .admin-signal-card__copy p {
            margin-top: 0.2rem;
            color: rgba(226, 238, 250, 0.58);
            font-size: 0.72rem;
            line-height: 1.45;
        }

        .admin-signal-card__value {
            font-family: 'Sora', sans-serif;
            font-size: 1.65rem;
            font-weight: 700;
            letter-spacing: -0.05em;
        }

        .admin-flow-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.8rem;
            margin-top: 0.8rem;
        }

        .admin-flow-card {
            padding: 1rem;
            border-radius: 1.25rem;
        }

        .admin-flow-card__top span {
            color: rgba(226, 238, 250, 0.54);
            font-size: 0.66rem;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .admin-flow-card__top i {
            color: #8ddfff;
            font-size: 0.78rem;
        }

        .admin-flow-card strong {
            display: block;
            overflow-wrap: anywhere;
            margin-top: 0.75rem;
            font-family: 'Sora', sans-serif;
            font-size: clamp(1.1rem, 2vw, 1.6rem);
            letter-spacing: -0.045em;
        }

        .admin-priority-card {
            display: flex;
            flex-direction: column;
            padding: clamp(1.25rem, 2vw, 1.75rem);
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 2rem;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 24px 60px rgba(22, 42, 70, 0.11), inset 0 1px 0 #ffffff;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .admin-priority-heading {
            display: flex;
            min-width: 0;
            align-items: center;
            gap: 0.85rem;
        }

        .admin-priority-heading__icon {
            display: inline-flex;
            width: 2.8rem;
            height: 2.8rem;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            border-radius: 1rem;
            color: #ffffff;
            background: #071d35;
            box-shadow: 0 12px 24px rgba(7, 29, 53, 0.18);
        }

        .admin-priority-heading p {
            color: #94a3b8;
            font-size: 0.67rem;
            font-weight: 800;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        .admin-priority-heading h2 {
            margin-top: 0.25rem;
            color: #071426;
            font-family: 'Sora', sans-serif;
            font-size: clamp(1.35rem, 2vw, 1.75rem);
            font-weight: 700;
            letter-spacing: -0.045em;
        }

        .admin-priority-count {
            padding: 0.55rem 0.7rem;
            color: #0b5cff;
            background: #edf4ff;
            letter-spacing: 0;
            text-transform: none;
        }

        .admin-priority-list {
            display: grid;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }

        .admin-priority-item {
            display: grid;
            grid-template-columns: auto minmax(0, 1fr) auto auto;
            gap: 0.8rem;
            align-items: center;
            min-width: 0;
            padding: 1rem;
            border: 1px solid #e3eaf3;
            border-radius: 1.25rem;
            background: #f8fafc;
            transition: border-color 180ms ease, background-color 180ms ease, transform 180ms ease, box-shadow 180ms ease;
        }

        .admin-priority-item:hover,
        .admin-priority-item:focus-visible {
            border-color: rgba(11, 92, 255, 0.3);
            background: #ffffff;
            box-shadow: 0 14px 28px rgba(15, 38, 70, 0.09);
            transform: translateY(-2px);
        }

        .admin-priority-item__icon {
            width: 2.55rem;
            height: 2.55rem;
            border-radius: 0.9rem;
            color: #0b5cff;
            background: #eaf2ff;
        }

        .admin-priority-item.is-warning .admin-priority-item__icon {
            color: #b45309;
            background: #fff4df;
        }

        .admin-priority-item__copy {
            min-width: 0;
        }

        .admin-priority-item__copy strong {
            display: block;
            color: #0f172a;
            font-size: 0.85rem;
        }

        .admin-priority-item__copy span {
            display: block;
            margin-top: 0.2rem;
            color: #64748b;
            font-size: 0.72rem;
            line-height: 1.4;
        }

        .admin-priority-item__value {
            min-width: 2.4rem;
            color: #071426;
            font-family: 'Sora', sans-serif;
            font-size: 1.65rem;
            font-weight: 700;
            letter-spacing: -0.05em;
            text-align: right;
        }

        .admin-priority-item__arrow {
            color: #94a3b8;
            font-size: 0.72rem;
        }

        .admin-priority-queue {
            display: grid;
            gap: 0.65rem;
            margin-top: 1rem;
        }

        .admin-priority-user,
        .admin-priority-empty {
            border-radius: 1.15rem;
        }

        .admin-priority-user {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            padding: 0.8rem 0.9rem;
            border: 1px solid #e6edf5;
            background: #ffffff;
        }

        .admin-priority-user__identity {
            display: flex;
            min-width: 0;
            align-items: center;
            gap: 0.7rem;
        }

        .admin-priority-user__avatar {
            display: inline-flex;
            width: 2.25rem;
            height: 2.25rem;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            border-radius: 0.8rem;
            color: #ffffff;
            background: linear-gradient(135deg, #0b5cff, #00a9c7);
            font-size: 0.72rem;
            font-weight: 800;
        }

        .admin-priority-user__copy {
            min-width: 0;
        }

        .admin-priority-user__copy strong,
        .admin-priority-empty strong {
            display: block;
            color: #0f172a;
            font-size: 0.78rem;
        }

        .admin-priority-user__copy span,
        .admin-priority-empty span {
            display: block;
            margin-top: 0.15rem;
            color: #94a3b8;
            font-size: 0.66rem;
        }

        .admin-priority-user__action {
            display: inline-flex;
            width: 2.25rem;
            height: 2.25rem;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            border-radius: 0.8rem;
            color: #ffffff;
            background: #071d35;
        }

        .admin-priority-empty {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-top: auto;
            padding: 1rem;
            border: 1px dashed #cbd5e1;
            background: rgba(248, 250, 252, 0.82);
        }

        .admin-priority-empty__icon {
            display: inline-flex;
            width: 2.45rem;
            height: 2.45rem;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            border-radius: 50%;
            color: #047857;
            background: #dff8ed;
        }

        .admin-metric-suite {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 0.75rem;
            padding: 0.75rem;
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 2rem;
            background: rgba(255, 255, 255, 0.68);
            box-shadow: 0 22px 50px rgba(20, 41, 70, 0.08), inset 0 1px 0 #ffffff;
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .admin-metric-card {
            --metric-accent: #0b5cff;
            --metric-soft: #eaf2ff;
            position: relative;
            min-width: 0;
            overflow: hidden;
            padding: 1.15rem;
            border: 1px solid transparent;
            border-radius: 1.45rem;
            background: rgba(248, 250, 252, 0.88);
            transition: border-color 180ms ease, background-color 180ms ease, transform 180ms ease, box-shadow 180ms ease;
        }

        .admin-metric-card::before {
            content: "";
            position: absolute;
            inset: 0 auto 0 0;
            width: 0.2rem;
            background: var(--metric-accent);
            opacity: 0.88;
        }

        .admin-metric-card:hover {
            border-color: color-mix(in srgb, var(--metric-accent) 24%, transparent);
            background: #ffffff;
            box-shadow: 0 16px 32px rgba(15, 38, 70, 0.09);
            transform: translateY(-2px);
        }

        .admin-metric-card.is-emerald {
            --metric-accent: #059669;
            --metric-soft: #e1f8ee;
        }

        .admin-metric-card.is-violet {
            --metric-accent: #7c3aed;
            --metric-soft: #f1eafe;
        }

        .admin-metric-card.is-amber {
            --metric-accent: #c96b08;
            --metric-soft: #fff2dc;
        }

        .admin-metric-card__index {
            color: #94a3b8;
            font-family: 'Sora', sans-serif;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.14em;
        }

        .admin-metric-card__icon {
            width: 2.65rem;
            height: 2.65rem;
            border-radius: 0.9rem;
            color: var(--metric-accent);
            background: var(--metric-soft);
        }

        .admin-metric-card__label {
            margin-top: 1.35rem;
            color: #64748b;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .admin-metric-card__value {
            display: block;
            overflow-wrap: anywhere;
            margin-top: 0.45rem;
            color: #071426;
            font-family: 'Sora', sans-serif;
            font-size: clamp(1.65rem, 2.4vw, 2.35rem);
            font-weight: 700;
            line-height: 1.05;
            letter-spacing: -0.06em;
            font-variant-numeric: tabular-nums;
        }

        .admin-metric-card__description {
            min-height: 2.6rem;
            margin-top: 0.75rem;
            color: #728198;
            font-size: 0.76rem;
            line-height: 1.55;
        }

        .admin-metric-card__rail {
            height: 0.22rem;
            margin-top: 1rem;
            overflow: hidden;
            border-radius: 999px;
            background: #e7edf4;
        }

        .admin-metric-card__rail span {
            display: block;
            width: var(--metric-fill, 68%);
            height: 100%;
            border-radius: inherit;
            background: var(--metric-accent);
        }

        .admin-insights-grid {
            display: grid;
            gap: 1.5rem;
            align-items: stretch;
        }

        .admin-insight-card {
            position: relative;
            min-width: 0;
            overflow: hidden;
            padding: clamp(1.25rem, 2vw, 1.75rem);
            border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 2rem;
            background:
                radial-gradient(circle at 100% 0%, rgba(11, 92, 255, 0.075), transparent 34%),
                rgba(255, 255, 255, 0.92);
            box-shadow: 0 24px 60px rgba(20, 41, 70, 0.09), inset 0 1px 0 #ffffff;
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .admin-insight-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto;
            height: 0.2rem;
            background: linear-gradient(90deg, #0b5cff, #22d3ee 62%, transparent);
        }

        .admin-insight-header,
        .admin-volume-summary,
        .admin-status-row,
        .admin-portfolio-foot,
        .admin-volume-ledger__top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .admin-insight-heading {
            display: flex;
            min-width: 0;
            align-items: center;
            gap: 0.85rem;
        }

        .admin-insight-heading__icon {
            display: inline-flex;
            width: 2.85rem;
            height: 2.85rem;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            border-radius: 1rem;
            color: #ffffff;
            background: #071d35;
            box-shadow: 0 12px 24px rgba(7, 29, 53, 0.17);
        }

        .admin-insight-heading p {
            color: #8ba0bc;
            font-size: 0.66rem;
            font-weight: 800;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .admin-insight-heading h2 {
            margin-top: 0.25rem;
            color: #071426;
            font-family: 'Sora', sans-serif;
            font-size: clamp(1.3rem, 2vw, 1.75rem);
            font-weight: 700;
            letter-spacing: -0.045em;
        }

        .admin-insight-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            flex: 0 0 auto;
            padding: 0.5rem 0.7rem;
            border: 1px solid #dce8f7;
            border-radius: 999px;
            color: #4f6683;
            background: rgba(248, 250, 252, 0.9);
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .admin-insight-chip.is-live {
            border-color: #b9efda;
            color: #047857;
            background: #ecfdf5;
        }

        .admin-insight-chip__dot {
            width: 0.45rem;
            height: 0.45rem;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 0 0.22rem rgba(16, 185, 129, 0.1);
        }

        .admin-portfolio-body {
            display: grid;
            gap: 1rem;
            align-items: center;
            margin-top: 1.5rem;
        }

        .admin-portfolio-chart {
            position: relative;
            width: min(100%, 13rem);
            height: 13rem;
            justify-self: center;
        }

        .admin-portfolio-chart__center {
            position: absolute;
            inset: 50% auto auto 50%;
            display: grid;
            width: 6.4rem;
            transform: translate(-50%, -50%);
            place-items: center;
            pointer-events: none;
            text-align: center;
        }

        .admin-portfolio-chart__center strong {
            color: #071426;
            font-family: 'Sora', sans-serif;
            font-size: 2rem;
            line-height: 1;
            letter-spacing: -0.06em;
        }

        .admin-portfolio-chart__center span {
            margin-top: 0.35rem;
            color: #73859d;
            font-size: 0.62rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .admin-status-list {
            display: grid;
            gap: 0.65rem;
            min-width: 0;
        }

        .admin-status-row {
            --status-accent: #0b5cff;
            --status-soft: #eaf2ff;
            display: grid;
            grid-template-columns: auto minmax(0, 1fr) auto;
            gap: 0.45rem 0.7rem;
            padding: 0.8rem;
            border: 1px solid #e3eaf3;
            border-radius: 1.15rem;
            color: inherit;
            background: rgba(248, 250, 252, 0.88);
            transition: border-color 180ms ease, background-color 180ms ease, transform 180ms ease, box-shadow 180ms ease;
        }

        .admin-status-row:hover,
        .admin-status-row:focus-visible {
            border-color: color-mix(in srgb, var(--status-accent) 28%, #e3eaf3);
            background: #ffffff;
            box-shadow: 0 12px 26px rgba(15, 38, 70, 0.08);
            transform: translateY(-2px);
        }

        .admin-status-row.is-pending {
            --status-accent: #e99a16;
            --status-soft: #fff4df;
        }

        .admin-status-row.is-suspended {
            --status-accent: #64748b;
            --status-soft: #edf1f5;
        }

        .admin-status-row__dot {
            width: 0.72rem;
            height: 0.72rem;
            margin-top: 0.2rem;
            border: 0.2rem solid var(--status-soft);
            border-radius: 50%;
            background: var(--status-accent);
            box-sizing: content-box;
        }

        .admin-status-row__copy {
            min-width: 0;
        }

        .admin-status-row__copy strong {
            display: block;
            color: #172033;
            font-size: 0.78rem;
        }

        .admin-status-row__copy span {
            display: block;
            overflow: hidden;
            margin-top: 0.12rem;
            color: #7b8ba1;
            font-size: 0.65rem;
            line-height: 1.4;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .admin-status-row__value {
            color: #071426;
            font-family: 'Sora', sans-serif;
            font-size: 1.2rem;
            font-weight: 700;
            line-height: 1;
            letter-spacing: -0.05em;
        }

        .admin-status-row__rail {
            grid-column: 2 / -1;
            height: 0.18rem;
            overflow: hidden;
            border-radius: 999px;
            background: #e7edf4;
        }

        .admin-status-row__rail span {
            display: block;
            width: var(--status-share, 0%);
            height: 100%;
            border-radius: inherit;
            background: var(--status-accent);
        }

        .admin-portfolio-foot {
            margin-top: 1.25rem;
            padding: 0.95rem 1rem;
            border: 1px solid #dfe8f2;
            border-radius: 1.2rem;
            background: linear-gradient(100deg, #f7faff, #f1f8fb);
        }

        .admin-portfolio-foot span,
        .admin-volume-summary span {
            color: #708198;
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .admin-portfolio-foot strong {
            color: #071426;
            font-family: 'Sora', sans-serif;
            font-size: 1.05rem;
            letter-spacing: -0.04em;
        }

        .admin-volume-summary {
            align-items: flex-end;
            margin-top: 1.5rem;
        }

        .admin-volume-summary strong {
            display: block;
            margin-top: 0.35rem;
            color: #071426;
            font-family: 'Sora', sans-serif;
            font-size: clamp(1.8rem, 3vw, 2.45rem);
            line-height: 1;
            letter-spacing: -0.06em;
            font-variant-numeric: tabular-nums;
        }

        .admin-volume-summary__mark {
            display: inline-flex;
            width: 2.6rem;
            height: 2.6rem;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            border-radius: 0.9rem;
            color: #0b5cff;
            background: #eaf2ff;
        }

        .admin-volume-chart-shell {
            position: relative;
            height: 14rem;
            margin-top: 1rem;
            padding: 1rem 0.65rem 0.35rem;
            border: 1px solid #e3eaf3;
            border-radius: 1.35rem;
            background:
                linear-gradient(rgba(255, 255, 255, 0.88), rgba(248, 250, 252, 0.88)),
                linear-gradient(135deg, rgba(11, 92, 255, 0.08), rgba(34, 211, 238, 0.06));
        }

        .admin-volume-ledger {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.7rem;
            margin-top: 0.8rem;
        }

        .admin-volume-ledger__item {
            min-width: 0;
            padding: 0.8rem;
            border: 1px solid #e3eaf3;
            border-radius: 1.1rem;
            background: rgba(248, 250, 252, 0.84);
        }

        .admin-volume-ledger__label {
            display: flex;
            min-width: 0;
            align-items: center;
            gap: 0.45rem;
            color: #64748b;
            font-size: 0.66rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .admin-volume-ledger__label i {
            width: 0.55rem;
            height: 0.55rem;
            flex: 0 0 auto;
            border-radius: 50%;
            background: #4f46e5;
        }

        .admin-volume-ledger__item.is-transfer .admin-volume-ledger__label i {
            background: #06b6d4;
        }

        .admin-volume-ledger__top strong {
            overflow-wrap: anywhere;
            margin-top: 0.55rem;
            color: #071426;
            font-family: 'Sora', sans-serif;
            font-size: 0.95rem;
            letter-spacing: -0.04em;
        }

        .admin-volume-ledger__share {
            color: #8494a9;
            font-size: 0.66rem;
            font-weight: 800;
        }

        .admin-volume-share {
            display: flex;
            gap: 0.2rem;
            height: 0.3rem;
            margin-top: 0.85rem;
            overflow: hidden;
            border-radius: 999px;
            background: #e7edf4;
        }

        .admin-volume-share span:first-child {
            width: var(--deposit-share, 0%);
            border-radius: inherit;
            background: #4f46e5;
        }

        .admin-volume-share span:last-child {
            width: var(--transfer-share, 0%);
            border-radius: inherit;
            background: #06b6d4;
        }

        .admin-operations-grid {
            display: grid;
            gap: 1.5rem;
            align-items: start;
        }

        .admin-operation-card,
        .admin-action-card,
        .admin-operation-rail {
            min-width: 0;
        }

        .admin-operation-header,
        .admin-operation-header__actions,
        .admin-transaction-row__heading,
        .admin-action-header,
        .admin-action-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.85rem;
        }

        .admin-operation-header__actions {
            flex: 0 0 auto;
        }

        .admin-operation-card .admin-insight-heading h2 {
            font-size: clamp(1.25rem, 1.7vw, 1.55rem);
            white-space: nowrap;
        }

        .admin-operation-health,
        .admin-operation-view {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            border-radius: 999px;
            font-size: 0.7rem;
            font-weight: 800;
        }

        .admin-operation-health {
            padding: 0.55rem 0.7rem;
            border: 1px solid #b9efda;
            color: #047857;
            background: #ecfdf5;
        }

        .admin-operation-health i {
            font-size: 0.55rem;
        }

        .admin-operation-view {
            padding: 0.65rem 0.85rem;
            border: 1px solid #dce5ef;
            color: #203149;
            background: #ffffff;
            box-shadow: 0 8px 18px rgba(15, 38, 70, 0.07);
            transition: border-color 180ms ease, color 180ms ease, transform 180ms ease, box-shadow 180ms ease;
        }

        .admin-operation-view:hover,
        .admin-operation-view:focus-visible {
            border-color: rgba(11, 92, 255, 0.3);
            color: #0b5cff;
            box-shadow: 0 12px 24px rgba(15, 38, 70, 0.11);
            transform: translateY(-2px);
        }

        .admin-transaction-list {
            display: grid;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }

        .admin-transaction-row {
            --transaction-accent: #64748b;
            --transaction-soft: #edf1f5;
            display: grid;
            grid-template-columns: auto minmax(0, 1fr) auto auto;
            gap: 0.9rem;
            align-items: center;
            min-width: 0;
            padding: 1rem;
            border: 1px solid #e2e9f2;
            border-radius: 1.35rem;
            color: inherit;
            background: rgba(248, 250, 252, 0.88);
            transition: border-color 180ms ease, background-color 180ms ease, transform 180ms ease, box-shadow 180ms ease;
        }

        .admin-transaction-row:hover,
        .admin-transaction-row:focus-visible {
            border-color: color-mix(in srgb, var(--transaction-accent) 28%, #e2e9f2);
            background: #ffffff;
            box-shadow: 0 14px 30px rgba(15, 38, 70, 0.09);
            transform: translateY(-2px);
        }

        .admin-transaction-row.is-credit {
            --transaction-accent: #059669;
            --transaction-soft: #e3f8ee;
        }

        .admin-transaction-row.is-success {
            --transaction-accent: #059669;
            --transaction-soft: #e3f8ee;
        }

        .admin-transaction-row.is-review {
            --transaction-accent: #d97706;
            --transaction-soft: #fff3dc;
        }

        .admin-transaction-row.is-failed {
            --transaction-accent: #dc2626;
            --transaction-soft: #feecec;
        }

        .admin-transaction-row.is-refunded {
            --transaction-accent: #7c3aed;
            --transaction-soft: #f2eafe;
        }

        .admin-transaction-row__icon {
            display: inline-flex;
            width: 3rem;
            height: 3rem;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            border-radius: 1rem;
            color: var(--transaction-accent);
            background: var(--transaction-soft);
        }

        .admin-transaction-row__copy {
            min-width: 0;
        }

        .admin-transaction-row__heading {
            justify-content: flex-start;
            gap: 0.55rem;
        }

        .admin-transaction-row__heading strong {
            overflow: hidden;
            color: #111b2d;
            font-size: 0.83rem;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .admin-transaction-row__reference {
            flex: 0 0 auto;
            padding: 0.22rem 0.45rem;
            border-radius: 999px;
            color: #7e8ea4;
            background: #edf2f7;
            font-family: 'Sora', sans-serif;
            font-size: 0.58rem;
            font-weight: 700;
            letter-spacing: 0.08em;
        }

        .admin-transaction-row__meta {
            display: flex;
            min-width: 0;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.3rem;
            color: #73839a;
            font-size: 0.68rem;
        }

        .admin-transaction-row__meta span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .admin-transaction-row__meta time {
            flex: 0 0 auto;
            color: #99a6b8;
        }

        .admin-transaction-row__financial {
            display: grid;
            gap: 0.35rem;
            justify-items: end;
            text-align: right;
        }

        .admin-transaction-row__amount {
            color: #071426;
            font-family: 'Sora', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: -0.035em;
            white-space: nowrap;
        }

        .admin-transaction-row.is-credit .admin-transaction-row__amount {
            color: #047857;
        }

        .admin-transaction-row__status {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.3rem 0.5rem;
            border-radius: 999px;
            color: var(--transaction-accent);
            background: var(--transaction-soft);
            font-size: 0.58rem;
            font-weight: 800;
            letter-spacing: 0.11em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .admin-transaction-row__status::before {
            content: "";
            width: 0.36rem;
            height: 0.36rem;
            border-radius: 50%;
            background: currentColor;
        }

        .admin-transaction-row__arrow {
            display: inline-flex;
            width: 2.1rem;
            height: 2.1rem;
            align-items: center;
            justify-content: center;
            border-radius: 0.75rem;
            color: #8ea0b5;
            background: #ffffff;
            box-shadow: 0 6px 14px rgba(15, 38, 70, 0.07);
        }

        .admin-transaction-empty {
            display: grid;
            min-height: 12rem;
            padding: 1.5rem;
            border: 1px dashed #cbd5e1;
            border-radius: 1.35rem;
            place-items: center;
            background: #f8fafc;
            text-align: center;
        }

        .admin-transaction-empty__icon {
            display: inline-flex;
            width: 3.2rem;
            height: 3.2rem;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
            color: #0b5cff;
            background: #eaf2ff;
        }

        .admin-transaction-empty strong {
            display: block;
            margin-top: 0.8rem;
            color: #111b2d;
        }

        .admin-transaction-empty p {
            max-width: 28rem;
            margin-top: 0.35rem;
            color: #74849a;
            font-size: 0.75rem;
            line-height: 1.55;
        }

        .admin-operation-rail {
            display: grid;
            gap: 1.5rem;
        }

        .admin-action-card {
            position: relative;
            isolation: isolate;
            overflow: hidden;
            padding: clamp(1.25rem, 2vw, 1.75rem);
            border: 1px solid rgba(130, 205, 255, 0.16);
            border-radius: 2rem;
            color: #ffffff;
            background:
                radial-gradient(circle at 100% 0%, rgba(48, 185, 255, 0.22), transparent 35%),
                linear-gradient(145deg, #06182c, #0a2b4a 64%, #0c3658);
            box-shadow: 0 25px 60px rgba(4, 22, 42, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.09);
        }

        .admin-action-card::before {
            content: "";
            position: absolute;
            z-index: -1;
            inset: 0;
            opacity: 0.24;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.04) 1px, transparent 1px);
            background-size: 26px 26px;
            mask-image: linear-gradient(135deg, #000, transparent 75%);
        }

        .admin-action-heading {
            min-width: 0;
        }

        .admin-action-heading p {
            color: rgba(191, 219, 245, 0.68);
            font-size: 0.66rem;
            font-weight: 800;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .admin-action-heading h2 {
            margin-top: 0.25rem;
            font-family: 'Sora', sans-serif;
            font-size: clamp(1.3rem, 2vw, 1.7rem);
            font-weight: 700;
            letter-spacing: -0.045em;
        }

        .admin-action-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            flex: 0 0 auto;
            padding: 0.48rem 0.65rem;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 999px;
            color: rgba(255, 255, 255, 0.72);
            background: rgba(255, 255, 255, 0.07);
            font-size: 0.64rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .admin-action-list {
            display: grid;
            gap: 0.7rem;
            margin-top: 1.35rem;
        }

        .admin-action-item {
            --action-accent: #67d6ff;
            --action-soft: rgba(103, 214, 255, 0.12);
            display: grid;
            grid-template-columns: auto minmax(0, 1fr) auto;
            justify-content: normal;
            padding: 0.85rem;
            border: 1px solid rgba(255, 255, 255, 0.09);
            border-radius: 1.15rem;
            color: inherit;
            background: rgba(255, 255, 255, 0.06);
            transition: border-color 180ms ease, background-color 180ms ease, transform 180ms ease;
        }

        .admin-action-item:hover,
        .admin-action-item:focus-visible {
            border-color: rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(3px);
        }

        .admin-action-item.is-emerald {
            --action-accent: #5ee5bd;
            --action-soft: rgba(94, 229, 189, 0.11);
        }

        .admin-action-item.is-amber {
            --action-accent: #f6bd55;
            --action-soft: rgba(246, 189, 85, 0.11);
        }

        .admin-action-item__icon {
            display: inline-flex;
            width: 2.7rem;
            height: 2.7rem;
            align-items: center;
            justify-content: center;
            border-radius: 0.9rem;
            color: var(--action-accent);
            background: var(--action-soft);
        }

        .admin-action-item__copy {
            min-width: 0;
        }

        .admin-action-item__copy strong {
            display: block;
            color: #ffffff;
            font-size: 0.8rem;
        }

        .admin-action-item__copy span {
            display: block;
            margin-top: 0.2rem;
            color: rgba(214, 231, 247, 0.58);
            font-size: 0.67rem;
            line-height: 1.45;
        }

        .admin-action-item__arrow {
            display: inline-flex;
            width: 1.9rem;
            height: 1.9rem;
            align-items: center;
            justify-content: center;
            border-radius: 0.7rem;
            color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.07);
            font-size: 0.7rem;
        }

        @media (min-width: 760px) {
            .admin-portfolio-body {
                grid-template-columns: minmax(10.5rem, 0.78fr) minmax(0, 1.22fr);
            }
        }

        @media (min-width: 1360px) {
            .admin-command-center {
                grid-template-columns: minmax(0, 1.65fr) minmax(20rem, 0.72fr);
            }

            .admin-insights-grid {
                grid-template-columns: minmax(0, 1.04fr) minmax(0, 0.96fr);
            }

            .admin-operations-grid {
                grid-template-columns: minmax(0, 1.55fr) minmax(19rem, 0.72fr);
            }
        }

        @media (max-width: 1100px) {
            .admin-metric-suite {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 760px) {
            .admin-command-header {
                align-items: flex-start;
            }

            .admin-command-seal {
                display: none;
            }

            .admin-command-hero {
                grid-template-columns: 1fr;
            }

            .admin-command-score {
                grid-template-columns: auto minmax(0, 1fr);
                justify-items: start;
                width: auto;
            }

            .admin-command-ring {
                width: 7.6rem;
            }

            .admin-command-score > p {
                max-width: 10rem;
                text-align: left;
            }

            .admin-flow-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 580px) {
            .admin-command-card,
            .admin-priority-card,
            .admin-metric-suite {
                border-radius: 1.5rem;
            }

            .admin-command-title {
                font-size: clamp(1.85rem, 10vw, 2.65rem);
            }

            .admin-signal-grid,
            .admin-metric-suite {
                grid-template-columns: 1fr;
            }

            .admin-priority-header {
                align-items: flex-start;
            }

            .admin-priority-item {
                grid-template-columns: auto minmax(0, 1fr) auto;
            }

            .admin-priority-item__arrow {
                display: none;
            }

            .admin-priority-user {
                align-items: flex-start;
            }

            .admin-insight-header,
            .admin-volume-summary {
                align-items: flex-start;
            }

            .admin-insight-heading__icon {
                width: 2.55rem;
                height: 2.55rem;
            }

            .admin-portfolio-chart {
                width: 11.5rem;
                height: 11.5rem;
            }

            .admin-volume-ledger {
                grid-template-columns: 1fr;
            }

            .admin-operation-header {
                display: grid;
                align-items: flex-start;
            }

            .admin-operation-header__actions {
                width: 100%;
                flex-wrap: wrap;
                justify-content: space-between;
            }

            .admin-transaction-row {
                grid-template-columns: auto minmax(0, 1fr) auto;
            }

            .admin-transaction-row__financial {
                grid-column: 2 / -1;
                grid-row: 2;
                display: flex;
                align-items: center;
                justify-content: space-between;
                width: 100%;
            }

            .admin-transaction-row__arrow {
                grid-column: 3;
                grid-row: 1;
            }

            .admin-metric-suite {
                padding: 0.55rem;
            }

            .admin-metric-card__description {
                min-height: 0;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .admin-priority-item,
            .admin-metric-card,
            .admin-status-row,
            .admin-transaction-row,
            .admin-operation-view,
            .admin-action-item {
                transition: none;
            }

            .admin-priority-item:hover,
            .admin-priority-item:focus-visible,
            .admin-metric-card:hover,
            .admin-status-row:hover,
            .admin-status-row:focus-visible,
            .admin-transaction-row:hover,
            .admin-transaction-row:focus-visible,
            .admin-operation-view:hover,
            .admin-operation-view:focus-visible,
            .admin-action-item:hover,
            .admin-action-item:focus-visible {
                transform: none;
            }
        }
    </style>
@endpush

@section('dashboard_content')
    @php
        $monthlyTransfersFormatted = \App\Helpers\CurrencyHelper::format($monthlyTransfers, 'EUR');
        $monthlyDepositsFormatted = \App\Helpers\CurrencyHelper::format($monthlyDeposits, 'EUR');
        $totalTransfersFormatted = \App\Helpers\CurrencyHelper::format($totalTransfers, 'EUR');
        $totalDepositsFormatted = \App\Helpers\CurrencyHelper::format($totalDeposits, 'EUR');
        $totalFlow = (float) $totalTransfers + (float) $totalDeposits;
        $transferShare = $totalFlow > 0 ? (int) round(((float) $totalTransfers / $totalFlow) * 100) : 0;
        $depositShare = $totalFlow > 0 ? 100 - $transferShare : 0;
        $monthlyFlow = (float) $monthlyTransfers + (float) $monthlyDeposits;
        $monthlyFlowFormatted = \App\Helpers\CurrencyHelper::format($monthlyFlow, 'EUR');
        $monthlyTransferShare = $monthlyFlow > 0 ? (int) round(((float) $monthlyTransfers / $monthlyFlow) * 100) : 0;
        $monthlyDepositShare = $monthlyFlow > 0 ? 100 - $monthlyTransferShare : 0;
        $pendingUsersRate = $totalUsers > 0 ? (int) round(($pendingUsersCount / $totalUsers) * 100) : 0;
        $suspendedUsersRate = $totalUsers > 0 ? (int) round(($suspendedUsersCount / $totalUsers) * 100) : 0;
    @endphp

    <div class="admin-command-center" data-admin-command-center>
        <section class="admin-command-card" aria-labelledby="admin-command-title">
            <header class="admin-command-header">
                <div class="admin-command-status">
                    <span class="admin-command-status__dot" aria-hidden="true"></span>
                    {{ __('admin_pages.executive_view') }}
                </div>
                <span class="admin-command-seal">
                    <i class="fas fa-shield-halved" aria-hidden="true"></i>
                    NEXALUNE BANK
                </span>
            </header>

            <div class="admin-command-hero">
                <div>
                    <h2 class="admin-command-title" id="admin-command-title">
                        {{ __('admin_pages.supervised_clients', ['count' => $totalUsers]) }}
                    </h2>
                    <p class="admin-command-intro">{{ __('admin_pages.admin_backoffice_intro') }}</p>

                    <div class="admin-coverage">
                        <div class="admin-coverage__meta">
                            <span>{{ __('admin_dashboard.active_coverage') }}</span>
                            <strong>{{ $activeUsersRate }}%</strong>
                        </div>
                        <div class="admin-coverage__track" aria-hidden="true">
                            <div class="admin-coverage__bar" style="width: {{ $activeUsersRate }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="admin-command-score">
                    <div class="admin-command-ring" style="--score: {{ $transactionSuccessRate }}">
                        <div class="admin-command-ring__value">
                            <strong>{{ $transactionSuccessRate }}%</strong>
                            <span>{{ __('admin_pages.transaction_success') }}</span>
                        </div>
                    </div>
                    <p>{{ __('admin_pages.system_activity') }}</p>
                </div>
            </div>

            <div class="admin-signal-grid">
                <article class="admin-signal-card">
                    <span class="admin-signal-card__icon"><i class="fas fa-bell" aria-hidden="true"></i></span>
                    <div class="admin-signal-card__copy">
                        <strong>{{ __('admin_pages.admin_alerts') }}</strong>
                        <p>{{ __('admin_pages.unread_notifications') }}</p>
                    </div>
                    <span class="admin-signal-card__value">{{ $unreadNotificationsCount }}</span>
                </article>

                <article class="admin-signal-card">
                    <span class="admin-signal-card__icon"><i class="fas fa-message" aria-hidden="true"></i></span>
                    <div class="admin-signal-card__copy">
                        <strong>{{ __('admin_pages.incoming_messages') }}</strong>
                        <p>{{ __('admin_pages.client_conversations_pending') }}</p>
                    </div>
                    <span class="admin-signal-card__value">{{ $chatUnreadCount }}</span>
                </article>
            </div>

            <div class="admin-flow-grid">
                <article class="admin-flow-card">
                    <div class="admin-flow-card__top">
                        <span>{{ __('admin_pages.transfers_30d') }}</span>
                        <i class="fas fa-paper-plane" aria-hidden="true"></i>
                    </div>
                    <strong>{{ $monthlyTransfersFormatted }}</strong>
                </article>

                <article class="admin-flow-card">
                    <div class="admin-flow-card__top">
                        <span>{{ __('admin_pages.deposits_30d') }}</span>
                        <i class="fas fa-coins" aria-hidden="true"></i>
                    </div>
                    <strong>{{ $monthlyDepositsFormatted }}</strong>
                </article>

                <article class="admin-flow-card">
                    <div class="admin-flow-card__top">
                        <span>{{ __('admin_pages.transactions_to_monitor') }}</span>
                        <i class="fas fa-wave-square" aria-hidden="true"></i>
                    </div>
                    <strong>{{ $pendingTransactionsCount }}</strong>
                </article>
            </div>
        </section>

        <section class="admin-priority-card" aria-labelledby="admin-priority-title" data-admin-priority-card>
            <header class="admin-priority-header">
                <div class="admin-priority-heading">
                    <span class="admin-priority-heading__icon"><i class="fas fa-list-check" aria-hidden="true"></i></span>
                    <div>
                        <p>{{ __('admin_pages.priorities') }}</p>
                        <h2 id="admin-priority-title">{{ __('admin_pages.critical_queue') }}</h2>
                    </div>
                </div>
                <span class="admin-priority-count">
                    {{ trans_choice('admin_pages.items', $pendingUsersCount + $pendingTransactionsCount, ['count' => $pendingUsersCount + $pendingTransactionsCount]) }}
                </span>
            </header>

            <div class="admin-priority-list">
                <a class="admin-priority-item" href="{{ localized_route('admin.users') }}">
                    <span class="admin-priority-item__icon"><i class="fas fa-user-check" aria-hidden="true"></i></span>
                    <span class="admin-priority-item__copy">
                        <strong>{{ __('admin_pages.pending_users') }}</strong>
                        <span>{{ __('admin_pages.admin_validation_needed') }}</span>
                    </span>
                    <span class="admin-priority-item__value">{{ $pendingUsersCount }}</span>
                    <i class="admin-priority-item__arrow fas fa-arrow-right" aria-hidden="true"></i>
                </a>

                <a class="admin-priority-item is-warning" href="{{ localized_route('admin.transactions') }}">
                    <span class="admin-priority-item__icon"><i class="fas fa-triangle-exclamation" aria-hidden="true"></i></span>
                    <span class="admin-priority-item__copy">
                        <strong>{{ __('admin_pages.transactions_to_monitor') }}</strong>
                        <span>{{ __('admin_pages.pending_operations') }}</span>
                    </span>
                    <span class="admin-priority-item__value">{{ $pendingTransactionsCount }}</span>
                    <i class="admin-priority-item__arrow fas fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>

            <div class="admin-priority-queue">
                @forelse($pendingUsers as $pendingUser)
                    <div class="admin-priority-user">
                        <div class="admin-priority-user__identity">
                            <span class="admin-priority-user__avatar"><i class="fas fa-user" aria-hidden="true"></i></span>
                            <div class="admin-priority-user__copy">
                                <strong>{{ $pendingUser->name }}</strong>
                                <span>{{ $pendingUser->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                        <a
                            class="admin-priority-user__action"
                            href="{{ localized_route('admin.users.edit', ['user' => $pendingUser]) }}"
                            aria-label="{{ __('admin_pages.open') }} — {{ $pendingUser->name }}"
                        >
                            <i class="fas fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                @empty
                    <div class="admin-priority-empty">
                        <span class="admin-priority-empty__icon"><i class="fas fa-circle-check" aria-hidden="true"></i></span>
                        <div>
                            <strong>{{ __('admin_pages.no_urgent_validation') }}</strong>
                            <span>{{ __('admin_pages.queue_empty') }}</span>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    <section class="admin-metric-suite" aria-label="{{ __('admin_pages.executive_view') }}" data-admin-metric-suite>
        <article class="admin-metric-card">
            <div class="admin-metric-card__top">
                <span class="admin-metric-card__index">01</span>
                <span class="admin-metric-card__icon"><i class="fas fa-users" aria-hidden="true"></i></span>
            </div>
            <p class="admin-metric-card__label">{{ __('admin_pages.active_clients') }}</p>
            <strong class="admin-metric-card__value">{{ $activeUsers }}</strong>
            <p class="admin-metric-card__description">{{ __('admin_pages.active_user_base', ['rate' => $activeUsersRate]) }}</p>
            <div class="admin-metric-card__rail" style="--metric-fill: {{ $activeUsersRate }}%" aria-hidden="true"><span></span></div>
        </article>

        <article class="admin-metric-card is-emerald">
            <div class="admin-metric-card__top">
                <span class="admin-metric-card__index">02</span>
                <span class="admin-metric-card__icon"><i class="fas fa-arrow-right-arrow-left" aria-hidden="true"></i></span>
            </div>
            <p class="admin-metric-card__label">{{ __('admin_pages.transactions') }}</p>
            <strong class="admin-metric-card__value">{{ $totalTransactions }}</strong>
            <p class="admin-metric-card__description">{{ __('admin_pages.system_activity') }}</p>
            <div class="admin-metric-card__rail" style="--metric-fill: {{ $transactionSuccessRate }}%" aria-hidden="true"><span></span></div>
        </article>

        <article class="admin-metric-card is-violet">
            <div class="admin-metric-card__top">
                <span class="admin-metric-card__index">03</span>
                <span class="admin-metric-card__icon"><i class="fas fa-paper-plane" aria-hidden="true"></i></span>
            </div>
            <p class="admin-metric-card__label">{{ __('admin_pages.total_transfers') }}</p>
            <strong class="admin-metric-card__value">{{ $totalTransfersFormatted }}</strong>
            <p class="admin-metric-card__description">{{ __('admin_pages.transfers_volume') }}</p>
            <div class="admin-metric-card__rail" style="--metric-fill: {{ $transferShare }}%" aria-hidden="true"><span></span></div>
        </article>

        <article class="admin-metric-card is-amber">
            <div class="admin-metric-card__top">
                <span class="admin-metric-card__index">04</span>
                <span class="admin-metric-card__icon"><i class="fas fa-coins" aria-hidden="true"></i></span>
            </div>
            <p class="admin-metric-card__label">{{ __('admin_pages.total_deposits') }}</p>
            <strong class="admin-metric-card__value">{{ $totalDepositsFormatted }}</strong>
            <p class="admin-metric-card__description">{{ __('admin_pages.credited_base') }}</p>
            <div class="admin-metric-card__rail" style="--metric-fill: {{ $depositShare }}%" aria-hidden="true"><span></span></div>
        </article>
    </section>

    <div class="admin-insights-grid" data-admin-insights-grid>
        <section class="admin-insight-card admin-portfolio-card" aria-labelledby="admin-portfolio-title" data-admin-portfolio-card>
            <header class="admin-insight-header">
                <div class="admin-insight-heading">
                    <span class="admin-insight-heading__icon"><i class="fas fa-user-shield" aria-hidden="true"></i></span>
                    <div>
                        <p>{{ __('admin_pages.users_health') }}</p>
                        <h2 id="admin-portfolio-title">{{ __('admin_pages.status_breakdown') }}</h2>
                    </div>
                </div>
                <span class="admin-insight-chip is-live">
                    <span class="admin-insight-chip__dot" aria-hidden="true"></span>
                    {{ __('admin_pages.live') }}
                </span>
            </header>

            <div class="admin-portfolio-body">
                <div class="admin-portfolio-chart">
                    <canvas id="adminStatusChart" role="img" aria-label="{{ __('admin_pages.status_breakdown') }}"></canvas>
                    <div class="admin-portfolio-chart__center" aria-hidden="true">
                        <strong>{{ $activeUsersRate }}%</strong>
                        <span>{{ __('admin_pages.active') }}</span>
                    </div>
                </div>

                <div class="admin-status-list">
                    <a class="admin-status-row" href="{{ localized_route('admin.users') }}">
                        <span class="admin-status-row__dot" aria-hidden="true"></span>
                        <span class="admin-status-row__copy">
                            <strong>{{ __('admin_pages.active') }}</strong>
                            <span>{{ __('admin_pages.active_help') }}</span>
                        </span>
                        <span class="admin-status-row__value">{{ $activeUsers }}</span>
                        <span class="admin-status-row__rail" aria-hidden="true"><span style="--status-share: {{ $activeUsersRate }}%"></span></span>
                    </a>

                    <a class="admin-status-row is-pending" href="{{ localized_route('admin.users') }}">
                        <span class="admin-status-row__dot" aria-hidden="true"></span>
                        <span class="admin-status-row__copy">
                            <strong>{{ __('admin_pages.pending') }}</strong>
                            <span>{{ __('admin_pages.pending_help') }}</span>
                        </span>
                        <span class="admin-status-row__value">{{ $pendingUsersCount }}</span>
                        <span class="admin-status-row__rail" aria-hidden="true"><span style="--status-share: {{ $pendingUsersRate }}%"></span></span>
                    </a>

                    <a class="admin-status-row is-suspended" href="{{ localized_route('admin.users') }}">
                        <span class="admin-status-row__dot" aria-hidden="true"></span>
                        <span class="admin-status-row__copy">
                            <strong>{{ __('admin_pages.suspended') }}</strong>
                            <span>{{ __('admin_pages.suspended_help') }}</span>
                        </span>
                        <span class="admin-status-row__value">{{ $suspendedUsersCount }}</span>
                        <span class="admin-status-row__rail" aria-hidden="true"><span style="--status-share: {{ $suspendedUsersRate }}%"></span></span>
                    </a>
                </div>
            </div>

            <div class="admin-portfolio-foot">
                <span>{{ __('admin_pages.supervised_clients', ['count' => $totalUsers]) }}</span>
                <strong>{{ $activeUsers }}/{{ $totalUsers }}</strong>
            </div>
        </section>

        <section class="admin-insight-card admin-volume-card" aria-labelledby="admin-volume-title" data-admin-volume-card>
            <header class="admin-insight-header">
                <div class="admin-insight-heading">
                    <span class="admin-insight-heading__icon"><i class="fas fa-chart-column" aria-hidden="true"></i></span>
                    <div>
                        <p>{{ __('admin_pages.cadence') }}</p>
                        <h2 id="admin-volume-title">{{ __('admin_pages.volumes_30_days') }}</h2>
                    </div>
                </div>
                <span class="admin-insight-chip">EUR</span>
            </header>

            <div class="admin-volume-summary">
                <div>
                    <span>{{ __('admin_pages.system_activity') }}</span>
                    <strong>{{ $monthlyFlowFormatted }}</strong>
                </div>
                <span class="admin-volume-summary__mark"><i class="fas fa-wave-square" aria-hidden="true"></i></span>
            </div>

            <div class="admin-volume-chart-shell">
                <canvas id="adminVolumeChart" role="img" aria-label="{{ __('admin_pages.volumes_30_days') }}"></canvas>
            </div>

            <div class="admin-volume-ledger">
                <div class="admin-volume-ledger__item">
                    <span class="admin-volume-ledger__label"><i aria-hidden="true"></i>{{ __('admin_pages.chart_deposits_30d') }}</span>
                    <div class="admin-volume-ledger__top">
                        <strong>{{ $monthlyDepositsFormatted }}</strong>
                        <span class="admin-volume-ledger__share">{{ $monthlyDepositShare }}%</span>
                    </div>
                </div>
                <div class="admin-volume-ledger__item is-transfer">
                    <span class="admin-volume-ledger__label"><i aria-hidden="true"></i>{{ __('admin_pages.chart_transfers_30d') }}</span>
                    <div class="admin-volume-ledger__top">
                        <strong>{{ $monthlyTransfersFormatted }}</strong>
                        <span class="admin-volume-ledger__share">{{ $monthlyTransferShare }}%</span>
                    </div>
                </div>
            </div>

            <div class="admin-volume-share" style="--deposit-share: {{ $monthlyDepositShare }}%; --transfer-share: {{ $monthlyTransferShare }}%" aria-hidden="true">
                <span></span>
                <span></span>
            </div>
        </section>
    </div>

    <section class="premium-panel premium-card-hover min-w-0 rounded-[30px] p-6">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">{{ __('admin_pages.onboarding') }}</p>
                    <h2 class="premium-brand-title mt-2 text-2xl font-semibold text-slate-950">{{ __('admin_pages.recent') }}</h2>
                </div>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500">{{ __('admin_pages.new') }}</span>
            </div>

            <div class="mt-6 space-y-3">
                @foreach($recentUsers as $recentUser)
                    <div class="rounded-[22px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-900">{{ $recentUser->name }}</p>
                                <p class="mt-1 truncate text-sm text-slate-500">{{ $recentUser->email }}</p>
                            </div>
                            <span class="rounded-full px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] {{ $recentUser->status === 'active' ? 'bg-emerald-50 text-emerald-700' : ($recentUser->status === 'pending' ? 'bg-amber-50 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                                {{ $recentUser->status }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
    </section>

    <div class="admin-operations-grid" data-admin-operations-grid>
        <section class="admin-insight-card admin-operation-card" aria-labelledby="admin-transactions-title" data-admin-transactions-card>
            <header class="admin-operation-header">
                <div class="admin-insight-heading">
                    <span class="admin-insight-heading__icon"><i class="fas fa-receipt" aria-hidden="true"></i></span>
                    <div>
                        <p>{{ __('admin_pages.supervision') }}</p>
                        <h2 id="admin-transactions-title">{{ __('admin_pages.recent_transactions') }}</h2>
                    </div>
                </div>
                <div class="admin-operation-header__actions">
                    <span class="admin-operation-health">
                        <i class="fas fa-circle" aria-hidden="true"></i>
                        {{ __('admin_pages.transaction_success') }} · {{ $transactionSuccessRate }}%
                    </span>
                    <a href="{{ localized_route('admin.transactions') }}" class="admin-operation-view">
                        {{ __('admin_pages.view_all') }}
                        <i class="fas fa-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </header>

            <div class="admin-transaction-list">
                @forelse($recentTransactions as $transaction)
                    @php
                        $isCredit = $transaction->type === 'deposit';
                        $transactionTone = match ($transaction->status) {
                            'success' => 'is-success',
                            'pending', 'on_hold' => 'is-review',
                            'refunded' => 'is-refunded',
                            default => 'is-failed',
                        };
                        $transactionIcon = match ($transaction->type) {
                            'deposit' => 'fa-arrow-down',
                            'withdrawal' => 'fa-arrow-up',
                            default => 'fa-paper-plane',
                        };
                        $transactionTypeLabel = __('profile.transaction_types.' . $transaction->type);
                        $transactionStatusLabel = $transaction->status === 'refunded'
                            ? __('admin_pages.refunded')
                            : __('profile.transaction_statuses.' . $transaction->status);
                    @endphp
                    <a
                        class="admin-transaction-row {{ $isCredit ? 'is-credit' : '' }} {{ $transactionTone }}"
                        href="{{ localized_route('admin.transactions') }}"
                        aria-label="{{ $transactionTypeLabel }} #{{ $transaction->id }}"
                    >
                        <span class="admin-transaction-row__icon">
                            <i class="fas {{ $transactionIcon }}" aria-hidden="true"></i>
                        </span>
                        <span class="admin-transaction-row__copy">
                            <span class="admin-transaction-row__heading">
                                <strong>{{ $transactionTypeLabel }}</strong>
                                <span class="admin-transaction-row__reference">#{{ str_pad((string) $transaction->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </span>
                            <span class="admin-transaction-row__meta">
                                <i class="fas fa-user" aria-hidden="true"></i>
                                <span>{{ $transaction->user?->name ?? __('admin_pages.unknown_client') }}</span>
                                <time datetime="{{ $transaction->created_at->toIso8601String() }}">{{ $transaction->created_at->format('d/m/Y · H:i') }}</time>
                            </span>
                        </span>
                        <span class="admin-transaction-row__financial">
                            <span class="admin-transaction-row__amount">
                                {{ $isCredit ? '+' : '-' }}{{ \App\Helpers\CurrencyHelper::format($transaction->amount, 'EUR') }}
                            </span>
                            <span class="admin-transaction-row__status">{{ $transactionStatusLabel }}</span>
                        </span>
                        <span class="admin-transaction-row__arrow"><i class="fas fa-arrow-right" aria-hidden="true"></i></span>
                    </a>
                @empty
                    <div class="admin-transaction-empty">
                        <div>
                            <span class="admin-transaction-empty__icon"><i class="fas fa-receipt" aria-hidden="true"></i></span>
                            <strong>{{ __('admin_pages.no_recent_transaction') }}</strong>
                            <p>{{ __('admin_pages.recent_transaction_empty_help') }}</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>

        <div class="admin-operation-rail">
            <section class="admin-action-card" aria-labelledby="admin-actions-title" data-admin-actions-card>
                <header class="admin-action-header">
                    <div class="admin-action-heading">
                        <p>{{ __('admin_pages.execution') }}</p>
                        <h2 id="admin-actions-title">{{ __('admin_pages.quick_actions') }}</h2>
                    </div>
                    <span class="admin-action-badge"><i class="fas fa-shield-halved" aria-hidden="true"></i> Admin</span>
                </header>

                <div class="admin-action-list">
                    <a href="{{ localized_route('admin.users') }}" class="admin-action-item">
                        <span class="admin-action-item__icon"><i class="fas fa-user-check" aria-hidden="true"></i></span>
                        <span class="admin-action-item__copy">
                            <strong>{{ __('admin_pages.manage_users') }}</strong>
                            <span>{{ __('admin_pages.pending_validations', ['count' => $pendingUsersCount]) }}</span>
                        </span>
                        <span class="admin-action-item__arrow"><i class="fas fa-arrow-right" aria-hidden="true"></i></span>
                    </a>

                    <a href="{{ localized_route('admin.deposit') }}" class="admin-action-item is-emerald">
                        <span class="admin-action-item__icon"><i class="fas fa-circle-plus" aria-hidden="true"></i></span>
                        <span class="admin-action-item__copy">
                            <strong>{{ __('admin_pages.make_deposit') }}</strong>
                            <span>{{ __('admin_pages.make_deposit_help') }}</span>
                        </span>
                        <span class="admin-action-item__arrow"><i class="fas fa-arrow-right" aria-hidden="true"></i></span>
                    </a>

                    <a href="{{ localized_route('admin.settings') }}" class="admin-action-item is-amber">
                        <span class="admin-action-item__icon"><i class="fas fa-sliders" aria-hidden="true"></i></span>
                        <span class="admin-action-item__copy">
                            <strong>{{ __('admin_pages.set_settings') }}</strong>
                            <span>{{ __('admin_pages.set_settings_help') }}</span>
                        </span>
                        <span class="admin-action-item__arrow"><i class="fas fa-arrow-right" aria-hidden="true"></i></span>
                    </a>
                </div>
            </section>

            @include('components.live-news-feed', ['audience' => 'admin'])
        </div>
    </div>
@endsection

@section('dashboard_overlays')
    @include('components.admin-chat-widget-v2')
@endsection

@push('premium_dashboard_scripts')
    @php
        $adminStatusChartLabels = [__('admin_pages.active'), __('admin_pages.pending'), __('admin_pages.suspended')];
        $adminStatusChartValues = [$activeUsers, $pendingUsersCount, $suspendedUsersCount];
        $adminVolumeChartLabels = [__('admin_pages.chart_deposits_30d'), __('admin_pages.chart_transfers_30d')];
        $adminVolumeChartValues = [round((float) $monthlyDeposits, 2), round((float) $monthlyTransfers, 2)];
    @endphp
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusCtx = document.getElementById('adminStatusChart');
            const volumeCtx = document.getElementById('adminVolumeChart');
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            if (statusCtx) {
                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: @json($adminStatusChartLabels),
                        datasets: [{
                            data: @json($adminStatusChartValues),
                            backgroundColor: ['#0b5cff', '#e99a16', '#94a3b8'],
                            hoverBackgroundColor: ['#064bd6', '#d1840b', '#718096'],
                            borderColor: '#ffffff',
                            borderWidth: 4,
                            hoverOffset: 3,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '76%',
                        animation: {
                            duration: reduceMotion ? 0 : 700,
                        },
                        plugins: {
                            legend: {
                                display: false,
                            },
                            tooltip: {
                                displayColors: true,
                                usePointStyle: true,
                            },
                        },
                    },
                });
            }

            if (volumeCtx) {
                const volumeContext = volumeCtx.getContext('2d');
                const depositGradient = volumeContext.createLinearGradient(0, 0, 0, 240);
                const transferGradient = volumeContext.createLinearGradient(0, 0, 0, 240);

                depositGradient.addColorStop(0, '#7669f7');
                depositGradient.addColorStop(1, '#4f46e5');
                transferGradient.addColorStop(0, '#4bd4e8');
                transferGradient.addColorStop(1, '#06a8c7');

                new Chart(volumeContext, {
                    type: 'bar',
                    data: {
                        labels: @json($adminVolumeChartLabels),
                        datasets: [{
                            label: @js(__('admin_pages.chart_amount')),
                            data: @json($adminVolumeChartValues),
                            backgroundColor: [depositGradient, transferGradient],
                            borderRadius: 14,
                            borderSkipped: false,
                            maxBarThickness: 72,
                            categoryPercentage: 0.72,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: reduceMotion ? 0 : 700,
                        },
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        plugins: {
                            legend: {
                                display: false,
                            },
                            tooltip: {
                                displayColors: false,
                                backgroundColor: '#071d35',
                                padding: 12,
                                cornerRadius: 12,
                                callbacks: {
                                    label: function (context) {
                                        return new Intl.NumberFormat('fr-FR', {
                                            style: 'currency',
                                            currency: 'EUR'
                                        }).format(context.parsed.y);
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false,
                                },
                                border: {
                                    display: false,
                                },
                                ticks: {
                                    color: '#718096',
                                    font: {
                                        size: 11,
                                        weight: 700,
                                    },
                                },
                            },
                            y: {
                                beginAtZero: true,
                                border: {
                                    display: false,
                                },
                                ticks: {
                                    color: '#8a99ad',
                                    maxTicksLimit: 5,
                                    padding: 8,
                                    callback: function (value) {
                                        return new Intl.NumberFormat('fr-FR', {
                                            style: 'currency',
                                            currency: 'EUR',
                                            maximumFractionDigits: 0
                                        }).format(value);
                                    }
                                },
                                grid: {
                                    color: 'rgba(148, 163, 184, 0.15)',
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush
