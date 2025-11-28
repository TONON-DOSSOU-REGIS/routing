# Restauration Auth + Tableau de bord (Plan approuvé)

Cette TODO suit le plan validé pour corriger les vues de connexion/inscription, restaurer le tableau de bord utilisateur et fiabiliser les migrations.

Statut des tâches:
- [ ] 1) Routes (routes/web.php)
  - [ ] Corriger le bloc guest corrompu (POST /register -> AuthController@register)
  - [ ] Ajouter la route utilisateur /dashboard (middleware: auth) -> DashboardController@index (name: dashboard)
  - [ ] S'assurer que les routes de notifications ne sont pas dans le bloc guest
- [ ] 2) Contrôleur d'authentification (app/Http/Controllers/AuthController.php)
  - [ ] login(): après Auth::attempt et status=active, redirection vers admin.dashboard si admin sinon dashboard. Supprimer fragments NaN
  - [ ] register(): corriger règles de validation corrompues, création utilisateur, notifications, redirect /login avec message
- [ ] 3) Vues
  - [ ] resources/views/auth/login.blade.php: corriger liens cassés/fragments NaN, vérifier formulaire (@csrf, erreurs)
  - [ ] resources/views/auth/register.blade.php: corriger si corrompu (form, @csrf, erreurs)
  - [ ] resources/views/dashboard/index.blade.php: remplacer contenu minimal par une page HTML complète (Tailwind/Chart.js/Alpine.js) incluant:
    - Nav + @include('components.notification-bell')
    - @include('components.analytics-section')
    - @include('components.market-tracker-fixed') (rafraîchissement 5s)
    - Transactions récentes et actions rapides
- [ ] 4) Migrations et cache
  - [x] Patcher down(): id_number (ok), date_of_birth (ok), city (ok), phone (ok)
  - [ ] Relancer php artisan migrate:refresh
  - [ ] php artisan optimize:clear
- [ ] 5) Tests rapides
  - [ ] /login et /register s'affichent et fonctionnent (erreurs affichées, @csrf)
  - [ ] Connexion: utilisateur -> /dashboard; admin -> /admin/dashboard
  - [ ] Cloche notifications: compteur + son professionnel sur nouvel évènement
  - [ ] Market tracker: mises à jour visibles toutes les 5s (timestamp "Mis à jour: hh:mm:ss")

Notes:
- Les migrations down() ont été rendues idempotentes (remplissage de NULL avant NOT NULL, et drop FK/colonnes avec garde).
- Après la restauration des fichiers et routes, un `php artisan optimize:clear` sera lancé pour purger les caches.
- Si besoin de données de test, utiliser les scripts `create_admin.php` / `check_admin.php` après migrations.

