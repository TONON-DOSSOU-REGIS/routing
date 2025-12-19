# TODO - Traduction des vues d'authentification

## Progression

### Étape 1: Création des fichiers de traduction auth.php
- [x] `lang/en/auth.php` - Complété ✓
- [x] `lang/fr/auth.php` - Créé ✓
- [x] `lang/de/auth.php` - Créé ✓
- [x] `lang/nl/auth.php` - Créé ✓
- [x] `lang/es/auth.php` - Créé ✓
- [x] `lang/it/auth.php` - Créé ✓
- [x] `lang/pl/auth.php` - Créé ✓

### Étape 2: Modification de login.blade.php
- [x] Remplacer les textes en dur par `{{ __('auth.key') }}` ✓
- [x] Ajouter le sélecteur de langue ✓
- [x] Utiliser `app()->getLocale()` pour l'attribut lang ✓

### Étape 3: Modification de register.blade.php
- [x] Remplacer les textes en dur par `{{ __('auth.key') }}` ✓
- [x] Ajouter le sélecteur de langue ✓
- [x] Utiliser `app()->getLocale()` pour l'attribut lang ✓
- [x] Traduire tous les 43 pays ✓

### Étape 4: Tests
- [ ] Tester le changement de langue sur login
- [ ] Tester le changement de langue sur register
- [ ] Vérifier les formulaires dans toutes les langues
- [ ] Vérifier l'affichage mobile

## Notes
- Suivre le même pattern que home.blade.php
- Utiliser le composant language-selector existant
- Garder la cohérence avec les autres traductions
