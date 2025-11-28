# TODO - Implémentation de la Devise Uniforme

## Objectif
Assurer que la devise choisie par l'admin lors du dépôt (EUR, PLN, USD, etc.) soit affichée de manière cohérente dans toutes les vues de l'application.

## État Actuel
- ✅ Champ `default_currency` existe dans la table `users`
- ✅ AdminController met à jour `default_currency` lors des dépôts
- ✅ User model a des méthodes helper pour la devise
- ✅ CurrencyHelper amélioré avec nouvelles méthodes

## Plan d'Implémentation

### Étape 1: Améliorer CurrencyHelper ✅
- ✅ Ajouter méthode `formatForUser(User $user, $amount)`
- ✅ Ajouter méthode `formatCents($amount, $currency)`
- ✅ Ajouter méthode `formatCentsForUser(User $user, $amount)`
- ✅ Ajouter plus de devises (TRY, NZD, TWD, VND, etc.)

### Étape 2: Mettre à jour les vues utilisateur
- ✅ `resources/views/dashboard/index.blade.php` - Solde et transactions
- ✅ `resources/views/transactions/history.blade.php` - Montants des transactions
- [ ] `resources/views/profile/index.blade.php`
- [ ] `resources/views/transactions/receipt.blade.php`
- [ ] `resources/views/transactions/create.blade.php`

### Étape 3: Mettre à jour les vues admin
- [ ] `resources/views/admin/users.blade.php`
- [ ] `resources/views/admin/users/edit.blade.php`
- ✅ `resources/views/admin/transactions.blade.php` - Tableau et modal de remboursement
- [ ] `resources/views/admin/deposit.blade.php`
- [ ] `resources/views/admin/exports/transactions_pdf.blade.php`

### Étape 4: Mettre à jour les emails
- [ ] `resources/views/emails/transaction_refunded.blade.php`
- [ ] `resources/views/emails/transfer_confirmation.blade.php`

### Étape 5: Tests
- [ ] Tester avec EUR
- [ ] Tester avec PLN
- [ ] Tester avec USD
- [ ] Vérifier les emails
- [ ] Vérifier les exports PDF

## Fichiers Modifiés
1. ✅ `app/Helpers/CurrencyHelper.php` - Ajout de méthodes helper
2. ✅ `resources/views/dashboard/index.blade.php` - Utilisation de CurrencyHelper (corrigé bug 200 zł → 20 000 zł)
3. ✅ `resources/views/transactions/history.blade.php` - Utilisation de CurrencyHelper
4. ✅ `resources/views/admin/transactions.blade.php` - Tableau et modal de remboursement avec devise

## Notes Techniques
- Utiliser `CurrencyHelper::format($amount, $currency)` pour les montants normaux
- Utiliser `CurrencyHelper::formatCents($amount, $currency)` pour les montants en centimes
- Utiliser `CurrencyHelper::formatForUser($user, $amount)` pour formater avec la devise de l'utilisateur
- La devise par défaut est EUR si `default_currency` est null
- Les montants en base de données sont stockés en centimes (multiplier par 100)

## Prochaines Étapes
1. Continuer avec profile/index.blade.php
2. Mettre à jour transactions/receipt.blade.php
3. Mettre à jour les vues admin
4. Mettre à jour les emails
5. Tester l'ensemble du système

