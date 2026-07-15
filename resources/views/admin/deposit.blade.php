@extends('layouts.admin-premium')

@php
    $depositVolume30DaysFormatted = \App\Helpers\CurrencyHelper::format($depositVolume30Days ?? 0, 'EUR');
@endphp

@section('title', __('admin_pages.manual_deposit_title') . ' - Zuider Bank S.A Admin')
@section('admin_nav_active', 'deposit')
@section('dashboard_page_title', __('admin_pages.manual_deposit_title'))
@section('dashboard_page_subtitle', __('admin_pages.deposit_subtitle'))
@section('dashboard_section_label', __('admin_pages.credit_operations'))

@section('dashboard_header_actions')
    <a href="{{ localized_route('admin.users') }}" class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-800">
        <i class="fas fa-users text-xs"></i>
        {{ __('admin_pages.users') }}
    </a>
    <a href="{{ localized_route('admin.settings') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
        <i class="fas fa-sliders text-xs"></i>
        {{ __('admin_pages.settings') }}
    </a>
@endsection

@push('premium_dashboard_head')
    <style>
        .admin-field { background: rgba(248, 250, 252, 0.9); border: 1px solid rgba(148, 163, 184, 0.24); box-shadow: inset 0 1px 0 rgba(255,255,255,0.72); transition: border-color .18s, box-shadow .18s, background-color .18s; }
        .admin-field:focus { background: rgba(255,255,255,.98); border-color: rgba(21, 94, 239, 0.36); box-shadow: 0 0 0 4px rgba(21, 94, 239, 0.08); outline: none; }
        .admin-surface { border: 1px solid rgba(148,163,184,.18); background: linear-gradient(180deg, rgba(255,255,255,.94), rgba(248,250,252,.88)); box-shadow: 0 18px 36px rgba(15,23,42,.06); }
        .admin-kpi { display: block; max-width: 100%; font-size: clamp(1.4rem, .95rem + 1vw, 2.4rem); line-height: 1.08; overflow-wrap: anywhere; word-break: break-word; }
    </style>
@endpush

