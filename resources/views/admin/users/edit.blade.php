@extends('layouts.admin-premium')

@php
    $creditCard = $user->creditCard;
    $photoUrl = $user->profile_photo_url;
    $initials = strtoupper(substr((string) $user->first_name, 0, 1) . substr((string) $user->last_name, 0, 1));
    $status = old('status', $user->status);
    $role = old('role', $user->role);
    $statusMeta = $status === 'suspended'
        ? ['label' => __('admin_pages.suspended_status'), 'icon' => 'fa-ban', 'class' => 'bg-rose-50 text-rose-700 ring-1 ring-rose-200/80']
        : ['label' => __('admin_pages.active'), 'icon' => 'fa-circle-check', 'class' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/80'];
    $roleMeta = $role === 'admin'
        ? ['label' => __('admin_pages.administrator'), 'icon' => 'fa-user-shield', 'class' => 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-200/80']
        : ['label' => __('admin_pages.client'), 'icon' => 'fa-user', 'class' => 'bg-sky-50 text-sky-700 ring-1 ring-sky-200/80'];
    $balanceFormatted = \App\Helpers\CurrencyHelper::format($user->balance, $user->default_currency ?? 'EUR');
    $balanceInput = old('balance', number_format((float) $user->balance, 2, ',', ''));
    $idType = match ((string) old('type_piece', $user->id_type)) {
        'passport', 'Passeport' => 'Passport',
        default => old('type_piece', $user->id_type),
    };
@endphp

@section('title', __('admin_pages.edit_user_title'))
@section('admin_nav_active', 'users')
@section('dashboard_page_title', __('admin_pages.edit_user_heading'))
@section('dashboard_page_subtitle', __('admin_pages.edit_user_subtitle'))
@section('dashboard_section_label', __('admin_pages.users_management'))

@section('dashboard_header_actions')
    <a href="{{ localized_route('admin.users') }}" class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-800"><i class="fas fa-users text-xs"></i> {{ __('admin_pages.back_to_list') }}</a>
    <a href="{{ localized_route('admin.users.create') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50"><i class="fas fa-user-plus text-xs"></i> {{ __('admin_pages.new_user') }}</a>
@endsection

@push('premium_dashboard_head')
    <style>
        .admin-field{background:rgba(248,250,252,.92);border:1px solid rgba(148,163,184,.24);box-shadow:inset 0 1px 0 rgba(255,255,255,.72);transition:border-color .18s,box-shadow .18s,background-color .18s}.admin-field:focus{background:rgba(255,255,255,.98);border-color:rgba(21,94,239,.36);box-shadow:0 0 0 4px rgba(21,94,239,.08);outline:none}.admin-surface{border:1px solid rgba(148,163,184,.18);background:linear-gradient(180deg,rgba(255,255,255,.95),rgba(248,250,252,.88));box-shadow:0 18px 36px rgba(15,23,42,.06)}.admin-section{border:1px solid rgba(226,232,240,.85);background:rgba(248,250,252,.78)}.admin-chip{display:inline-flex;align-items:center;gap:.5rem;border-radius:9999px;padding:.6rem .95rem;font-size:.75rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase}
        .admin-side-card{position:relative;min-width:0;border:1px solid rgba(148,163,184,.18);background:linear-gradient(180deg,rgba(255,255,255,.98),rgba(248,250,252,.92));box-shadow:0 18px 36px rgba(15,23,42,.06)}
        .admin-side-card::before{content:"";position:absolute;inset:0;border-radius:inherit;background:radial-gradient(circle at top right,rgba(21,94,239,.08),transparent 40%);pointer-events:none}
        .admin-side-card>*{position:relative;z-index:1}
        .admin-side-icon{display:inline-flex;height:3rem;width:3rem;flex-shrink:0;align-items:center;justify-content:center;border-radius:1rem;box-shadow:inset 0 1px 0 rgba(255,255,255,.78)}
        .admin-side-row{display:flex;flex-direction:column;gap:.35rem;padding:.75rem 0}
        .admin-side-row:first-child{padding-top:0}
        .admin-side-row:last-child{padding-bottom:0}
        .admin-side-value{word-break:break-word}
        @media (min-width:640px){.admin-side-row{flex-direction:row;align-items:center;justify-content:space-between;gap:.75rem}}
        @media (max-width:639px){.admin-side-card{padding:1rem}.admin-side-title{font-size:1.35rem;line-height:1.2}.admin-mobile-center{align-items:center;text-align:center}.admin-mobile-full{width:100%}}
    </style>
@endpush

@section('dashboard_content')
    <section class="premium-gradient-card premium-grid-glow relative overflow-hidden rounded-[30px] p-6 sm:p-7">
        <div class="relative z-10 flex flex-col gap-6 2xl:flex-row 2xl:items-end 2xl:justify-between">
            <div class="flex items-start gap-4">
                <div class="flex h-[88px] w-[88px] items-center justify-center overflow-hidden rounded-[28px] bg-white/15 text-2xl font-semibold text-white">@if($photoUrl)<img src="{{ $photoUrl }}" alt="Photo de {{ $user->name }}" class="h-full w-full object-cover">@else{{ $initials }}@endif</div>
                <div class="max-w-3xl">
                    <p class="text-sm uppercase tracking-[0.22em] text-white/65">{{ __('admin_pages.client_profile') }}</p>
                    <h2 class="mt-3 premium-page-title text-3xl font-semibold tracking-[-0.05em] sm:text-4xl">{{ $user->name }}</h2>
                    <p class="mt-3 text-sm leading-6 text-white/80 sm:text-base">{{ __('admin_pages.edit_profile_help') }}</p>
                    <div class="mt-4 flex flex-wrap gap-2"><span class="admin-chip bg-white/14 text-white">ID #{{ $user->id }}</span><span class="admin-chip {{ $statusMeta['class'] }}"><i class="fas {{ $statusMeta['icon'] }}"></i>{{ $statusMeta['label'] }}</span><span class="admin-chip {{ $roleMeta['class'] }}"><i class="fas {{ $roleMeta['icon'] }}"></i>{{ $roleMeta['label'] }}</span></div>
                </div>
            </div>
            <div class="grid gap-3 sm:grid-cols-2 2xl:min-w-[560px]">
                <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('admin_pages.current_balance_label') }}</p><p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $balanceFormatted }}</p></div>
                <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('admin_pages.operations') }}</p><p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $user->transactions_count ?? 0 }}</p></div>
                <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('admin_pages.pending') }}</p><p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $user->pending_transactions_count ?? 0 }}</p></div>
                <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('admin_pages.member_since') }}</p><p class="mt-2 text-lg font-semibold">{{ optional($user->created_at)->format('d/m/Y') ?: 'N/A' }}</p></div>
            </div>
        </div>
    </section>

    @if(session('status'))<div class="rounded-[26px] border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">{{ session('status') }}</div>@endif
    @if($errors->any())<div class="rounded-[26px] border border-rose-200 bg-rose-50 px-5 py-4"><p class="text-sm font-semibold text-rose-800">{{ __('admin_pages.validation_errors') }}</p><ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-rose-700">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

    <form method="POST" action="{{ localized_route('admin.users.update', $user) }}" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid gap-6 2xl:grid-cols-[minmax(0,1.55fr)_380px]">
            <section class="admin-surface rounded-[30px] p-5 sm:p-6">
                <div class="border-b border-slate-200/70 pb-5"><p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('admin_pages.editing') }}</p><h3 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">{{ __('admin_pages.premium_user_record') }}</h3><p class="mt-2 text-sm leading-6 text-slate-500">{{ __('admin_pages.premium_user_record_help') }}</p></div>
                <div class="mt-6 space-y-6">
                    <section class="admin-section rounded-[24px] p-5"><h4 class="text-lg font-semibold text-slate-950">{{ __('admin_pages.personal_information') }}</h4><div class="mt-5 grid gap-4 md:grid-cols-2"><div><label for="first_name" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.first_name') }} *</label><input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" required></div><div><label for="last_name" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.last_name') }} *</label><input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" required></div><div><label for="email" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Email *</label><input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" required></div><div><label for="phone" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.phone') }}</label><input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" placeholder="+33612345678" autocomplete="tel" inputmode="tel"><p class="mt-2 text-sm text-slate-500">{{ __('admin_pages.phone_format_help') }}</p></div><div><label for="date_naissance" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.birth_date') }}</label><input type="date" name="date_naissance" id="date_naissance" value="{{ old('date_naissance', optional($user->date_of_birth)->format('Y-m-d')) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"></div><div><label for="role" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.role') }} *</label><select name="role" id="role" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" required><option value="user" @selected($role === 'user')>{{ __('admin_pages.client') }}</option><option value="admin" @selected($role === 'admin')>{{ __('admin_pages.administrator') }}</option></select></div><div class="md:col-span-2"><label for="profile_photo" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.client_photo') }}</label><input type="file" name="profile_photo" id="profile_photo" accept="image/png,image/jpeg,image/webp" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"><p class="mt-2 text-sm text-slate-500">{{ __('admin_pages.accepted_formats') }}</p></div></div></section>
                    <section class="admin-section rounded-[24px] p-5"><h4 class="text-lg font-semibold text-slate-950">{{ __('admin_pages.address_verification') }}</h4><div class="mt-5 grid gap-4 md:grid-cols-2"><div class="md:col-span-2"><label for="adresse" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.address') }}</label><input type="text" name="adresse" id="adresse" value="{{ old('adresse', $user->address) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"></div><div><label for="ville" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.city') }}</label><input type="text" name="ville" id="ville" value="{{ old('ville', $user->city) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"></div><div><label for="pays" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.country') }}</label><select name="pays" id="pays" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"><option value="">{{ __('admin_pages.select_country') }}</option>@foreach($countries as $country)<option value="{{ $country['name'] }}" @selected(old('pays', $user->country) === $country['name'])>({{ $country['code'] }}) {{ $country['name'] }}</option>@endforeach</select></div><div><label for="type_piece" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.id_type') }}</label><select name="type_piece" id="type_piece" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"><option value="">{{ __('admin_pages.select') }}</option><option value="CNI" @selected($idType === 'CNI')>{{ __('admin_pages.national_id') }}</option><option value="Passport" @selected($idType === 'Passport')>{{ __('admin_pages.passport') }}</option><option value="Permis" @selected($idType === 'Permis')>{{ __('admin_pages.driver_license') }}</option></select></div><div><label for="numero_piece" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.id_number') }}</label><input type="text" name="numero_piece" id="numero_piece" value="{{ old('numero_piece', $user->id_number) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"></div></div></section>
                    <section class="admin-section rounded-[24px] p-5"><h4 class="text-lg font-semibold text-slate-950">{{ __('admin_pages.bank_virtual_card') }}</h4><div class="mt-5 grid gap-4 md:grid-cols-2"><div><label for="iban" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">IBAN</label><input type="text" name="iban" id="iban" value="{{ old('iban', $user->iban) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"></div><div><label for="bic" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">BIC</label><input type="text" name="bic" id="bic" value="{{ old('bic', $user->bic) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"></div><div><label for="card_holder_name" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.holder') }}</label><input type="text" name="card_holder_name" id="card_holder_name" value="{{ old('card_holder_name', optional($creditCard)->card_holder_name) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"></div><div><label for="card_number" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.card_number') }}</label><input type="text" name="card_number" id="card_number" value="{{ old('card_number', optional($creditCard)->card_number) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"></div><div><label for="card_type" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.type') }}</label><input type="text" name="card_type" id="card_type" value="{{ old('card_type', optional($creditCard)->card_type) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"></div><div><label for="expiry_date" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.expiration') }}</label><input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date', optional(optional($creditCard)->expiry_date)->format('Y-m-d')) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"></div><div class="md:col-span-2"><label class="flex items-center justify-between rounded-[22px] bg-white px-4 py-4 ring-1 ring-slate-200/80"><span><span class="block text-sm font-semibold text-slate-900">{{ __('admin_pages.card_visible') }}</span><span class="mt-1 block text-sm text-slate-500">{{ __('admin_pages.card_visible_help') }}</span></span><span class="flex items-center gap-3"><input type="checkbox" name="card_visible_to_user" id="card_visible_to_user" value="1" class="peer sr-only" @checked((bool) old('card_visible_to_user', (bool) optional($creditCard)->is_visible_to_user))><span class="relative inline-flex h-6 w-11 items-center rounded-full bg-slate-300 transition peer-checked:bg-blue-700 after:h-4 after:w-4 after:translate-x-1 after:rounded-full after:bg-white after:shadow after:transition peer-checked:after:translate-x-6"></span></span></label></div></div></section>
                </div>
            </section>

            <aside class="space-y-4 sm:space-y-6">
                <section class="admin-side-card w-full rounded-[28px] p-4 sm:rounded-[30px] sm:p-5">
                    <div class="flex items-start gap-3">
                        <span class="admin-side-icon bg-sky-50 text-sky-600"><i class="fas fa-address-card"></i></span>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('admin_pages.quick_view') }}</p>
                            <h3 class="admin-side-title mt-2 premium-brand-title text-2xl font-semibold text-slate-950">{{ __('admin_pages.client_identity') }}</h3>
                        </div>
                    </div>
                    <div class="mt-5 rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                        <p class="text-sm font-semibold text-slate-900">{{ $user->name }}</p>
                        <p class="admin-side-value mt-1 text-sm text-slate-500">{{ $user->email }}</p>
                        <div class="mt-4 text-sm text-slate-600">
                            <div class="admin-side-row"><span>{{ __('admin_pages.phone') }}</span><span class="admin-side-value font-semibold text-slate-900">{{ $user->phone ?: __('admin_pages.not_provided') }}</span></div>
                            <div class="admin-side-row"><span>{{ __('admin_pages.city') }}</span><span class="admin-side-value font-semibold text-slate-900">{{ $user->city ?: 'N/A' }}</span></div>
                            <div class="admin-side-row"><span>{{ __('admin_pages.country') }}</span><span class="admin-side-value font-semibold text-slate-900">{{ $user->country ?: 'N/A' }}</span></div>
                        </div>
                    </div>
                </section>
                <section class="admin-side-card w-full rounded-[28px] p-4 sm:rounded-[30px] sm:p-5">
                    <div class="flex items-start gap-3">
                        <span class="admin-side-icon bg-emerald-50 text-emerald-600"><i class="fas fa-wallet"></i></span>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('admin_pages.account') }}</p>
                            <h3 class="admin-side-title mt-2 premium-brand-title text-2xl font-semibold text-slate-950">{{ __('admin_pages.access_balance') }}</h3>
                        </div>
                    </div>
                    <div class="mt-5 space-y-4">
                        <div>
                            <label for="status" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.status') }}</label>
                            <select name="status" id="status" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"><option value="active" @selected($status === 'active')>{{ __('admin_pages.active') }}</option><option value="suspended" @selected($status === 'suspended')>{{ __('admin_pages.suspended_status') }}</option></select>
                        </div>
                        <div class="rounded-[24px] bg-emerald-50 px-4 py-4 ring-1 ring-emerald-200/80">
                            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-emerald-700">{{ __('admin_pages.current_balance_label') }}</p>
                            <p id="liveBalanceDisplay" class="admin-side-value premium-brand-title mt-3 text-3xl font-semibold text-emerald-700">{{ $balanceFormatted }}</p>
                        </div>
                        <div>
                            <label for="balance" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.new_balance_required') }} *</label>
                            <input type="text" name="balance" id="balance" value="{{ $balanceInput }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" required>
                            <p class="mt-2 text-sm text-slate-500">{{ __('admin_pages.balance_normalized_help') }}</p>
                        </div>
                    </div>
                </section>
                <section class="admin-side-card w-full rounded-[28px] p-4 sm:rounded-[30px] sm:p-5">
                    <div class="flex items-start gap-3">
                        <span class="admin-side-icon bg-indigo-50 text-indigo-600"><i class="fas fa-bolt"></i></span>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('admin_pages.actions') }}</p>
                            <h3 class="admin-side-title mt-2 premium-brand-title text-2xl font-semibold text-slate-950">{{ __('admin_pages.validation') }}</h3>
                        </div>
                    </div>
                    <div class="mt-5 space-y-3">
                        <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-blue-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-800"><i class="fas fa-save text-xs"></i> {{ __('admin_pages.save_changes') }}</button>
                        <a href="{{ localized_route('admin.users') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"><i class="fas fa-arrow-left text-xs"></i> {{ __('admin_pages.cancel') }}</a>
                    </div>
                </section>
            </aside>
        </div>
    </form>

    <section class="admin-surface rounded-[30px] p-5 sm:p-6">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-3xl"><p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('admin_pages.admin_security') }}</p><h3 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">{{ __('admin_pages.password_reset_title') }}</h3><p class="mt-2 text-sm leading-6 text-slate-500">{{ __('admin_pages.password_reset_help') }}</p></div>
            <form method="POST" action="{{ localized_route('admin.users.reset-password', $user) }}" class="w-full lg:w-auto">@csrf<button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-rose-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-rose-900/20 transition hover:bg-rose-700 lg:w-auto" onclick="return confirm(@js(__('admin_pages.password_reset_confirm')))"><i class="fas fa-key text-xs"></i> {{ __('admin_pages.reset_password') }}</button></form>
        </div>
    </section>
@endsection

@push('premium_dashboard_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const balanceInput = document.getElementById('balance');
            const balanceDisplay = document.getElementById('liveBalanceDisplay');
            const currencyCode = @json($user->default_currency ?? 'EUR');

            function updateBalancePreview() {
                if (!balanceInput || !balanceDisplay) return;
                const raw = balanceInput.value.replace(/\s+/g, '').replace(',', '.');
                const numeric = Number.parseFloat(raw);
                if (Number.isNaN(numeric)) return;
                balanceDisplay.textContent = new Intl.NumberFormat('fr-FR', { style: 'currency', currency: currencyCode, minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(numeric);
            }

            balanceInput?.addEventListener('input', updateBalancePreview);
            balanceInput?.addEventListener('blur', function () {
                const raw = this.value.replace(/\s+/g, '').replace(',', '.');
                const numeric = Number.parseFloat(raw);
                if (!Number.isNaN(numeric)) {
                    this.value = numeric.toFixed(2).replace('.', ',');
                    updateBalancePreview();
                }
            });
        });
    </script>
@endpush
