# Pacchetti del Modulo User

## Pacchetti Utilizzati

### Core
- [laraxot/module_xot_fila3](../Xot/docs/packages.md) - Modulo base per funzionalità comuni
- [laraxot/module_ui](../UI/docs/packages.md) - Componenti UI e temi
- [laraxot/module_tenant_fila3](../Tenant/docs/packages.md) - Gestione multi-tenant

### Autenticazione
- [laravel/fortify](https://github.com/laravel/fortify)
  - Autenticazione
  - Registrazione
  - Recupero password

- [laravel/sanctum](https://github.com/laravel/sanctum)
  - API tokens
  - SPA authentication
  - Mobile authentication

## Pacchetti di Riferimento

### Permessi
- [spatie/laravel-permission](https://github.com/spatie/laravel-permission)
  - Gestione ruoli
  - Gestione permessi
  - Middleware

- [spatie/laravel-activitylog](https://github.com/spatie/laravel-activitylog)
  - Log attività
  - Audit trail
  - Tracciamento modifiche

## Pacchetti Potenziali

### Sicurezza
- [spatie/laravel-backup](https://github.com/spatie/laravel-backup) - Backup
- [spatie/laravel-activitylog](https://github.com/spatie/laravel-activitylog) - Log attività
- [spatie/laravel-permission](https://github.com/spatie/laravel-permission) - Permessi

### Performance
- [spatie/laravel-responsecache](https://github.com/spatie/laravel-responsecache) - Cache risposte
- [spatie/laravel-model-states](https://github.com/spatie/laravel-model-states) - Stati modelli
- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action) - Azioni in coda

## Pacchetti da Non Utilizzare

### Autenticazione
- [laravel/ui](https://github.com/laravel/ui) - Obsoleto
- [laravel/breeze](https://github.com/laravel/breeze) - Non necessario con Fortify

### Permessi
- [laravel/telescope](https://github.com/laravel/telescope) - Non per production
- [laravel/horizon](https://github.com/laravel/horizon) - Non necessario per base

## Documentazione Collegata

- [Autenticazione](packages/authentication.md)
- [Permessi](packages/permissions.md)
- [Sicurezza](packages/security.md)
- [Performance](packages/performance.md) 