@section('dashboard_content')
    <section class="premium-gradient-card premium-grid-glow relative overflow-hidden rounded-[30px] p-6 sm:p-7">
        <div class="relative z-10 grid gap-3 sm:grid-cols-2 2xl:grid-cols-4">
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('admin_pages.eligible_clients') }}</p><p class="admin-kpi premium-kpi-number mt-2 font-semibold">{{ $users->count() }}</p></div>
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('admin_pages.deposits_today') }}</p><p class="admin-kpi premium-kpi-number mt-2 font-semibold">{{ $depositsTodayCount }}</p></div>
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('admin_pages.volume_30_days') }}</p><p class="admin-kpi premium-kpi-number mt-2 font-semibold">{{ $depositVolume30DaysFormatted }}</p></div>
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('admin_pages.recent_deposits') }}</p><p class="admin-kpi premium-kpi-number mt-2 font-semibold">{{ $recentDeposits->count() }}</p></div>
        </div>
    </section>

    @if(session('success') || session('status'))
        <div class="rounded-[26px] border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">
            {{ session('success') ?? session('status') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-[26px] border border-rose-200 bg-rose-50 px-5 py-4">
            <p class="text-sm font-semibold text-rose-800">{{ __('admin_pages.validation_errors') }}</p>
            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-rose-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid gap-6 2xl:grid-cols-[minmax(0,1.55fr)_380px]">
        <section class="admin-surface rounded-[30px] p-5 sm:p-6">
            <div class="flex items-start justify-between gap-3 border-b border-slate-200/70 pb-5">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('admin_pages.operation') }}</p>
                    <h2 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">{{ __('admin_pages.credit_account') }}</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-500">{{ __('admin_pages.credit_account_help') }}</p>
                </div>
                <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">{{ __('admin_pages.manual_execution') }}</span>
            </div>

            <form method="POST" action="{{ localized_route('admin.deposit.store') }}" class="mt-6 space-y-6">
                @csrf
                <div class="grid gap-5 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label for="user_id" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.users') }}</label>
                        <select name="user_id" id="user_id" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" required>
                            <option value="">{{ __('admin_pages.choose_user') }}</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" data-balance="{{ $user->balance }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->first_name }} {{ $user->last_name }} - {{ $user->email }}
                                </option>
                            @endforeach
                        </select>
                        <div id="balance-display" class="mt-3 hidden rounded-2xl bg-blue-50 px-4 py-3 text-sm text-blue-700 ring-1 ring-blue-200/80">
                            {{ __('admin_pages.current_balance') }} : <span id="current-balance" class="font-semibold"></span> <span id="balance-symbol">EUR</span>
                        </div>
                    </div>

                    <div>
                        <label for="amount" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.amount') }}</label>
                        <input type="number" name="amount" id="amount" min="0.01" step="0.01" value="{{ old('amount') }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" placeholder="0.00" required>
                    </div>
                    <div>
                        <label for="currency" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.currency') }}</label>
                        <select name="currency" id="currency" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" required>
                            <option value="">{{ __('admin_pages.choose_currency') }}</option>
                            @foreach(config('currencies.currencies') as $code => $name)
                                <option value="{{ $code }}" {{ old('currency') == $code ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="reason" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.reason') }}</label>
                        <textarea name="reason" id="reason" rows="4" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" placeholder="{{ __('admin_pages.reason_placeholder') }}">{{ old('reason') }}</textarea>
                    </div>
                </div>

                <div class="rounded-[24px] bg-blue-50 px-4 py-4 ring-1 ring-blue-200/70">
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-blue-700">{{ __('admin_pages.preview') }}</p>
                    <p id="preview-text" class="mt-2 text-sm font-medium text-blue-900">{{ __('admin_pages.deposit_preview_empty') }}</p>
                    <p id="new-balance" class="mt-2 hidden text-sm text-blue-700">{{ __('admin_pages.new_balance') }} : <span id="new-balance-amount" class="font-semibold"></span> <span id="new-balance-symbol">EUR</span></p>
                </div>

                <div class="rounded-[24px] bg-amber-50 px-4 py-4 ring-1 ring-amber-200/80">
                    <p class="text-sm font-semibold text-amber-900">{{ __('admin_pages.confirmation_required') }}</p>
                    <p class="mt-2 text-sm leading-6 text-amber-700">{{ __('admin_pages.deposit_confirmation_text') }}</p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <a href="{{ localized_route('admin.dashboard') }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                        <i class="fas fa-arrow-left text-xs"></i> {{ __('admin_pages.back') }}
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-blue-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-800" onclick="return confirm(@js(__('admin_pages.confirm_manual_deposit')))">
                        <i class="fas fa-plus-circle text-xs"></i> {{ __('admin_pages.perform_deposit') }}
                    </button>
                </div>
            </form>
        </section>

        <aside class="space-y-6">
            <section class="admin-surface rounded-[30px] p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('admin_pages.history') }}</p>
                <h3 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">{{ __('admin_pages.recent_deposits') }}</h3>
                <div class="mt-5 space-y-3">
                    @forelse($recentDeposits as $deposit)
                        <div class="rounded-[22px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-900">{{ $deposit->user?->first_name }} {{ $deposit->user?->last_name }}</p>
                                    <p class="mt-1 text-xs uppercase tracking-[0.16em] text-slate-400">{{ $deposit->created_at->format('d/m/Y H:i') }}</p>
                                    <p class="mt-2 text-sm text-slate-500">{{ $deposit->reason ?: __('admin_pages.manual_deposit') }}</p>
                                </div>
                                <span class="text-sm font-semibold text-emerald-700">+{{ number_format($deposit->amount, 2, ',', ' ') }} EUR</span>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-[22px] border border-dashed border-slate-300 bg-slate-50 px-4 py-8 text-center">
                            <p class="text-sm font-semibold text-slate-900">{{ __('admin_pages.no_recent_deposit') }}</p>
                            <p class="mt-2 text-sm text-slate-500">{{ __('admin_pages.recent_deposits_empty_help') }}</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </aside>
    </div>
@endsection

@push('premium_dashboard_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const userSelect = document.getElementById('user_id');
            const amountInput = document.getElementById('amount');
            const currencySelect = document.getElementById('currency');
            const previewText = document.getElementById('preview-text');
            const balanceDisplay = document.getElementById('balance-display');
            const currentBalance = document.getElementById('current-balance');
            const balanceSymbol = document.getElementById('balance-symbol');
            const newBalance = document.getElementById('new-balance');
            const newBalanceAmount = document.getElementById('new-balance-amount');
            const newBalanceSymbol = document.getElementById('new-balance-symbol');

            const getCurrencySymbol = (code) => {
                const currencies = @json(config('currencies.currencies'));
                const label = currencies[code] || code;
                const match = label.match(/\(([^)]+)\)/);
                return match ? match[1] : code;
            };

            const updatePreview = () => {
                const option = userSelect.options[userSelect.selectedIndex];
                if (!userSelect.value || !amountInput.value || !currencySelect.value || !option) {
                    previewText.textContent = @js(__('admin_pages.deposit_preview_empty'));
                    balanceDisplay.classList.add('hidden');
                    newBalance.classList.add('hidden');
                    return;
                }

                const symbol = getCurrencySymbol(currencySelect.value);
                const balance = Number(option.getAttribute('data-balance') || 0);
                const amount = Number(amountInput.value || 0);
                const label = option.text.split(' - ')[0];

                previewText.textContent = @js(__('admin_pages.deposit_preview_text')).replace(':amount', amount.toFixed(2)).replace(':symbol', symbol).replace(':label', label);
                currentBalance.textContent = balance.toFixed(2);
                balanceSymbol.textContent = symbol;
                newBalanceAmount.textContent = (balance + amount).toFixed(2);
                newBalanceSymbol.textContent = symbol;
                balanceDisplay.classList.remove('hidden');
                newBalance.classList.remove('hidden');
            };

            [userSelect, amountInput, currencySelect].forEach((element) => element?.addEventListener('change', updatePreview));
            amountInput?.addEventListener('input', updatePreview);
            updatePreview();
        });
    </script>
@endpush
