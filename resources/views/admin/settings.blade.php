@extends('layouts.admin-premium')

@php
    $targetUser = collect($users)->firstWhere('id', old('target_user_id', $settings->target_user_id ?? null));
    $stopPercentage = old('stop_percentage', $settings->stop_percentage ?? 70);
    $stopMessage = old('stop_message', $settings->stop_message ?? 'Transaction suspendue pour verification de sécurité.');
    $isGlobal = (bool) old('is_global', $settings->is_global ?? true);
@endphp

@section('title', 'Paramètres admin - Zuider Bank S.A')
@section('admin_nav_active', 'settings')
@section('dashboard_page_title', 'Paramètres des virements')
@section('dashboard_page_subtitle', 'Reglez les seuils d arret, la portee de la regle et le message envoye au client dans un environnement premium.')
@section('dashboard_section_label', 'Paramètres système')

@section('dashboard_header_actions')
    <a href="{{ localized_route('admin.deposit') }}" class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-800">
        <i class="fas fa-plus-circle text-xs"></i>
        Nouveau dépôt
    </a>
    <a href="{{ localized_route('admin.users') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
        <i class="fas fa-users text-xs"></i>
        Utilisateurs
    </a>
@endsection

@push('premium_dashboard_head')
    <style>
        .admin-field { background: rgba(248, 250, 252, 0.9); border: 1px solid rgba(148, 163, 184, 0.24); box-shadow: inset 0 1px 0 rgba(255,255,255,0.72); transition: border-color .18s, box-shadow .18s, background-color .18s; }
        .admin-field:focus { background: rgba(255,255,255,.98); border-color: rgba(21, 94, 239, 0.36); box-shadow: 0 0 0 4px rgba(21, 94, 239, 0.08); outline: none; }
        .admin-surface { border: 1px solid rgba(148,163,184,.18); background: linear-gradient(180deg, rgba(255,255,255,.94), rgba(248,250,252,.88)); box-shadow: 0 18px 36px rgba(15,23,42,.06); }
        .emoji-btn { display: inline-flex; align-items: center; gap: .45rem; border-radius: 9999px; border: 1px solid rgba(14,116,144,.25); background: linear-gradient(135deg, rgba(236,254,255,.9), rgba(224,242,254,.9)); color: #0f766e; font-weight: 700; font-size: .75rem; padding: .45rem .75rem; transition: all .25s ease; }
        .emoji-btn:hover { transform: translateY(-1px); box-shadow: 0 10px 20px rgba(15,23,42,.12); }
        .emoji-picker__wrapper, .emoji-picker { z-index: 25000 !important; }
    </style>
@endpush

@section('dashboard_content')
    <section class="premium-gradient-card premium-grid-glow relative overflow-hidden rounded-[30px] p-6 sm:p-7">
        <div class="relative z-10 grid gap-3 sm:grid-cols-2 2xl:grid-cols-4">
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">Stop actuel</p><p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $stopPercentage }}%</p></div>
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">Portée</p><p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $isGlobal ? 'Globale' : 'Spécifique' }}</p></div>
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">Client cible</p><p class="mt-2 text-lg font-semibold">{{ $targetUser ? $targetUser->first_name . ' ' . $targetUser->last_name : 'Tous les clients' }}</p></div>
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">Files à traiter</p><p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $pendingTransactionsCount }}</p></div>
        </div>
    </section>

    @if(session('status'))
        <div class="rounded-[26px] border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="rounded-[26px] border border-rose-200 bg-rose-50 px-5 py-4">
            <p class="text-sm font-semibold text-rose-800">Erreurs de validation</p>
            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-rose-700">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="grid gap-6 2xl:grid-cols-[minmax(0,1.55fr)_380px]">
        <section class="admin-surface rounded-[30px] p-5 sm:p-6">
            <div class="border-b border-slate-200/70 pb-5">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Configuration</p>
                <h2 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">Règle d'arrêt des virements</h2>
                <p class="mt-2 text-sm leading-6 text-slate-500">Ajustez le seuil, la cible et le message affiché lors d'une suspension.</p>
            </div>

            <form method="POST" action="{{ localized_route('admin.settings.save') }}" class="mt-6 space-y-6">
                @csrf
                <div>
                    <label for="stop_percentage" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Pourcentage d'arrêt</label>
                    <input type="number" name="stop_percentage" id="stop_percentage" min="0" max="100" value="{{ $stopPercentage }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" required>
                    <div class="mt-3 flex items-center justify-between text-sm text-slate-500"><span>0%</span><span id="percentage-value" class="font-semibold text-slate-900">{{ $stopPercentage }}%</span><span>100%</span></div>
                    <div class="mt-2 h-2 rounded-full bg-slate-200"><div id="percentage-bar" class="h-2 rounded-full bg-blue-700" style="width: {{ $stopPercentage }}%"></div></div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <label class="rounded-[24px] border px-4 py-4 {{ $isGlobal ? 'border-blue-300 bg-blue-50' : 'border-slate-200 bg-white' }}">
                        <input type="radio" name="is_global" value="1" {{ $isGlobal ? 'checked' : '' }} class="sr-only">
                        <p class="text-sm font-semibold text-slate-900">Globale</p>
                        <p class="mt-1 text-sm text-slate-500">La règle s'applique à tous les clients.</p>
                    </label>
                    <label class="rounded-[24px] border px-4 py-4 {{ !$isGlobal ? 'border-blue-300 bg-blue-50' : 'border-slate-200 bg-white' }}">
                        <input type="radio" name="is_global" value="0" {{ !$isGlobal ? 'checked' : '' }} class="sr-only">
                        <p class="text-sm font-semibold text-slate-900">Spécifique</p>
                        <p class="mt-1 text-sm text-slate-500">La règle cible un client précis.</p>
                    </label>
                </div>

                <div id="target_user_container" class="{{ $isGlobal ? 'hidden' : '' }}">
                    <label for="target_user_id" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Client cible</label>
                    <select name="target_user_id" id="target_user_id" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700">
                        <option value="">Choisir un client...</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('target_user_id', $settings->target_user_id ?? '') == $user->id ? 'selected' : '' }}>{{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <div class="mb-2 flex items-center justify-between gap-3">
                        <label for="stop_message" class="block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Message de suspension</label>
                        <button type="button" id="emoji-picker-button" class="emoji-btn"><i class="fa-regular fa-face-smile"></i> Emojis premium</button>
                    </div>
                    <textarea name="stop_message" id="stop_message" rows="4" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" required>{{ $stopMessage }}</textarea>
                    <p class="mt-2 text-sm text-slate-500">Ce message sera affiché au client lors de la mise en attente du virement.</p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <a href="{{ localized_route('admin.dashboard') }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"><i class="fas fa-arrow-left text-xs"></i> Retour</a>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-blue-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-800"><i class="fas fa-save text-xs"></i> Enregistrer</button>
                </div>
            </form>
        </section>

        <aside class="space-y-6">
            <section class="admin-surface rounded-[30px] p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Simulation</p>
                <h3 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">Aperçu client</h3>
                <div class="mt-5 rounded-[24px] bg-amber-50 px-4 py-4 ring-1 ring-amber-200/80">
                    <p class="text-sm font-semibold text-amber-900">Transaction suspendue</p>
                    <p id="preview-message" class="mt-2 text-sm leading-6 text-amber-700">{{ $stopMessage }}</p>
                    <p class="mt-3 text-sm text-amber-800">Le virement s'arrêtera à <span id="preview-percentage" class="font-semibold">{{ $stopPercentage }}%</span>.</p>
                </div>
            </section>

            <section class="admin-surface rounded-[30px] p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Sécurité admin</p>
                <h3 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">Mot de passe</h3>
                <form method="POST" action="{{ localized_route('admin.password.update') }}" class="mt-5 space-y-4">
                    @csrf
                    <div><label for="current_password" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Mot de passe actuel</label><input type="password" id="current_password" name="current_password" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" autocomplete="current-password" required></div>
                    <div><label for="new_password" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Nouveau mot de passe</label><input type="password" id="new_password" name="new_password" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" autocomplete="new-password" required></div>
                    <div><label for="new_password_confirmation" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Confirmation</label><input type="password" id="new_password_confirmation" name="new_password_confirmation" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" autocomplete="new-password" required></div>
                    <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/20 transition hover:bg-slate-800"><i class="fas fa-shield-alt text-xs"></i> Mettre à jour</button>
                </form>
            </section>
        </aside>
    </div>
@endsection

@push('premium_dashboard_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stopPercentage = document.getElementById('stop_percentage');
            const percentageValue = document.getElementById('percentage-value');
            const percentageBar = document.getElementById('percentage-bar');
            const previewPercentage = document.getElementById('preview-percentage');
            const stopMessage = document.getElementById('stop_message');
            const previewMessage = document.getElementById('preview-message');
            const targetUserContainer = document.getElementById('target_user_container');
            const emojiButton = document.getElementById('emoji-picker-button');
            let picker = null;

            stopPercentage?.addEventListener('input', function () {
                const value = Math.max(0, Math.min(100, Number(this.value || 0)));
                percentageValue.textContent = `${value}%`;
                previewPercentage.textContent = `${value}%`;
                percentageBar.style.width = `${value}%`;
            });

            stopMessage?.addEventListener('input', function () {
                previewMessage.textContent = this.value || 'Transaction suspendue pour verification de sécurité.';
            });

            document.querySelectorAll('input[name="is_global"]').forEach((radio) => {
                radio.addEventListener('change', function () {
                    targetUserContainer.classList.toggle('hidden', this.value === '1');
                });
            });

            const insertAtCursor = (input, value) => {
                const start = input.selectionStart || input.value.length;
                const end = input.selectionEnd || input.value.length;
                input.setRangeText(value, start, end, 'end');
                input.dispatchEvent(new Event('input', { bubbles: true }));
                input.focus();
            };

            emojiButton?.addEventListener('click', async function () {
                try {
                    if (!picker) {
                        const module = await import('https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@4.6.4/dist/index.min.js');
                        const EmojiButton = module.EmojiButton || module.default || module;
                        picker = new EmojiButton({ position: 'bottom-start', zIndex: 25001 });
                        picker.on('emoji', (selection) => insertAtCursor(stopMessage, selection.emoji));
                    }

                    picker.togglePicker(emojiButton);
                } catch (error) {
                    emojiButton.disabled = true;
                    emojiButton.classList.add('opacity-60', 'cursor-not-allowed');
                }
            });
        });
    </script>
@endpush
