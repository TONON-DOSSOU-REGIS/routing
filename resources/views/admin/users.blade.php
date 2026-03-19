@extends('layouts.admin-premium')

@section('title', 'Utilisateurs - Valtrix Bank Admin')
@section('admin_nav_active', 'users')
@section('dashboard_page_title', 'Gestion des utilisateurs')
@section('dashboard_page_subtitle', 'Supervisez les comptes, les roles, les statuts et les actions d administration depuis une vue premium unifiee.')
@section('dashboard_section_label', 'User control')

@section('dashboard_header_actions')
    <a href="{{ localized_route('admin.users.create') }}" class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-800">
        <i class="fas fa-user-plus text-xs"></i>
        Ajouter un utilisateur
    </a>
    <a href="{{ localized_route('admin.deposit') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
        <i class="fas fa-plus-circle text-xs"></i>
        Depot
    </a>
@endsection

@push('premium_dashboard_head')
    <style>
        .admin-field { background: rgba(248, 250, 252, 0.9); border: 1px solid rgba(148, 163, 184, 0.24); box-shadow: inset 0 1px 0 rgba(255,255,255,0.72); transition: border-color .18s, box-shadow .18s, background-color .18s; }
        .admin-field:focus { background: rgba(255,255,255,.98); border-color: rgba(21, 94, 239, 0.36); box-shadow: 0 0 0 4px rgba(21, 94, 239, 0.08); outline: none; }
        .admin-surface { border: 1px solid rgba(148,163,184,.18); background: linear-gradient(180deg, rgba(255,255,255,.94), rgba(248,250,252,.88)); box-shadow: 0 18px 36px rgba(15,23,42,.06); }
        .admin-row { transition: background-color .18s ease; }
        .admin-row:hover { background: rgba(248, 250, 252, 0.95); }
    </style>
@endpush

