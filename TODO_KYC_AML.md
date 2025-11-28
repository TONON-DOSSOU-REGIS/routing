# ✅ Plan d’Implémentation KYC &amp; Sanctions (AML) — SG BANK

Objectif: Mettre en place un flux complet de vérification d’identité (KYC) et de screening de sanctions (AML) avec documents, workflow d’approbation admin, et enforcement sur les actions sensibles (virements, retraits, etc.).

Statut: Phase 1 — Migrations BD

----

## 0) Pré-requis et conventions
- Laravel 11, PHP 8.x
- Stockage privé pour documents: storage/app/kyc/{user_id}/
- Nommage tables:
  - kyc_verifications
  - kyc_documents
  - aml_screenings
  - sanctions_hits
- Champs utilisateurs additionnels:
  - kyc_status: enum [not_started, pending, in_review, approved, rejected, expired]
  - kyc_risk_score: decimal(5,2)
  - kyc_last_screened_at: timestamp nullable
  - kyc_pep_flag: boolean default false

----

## 1) Migrations Base de Données

[x] 1.1 — Migration: ajouter colonnes KYC à users
- users.kyc_status (enum: not_started, pending, in_review, approved, rejected, expired) default: not_started
- users.kyc_risk_score (decimal 5,2) nullable
- users.kyc_last_screened_at (timestamp) nullable
- users.kyc_pep_flag (boolean) default false
- Index utile: (kyc_status), (kyc_pep_flag)

[x] 1.2 — Table: kyc_verifications
- id, user_id (FK), status (pending, in_review, approved, rejected, expired)
- provider (string), reference (string nullable)
- risk_score (decimal 5,2 nullable), pep_flag (bool default false)
- pep_details (json nullable), rejection_reason (text nullable)
- submitted_at (timestamp), reviewed_at (timestamp nullable), reviewed_by (FK user admin nullable)
- timestamps + indexes (user_id, status)

[x] 1.3 — Table: kyc_documents
- id, kyc_verification_id (FK), type (enum: id_front, id_back, selfie, proof_of_address)
- path (string), mime_type (string), size (bigInteger), checksum (string)
- extracted_data (json nullable)
- verified (boolean default false), verified_at (timestamp nullable)
- timestamps + indexes (kyc_verification_id, type)

[x] 1.4 — Table: aml_screenings
- id, user_id (FK), provider (string)
- query (json), status (enum: clear, potential_match, match)
- score (decimal 5,2 nullable), result (json)
- screened_at (timestamp), rescreen_after (timestamp nullable), last_rescreened_at (timestamp nullable)
- timestamps + indexes (user_id, status, screened_at)

[x] 1.5 — Table: sanctions_hits
- id, aml_screening_id (FK)
- list_name (OFAC, UN, EU, HMT, etc.), entity_name (string), dob (date nullable), country (string nullable)
- score (decimal 5,2 nullable)
- raw (json)
- timestamps + indexes (aml_screening_id, list_name, score)

Commande:
- php artisan migrate

----

## 2) Modèles &amp; Relations

[x] 2.1 — Models:
- App\Models\KycVerification
- App\Models\KycDocument
- App\Models\AmlScreening
- App\Models\SanctionsHit

[x] 2.2 — Relations:
- User hasMany KycVerification, hasMany AmlScreening
- KycVerification hasMany KycDocument, belongsTo User
- AmlScreening hasMany SanctionsHit, belongsTo User
- SanctionsHit belongsTo AmlScreening

[x] 2.3 — User fillable + casts:
- Ajouter: kyc_status, kyc_risk_score, kyc_last_screened_at, kyc_pep_flag
- Casts: kyc_last_screened_at datetime, kyc_pep_flag boolean, kyc_risk_score decimal:2

----

## 3) Services (Strategy/Adapter)

[ ] 3.1 — Interface: App\Services\Sanctions\SanctionsProviderInterface
- search(PersonData): Hit[] / Result

