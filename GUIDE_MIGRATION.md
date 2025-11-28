# 🚀 GUIDE DE MIGRATION - SG BANK

## Étapes pour Mettre à Jour la Base de Données

### 1. Vérifier l'État Actuel
```bash
php artisan migrate:status
```

### 2. Exécuter les Migrations
```bash
# Exécuter toutes les migrations en attente
php artisan migrate

# Si vous voulez tout réinitialiser (ATTENTION: Supprime toutes les données!)
php artisan migrate:fresh

# Avec les seeders
php artisan migrate:fresh --seed
```

### 3. Migrations Importantes à Vérifier

#### ✅ Table Notifications (Nouvelle)
```
2025_11_25_112432_create_notifications_table.php
```
**Colonnes:**
- id, user_id, type, title, message
- icon, color, action_url
- is_read, read_at
- timestamps

#### ✅ Table Chat Messages (Avec Attachments)
```
2025_11_28_000000_create_chat_messages_table.php
2025_11_25_105912_add_attachments_to_chat_messages_table.php
```

#### ✅ Table Users (Avec Toutes les Colonnes)
```
- status (enum: active, suspended, pending)
- activation_code
- default_currency
- country
```

### 4. Vérifier les Relations

```bash
# Tester dans tinker
php artisan tinker

# Vérifier les relations
$user = User::first();
$user->notifications;
$user->unreadNotifications();
$user->transactions;
$user->creditCard;
```

### 5. Créer un Utilisateur Admin

```bash
php artisan tinker

# Créer l'admin
User::create([
    'first_name' => 'Admin',
    'last_name' => 'SG BANK',
    'email' => 'admin@SG BANK.com',
    'password' => Hash::make('admin123'),
    'role' => 'admin',
    'status' => 'active',
    'balance' => 10000.00,
    'default_currency' => 'EUR'
]);
```

### 6. Créer des Notifications de Test

```bash
php artisan tinker

use App\Services\NotificationService;
use App\Models\User;

$user = User::find(1);

# Notification de bienvenue
NotificationService::notifyWelcome($user);

# Notification système
NotificationService::notifySystem($user, 'Test', 'Ceci est un test', 'blue');
```

### 7. Tester les Endpoints API

```bash
# Dans le navigateur ou Postman

# Analytics
GET http://localhost:8000/api/analytics/balance-evolution?period=30
GET http://localhost:8000/api/analytics/transactions-by-type?period=30
GET http://localhost:8000/api/analytics/monthly-comparison
GET http://localhost:8000/api/analytics/statistics

# Notifications
GET http://localhost:8000/notifications
GET http://localhost:8000/notifications/unread-count
GET http://localhost:8000/notifications/recent
POST http://localhost:8000/notifications/test
```

### 8. Vérifier le Dashboard

```bash
# Démarrer le serveur
php artisan serve

# Ouvrir dans le navigateur
http://localhost:8000/login

# Se connecter avec:
Email: admin@SG BANK.com
Password: admin123
```

### 9. Problèmes Courants

#### Erreur: "Table already exists"
```bash
# Supprimer la table problématique
php artisan tinker
DB::statement('DROP TABLE IF EXISTS notifications');
exit

# Relancer la migration
php artisan migrate
```

#### Erreur: "Column not found"
```bash
# Vérifier la structure
php artisan tinker
Schema::hasTable('notifications');
Schema::hasColumn('notifications', 'is_read');
```

#### Erreur: "Class not found"
```bash
# Régénérer l'autoload
composer dump-autoload

# Vider le cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### 10. Commandes Utiles

```bash
# Voir toutes les routes
php artisan route:list

# Voir les routes notifications
php artisan route:list | grep notification

# Voir les routes analytics
php artisan route:list | grep analytics

# Tester une route
php artisan route:list --path=notifications

# Vérifier la configuration
php artisan config:show database

# Optimiser l'application
php artisan optimize
```

---

## ✅ Checklist de Vérification

- [ ] Migrations exécutées sans erreur
- [ ] Table `notifications` créée
- [ ] Relations User ↔ Notifications fonctionnent
- [ ] Admin créé et peut se connecter
- [ ] Dashboard s'affiche correctement
- [ ] Graphiques analytics chargent
- [ ] Badge de notifications visible
- [ ] Chat widget fonctionne
- [ ] Endpoints API répondent
- [ ] Pas d'erreurs dans les logs

---

## 🎯 Prochaines Étapes

Une fois toutes les migrations effectuées:

1. **Tester les Notifications**
   - Créer des notifications de test
   - Vérifier le badge
   - Tester le dropdown

2. **Tester les Analytics**
   - Créer des transactions
   - Vérifier les graphiques
   - Tester les différentes périodes

3. **Compléter l'Intégration**
   - Intégrer NotificationService dans les contrôleurs
   - Créer le centre de notifications
   - Tester le flux complet

---

**📞 Besoin d'Aide?**

Si vous rencontrez des problèmes:
1. Vérifiez les logs: `storage/logs/laravel.log`
2. Activez le mode debug: `.env` → `APP_DEBUG=true`
3. Consultez la documentation Laravel

**Bon déploiement! 🚀**