@section('dashboard_content')
    <section class="premium-gradient-card premium-grid-glow relative overflow-hidden rounded-[30px] p-6 sm:p-7">
        <div class="relative z-10 grid gap-3 sm:grid-cols-2 2xl:grid-cols-4">
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">Total utilisateurs</p><p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $totalUsers }}</p></div>
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">Actifs</p><p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $activeUsers }}</p></div>
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">Pending</p><p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $pendingUsersCount }}</p></div>
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">Suspendus</p><p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $suspendedUsersCount }}</p></div>
        </div>
    </section>

    @if(session('status'))
        <div class="rounded-[26px] border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="rounded-[26px] border border-rose-200 bg-rose-50 px-5 py-4">
            <p class="text-sm font-semibold text-rose-800">Action impossible</p>
            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-rose-700">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    @if(session('login_link'))
        <div class="rounded-[26px] border border-blue-200 bg-blue-50 px-5 py-4">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-semibold text-blue-900">Lien de connexion genere</p>
                    <p class="mt-1 text-sm text-blue-700">Client : {{ session('login_link_user') }} @if(session('login_link_expires_at')) - Valide jusqu au {{ session('login_link_expires_at') }} @endif</p>
                </div>
                <a href="{{ session('login_link') }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-blue-700 shadow-sm ring-1 ring-blue-200/80">
                    <i class="fas fa-arrow-up-right-from-square text-xs"></i> Ouvrir
                </a>
            </div>
            <div class="mt-3 flex flex-col gap-2 sm:flex-row">
                <input id="login-link-input" type="text" readonly value="{{ session('login_link') }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700">
                <button type="button" data-copy-target="login-link-input" class="inline-flex items-center justify-center gap-2 rounded-full bg-blue-700 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-800"><i class="fas fa-copy text-xs"></i> Copier</button>
            </div>
        </div>
    @endif

    <section class="admin-surface rounded-[30px] p-5 sm:p-6">
        <div class="flex flex-col gap-4 border-b border-slate-200/70 pb-5 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Exploration</p>
                <h2 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">Comptes clients et admins</h2>
                <p class="mt-2 text-sm leading-6 text-slate-500">{{ $users->total() }} resultat(s) pour la vue courante.</p>
            </div>

            <form method="GET" class="grid gap-3 md:grid-cols-[minmax(220px,1.5fr)_180px_180px]">
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nom, email, telephone..." class="admin-field rounded-2xl px-4 py-3 text-sm text-slate-700">
                <select name="role" id="role" class="admin-field rounded-2xl px-4 py-3 text-sm text-slate-700">
                    <option value="">Tous les roles</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Client</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                </select>
                <select name="status" id="status" class="admin-field rounded-2xl px-4 py-3 text-sm text-slate-700">
                    <option value="">Tous les statuts</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspendu</option>
                </select>
            </form>
        </div>

        <div class="mt-6 overflow-hidden rounded-[24px] border border-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-[980px] w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50/90">
                        <tr>
                            <th class="px-4 py-4 text-left font-semibold uppercase tracking-[0.16em] text-slate-400">Utilisateur</th>
                            <th class="px-4 py-4 text-left font-semibold uppercase tracking-[0.16em] text-slate-400">Contact</th>
                            <th class="px-4 py-4 text-left font-semibold uppercase tracking-[0.16em] text-slate-400">Role</th>
                            <th class="px-4 py-4 text-left font-semibold uppercase tracking-[0.16em] text-slate-400">Solde</th>
                            <th class="px-4 py-4 text-left font-semibold uppercase tracking-[0.16em] text-slate-400">Statut</th>
                            <th class="px-4 py-4 text-left font-semibold uppercase tracking-[0.16em] text-slate-400">Inscription</th>
                            <th class="px-4 py-4 text-left font-semibold uppercase tracking-[0.16em] text-slate-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse($users as $user)
                            <tr class="admin-row">
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-11 w-11 items-center justify-center overflow-hidden rounded-2xl bg-blue-100 font-semibold text-blue-700">
                                            @if($user->profile_photo_url)
                                                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->first_name }}" class="h-full w-full object-cover">
                                            @else
                                                {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-semibold text-slate-900">{{ $user->first_name }} {{ $user->last_name }}</p>
                                            <p class="text-xs uppercase tracking-[0.16em] text-slate-400">ID {{ $user->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="font-medium text-slate-900">{{ $user->email }}</p>
                                    <p class="mt-1 text-sm text-slate-500">{{ $user->phone ?: 'Non renseigne' }}</p>
                                </td>
                                <td class="px-4 py-4"><span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $user->role === 'admin' ? 'bg-violet-50 text-violet-700 ring-1 ring-violet-200/80' : 'bg-blue-50 text-blue-700 ring-1 ring-blue-200/80' }}"><i class="fas fa-{{ $user->role === 'admin' ? 'crown' : 'user' }} text-[11px]"></i>{{ ucfirst($user->role) }}</span></td>
                                <td class="px-4 py-4 font-semibold text-slate-900">{{ number_format($user->balance, 2, ',', ' ') }} EUR</td>
                                <td class="px-4 py-4">
                                    @php
                                        $statusClass = match ($user->status) {
                                            'active' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/80',
                                            'pending' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200/80',
                                            default => 'bg-rose-50 text-rose-700 ring-1 ring-rose-200/80',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}"><i class="fas fa-circle text-[8px]"></i>{{ ucfirst($user->status) }}</span>
                                </td>
                                <td class="px-4 py-4 text-slate-600">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ localized_route('admin.users.edit', $user) }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"><i class="fas fa-edit text-[11px]"></i> Editer</a>
                                        @if($user->role === 'user' && $user->status === 'active')
                                            <form method="POST" action="{{ localized_route('admin.users.login-link', $user) }}" class="inline">@csrf<button type="submit" class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 ring-1 ring-blue-200/80"><i class="fas fa-link text-[11px]"></i> Lien</button></form>
                                        @endif
                                        @if($user->status === 'pending' && $user->id !== auth()->id())
                                            <form method="POST" action="{{ localized_route('admin.users.approve', $user) }}" class="inline">@csrf<button type="submit" class="inline-flex items-center gap-2 rounded-full bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700 ring-1 ring-amber-200/80" onclick="return confirm('Valider cet utilisateur ?')"><i class="fas fa-check text-[11px]"></i> Valider</button></form>
                                        @endif
                                        @if($user->id !== auth()->id() && $user->status !== 'pending')
                                            <form method="POST" action="{{ localized_route('admin.users.toggle', $user) }}" class="inline">@csrf<button type="submit" class="inline-flex items-center gap-2 rounded-full px-3 py-2 text-xs font-semibold {{ $user->status === 'active' ? 'bg-rose-50 text-rose-700 ring-1 ring-rose-200/80' : 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/80' }}" onclick="return confirm('Confirmer ce changement de statut ?')"><i class="fas fa-{{ $user->status === 'active' ? 'ban' : 'check' }} text-[11px]"></i>{{ $user->status === 'active' ? 'Suspendre' : 'Activer' }}</button></form>
                                        @endif
                                        @if($user->status !== 'pending')
                                            <form method="POST" action="{{ localized_route('admin.users.delete', $user) }}" class="inline">@csrf @method('DELETE')<button type="submit" class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-3 py-2 text-xs font-semibold text-white shadow-sm" onclick="return confirm('Supprimer cet utilisateur ? Cette action est irreversible.')"><i class="fas fa-trash text-[11px]"></i> Supprimer</button></form>
                                        @endif
                                        @if($user->id === auth()->id())
                                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-500"><i class="fas fa-user-circle text-[11px]"></i> Vous</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-5 py-12 text-center"><p class="text-lg font-semibold text-slate-900">Aucun utilisateur trouve</p><p class="mt-2 text-sm text-slate-500">Aucun compte ne correspond aux filtres actifs.</p></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($users->hasPages())
            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-slate-500">Affichage de {{ $users->firstItem() }} a {{ $users->lastItem() }} sur {{ $users->total() }} utilisateurs</p>
                <div>{{ $users->links('vendor.pagination.tailwind') }}</div>
            </div>
        @endif
    </section>
@endsection

@push('premium_dashboard_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-copy-target]').forEach((button) => {
                button.addEventListener('click', async function () {
                    const input = document.getElementById(button.getAttribute('data-copy-target'));
                    if (!input) return;
                    const original = button.innerHTML;

                    try {
                        if (navigator.clipboard && window.isSecureContext) {
                            await navigator.clipboard.writeText(input.value);
                        } else {
                            input.select();
                            document.execCommand('copy');
                            window.getSelection().removeAllRanges();
                        }

                        button.innerHTML = '<i class="fas fa-check text-xs"></i> Copie';
                    } catch (error) {
                        button.innerHTML = '<i class="fas fa-triangle-exclamation text-xs"></i> Erreur';
                    }

                    setTimeout(() => { button.innerHTML = original; }, 2000);
                });
            });

            document.getElementById('role')?.addEventListener('change', function () { this.form.submit(); });
            document.getElementById('status')?.addEventListener('change', function () { this.form.submit(); });

            let searchTimeout;
            document.getElementById('search')?.addEventListener('input', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => this.form.submit(), 500);
            });
        });
    </script>
@endpush