[ ] 3.2 — Provider Mock: App\Services\Sanctions\MockSanctionsProvider
- Lecture JSON local (ex: storage/app/sanctions/*.json)

[ ] 3.3 — Service: App\Services\Sanctions\SanctionsService
- Orchestration screening: normalisation data, persistance aml_screenings + sanctions_hits, calcul score, set flags (kyc_pep_flag, kyc_last_screened_at)

[ ] 3.4 — Service: App\Services\Kyc\KycService
- Soumission documents, transitions d’état (pending -> in_review -> approved/rejected), intégration screening, MAJ risk_score

[ ] 3.5 — (Optionnel) OCR stub: App\Services\Kyc\OcrService (placeholder)

----

## 4) Contrôleurs &amp; Routes

[x] 4.1 — KycController (auth)
- GET /kyc — écran statut + formulaire upload
- POST /kyc/submit — soumission (id_front, id_back, selfie, proof_of_address)
- GET /kyc/status — JSON pour polling

[ ] 4.2 — AdminKycController (auth + isAdmin)
- GET /admin/kyc — listing (filtres: status, risk, pep)
- GET /admin/kyc/{id} — détail (docs, screenings, résultats)
- POST /admin/kyc/{id}/approve
- POST /admin/kyc/{id}/reject (reason)
- POST /admin/kyc/{id}/rescreen

[x] 4.3 — Routes
- routes/web.php: Ajout des routes et middlewares

----

## 5) Middleware &amp; Enforcement

[ ] 5.1 — Middleware: EnsureKycVerified
- Bloquer: virements, retraits, création cartes, modification IBAN tant que kyc_status != approved
- Appliquer sur routes sensibles (TransactionController, etc.)

[ ] 5.2 — Enrichir AdminController/TransactionController si nécessaire pour messages clairs

----

## 6) Jobs &amp; Scheduler (Rescreen)

[ ] 6.1 — Commande artisan: aml:rescreen
- Re-screen des utilisateurs à échéance (rescreen_after)

[ ] 6.2 — app/Console/Kernel.php
- Planification (ex: quotidienne) et logs

----

## 7) Notifications

[ ] 7.1 — Emails + In-app:
- KYC Submitted (pending), In Review, Approved, Rejected (avec motif)
- Sanctions potential_match/match — alerte compliance

[ ] 7.2 — Intégration app/Services/NotificationService.php

----

## 8) Vues (Blade)

[ ] 8.1 — resources/views/kyc/submit.blade.php
- Upload 4 documents, état KYC, consignes

[ ] 8.2 — resources/views/admin/kyc/index.blade.php et show.blade.php
- Liste filtrable, vue détaillée avec docs + screening + actions

----

## 9) Sécurité &amp; Stockage

[ ] 9.1 — Validation fichiers (mime whitelist, taille max), checksum
[ ] 9.2 — Accès sécurisé (policy/gate), URLs non publiques, contrôleur de téléchargement sécurisé
[ ] 9.3 — Rate limit sur POST /kyc/submit, CSRF, en-têtes de sécurité (CSP stricte sur page upload)

----

## 10) Tests

[ ] 10.1 — Feature:
- Flux utilisateur: soumission KYC, blocage actions sensibles tant que pas approuvé
- Flux admin: review approve/reject, rescreen

[ ] 10.2 — Unit:
- SanctionsService: normalisation data, scoring, persistance
- MockSanctionsProvider: cas clear/potential/match

[ ] 10.3 — Intégration:
- Commande aml:rescreen + scheduling

----

## Commandes utiles
- php artisan migrate
- php artisan make:model KycVerification -m (si besoin par étape)
- php artisan make:command RescreenAmlCommand (nom réel à définir)
- php artisan schedule:list (vérifier planif)

----

## Journal d’avancement
- [x] Étape 1 — Migrations
- [x] Étape 2 — Modèles &amp; Relations
- [ ] Étape 3 — Services (KYC + Sanctions + Provider Mock)
- [ ] Étape 4 — Contrôleurs &amp; Routes (KycController + routes: OK; AdminKycController: à faire)
- [ ] Étape 5 — Middleware enforcement
- [ ] Étape 6 — Commande rescreen + Scheduler
- [ ] Étape 7 — Notifications
- [ ] Étape 8 — Vues (user/admin)
- [ ] Étape 9 — Sécurité stockage
- [ ] Étape 10 — Tests

Notes:
- Provider de sanctions: démarrage en Mock local (JSON), architecture prête pour adapter un fournisseur réel.
- Enforcement: appliquez sur virements, retraits, création cartes, changement IBAN (ajustable).
- UI: incrément 1 minimal (soumission + admin liste/détail) ; itérer ensuite sur UX.

