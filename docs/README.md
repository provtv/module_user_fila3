# User Module Documentation

**Ultima modifica**: 2025-01-15
**Status**: ✅ Syntax Errors Fixed, ✅ PHPStan Analysis completata, ✅ Documentazione consolidata

## 🎯 Panoramica

Il modulo User gestisce l'autenticazione, l'autorizzazione e la gestione degli utenti nel framework Laraxot.

## 📚 Collegamenti alla Documentazione Core

- **[Xot Module Documentation](../Xot/docs/README.md)** - Framework core e convenzioni
- **[Laraxot Conventions](../Xot/docs/laraxot-conventions.md)** - Regole di sviluppo e tipizzazione
- **[Laraxot Framework](../Xot/docs/laraxot-framework.md)** - Architettura e pattern
- **[Module Namespace Rules](../Xot/docs/module-namespace-rules.md)** - Regole namespace e migrazioni
- **[Best Practices](../Xot/docs/best-practices.md)** - Best practices generali
- **[Useful Links](../Xot/docs/useful-links.md)** - Link utili per lo sviluppo

## Funzionalità

### 1. Autenticazione
- Login/Logout
- Registrazione
- Password Reset
- Email Verification

### 2. Autorizzazione
- Ruoli e Permessi
- Policy
- Gates
- Middleware

### 3. Gestione Utenti
- CRUD Utenti
- Profili
- Impostazioni
- Notifiche

## 🏗️ Architettura Framework

### Regole Base XotBase
- **Policies**: Estendono sempre `UserBasePolicy` (MAI direttamente Filament)
- **Resources**: Estendono sempre `XotBaseResource`
- **Models**: Estendono sempre `BaseModel` con tipizzazione rigorosa

## Struttura del Modulo

### Regola fondamentale sulle migration

> **Tutte le migration che riguardano tabelle, colonne o relazioni di un modulo devono essere SEMPRE nella cartella `database/migrations` del modulo stesso (es: `Modules/User/database/migrations/`).**
> Mettere migration in `laravel/database/migrations` è un errore grave che rompe la modularità, il rollback e la chiarezza del progetto.
> Vedi dettagli e motivazione in [PATH_CONVENTIONS.md](./PATH_CONVENTIONS.md).

```
Modules/User/
├── app/
│   ├── Models/
│   │   ├── User.php
│   │   ├── BaseUser.php
│   │   ├── OauthAccessToken.php
│   │   ├── OauthAuthCode.php
│   │   ├── OauthClient.php
│   │   ├── OauthPersonalAccessClient.php
│   │   └── OauthRefreshToken.php
│   ├── Providers/
│   │   ├── Traits/
│   │   │   ├── HasPassportConfiguration.php
│   │   │   └── HasSocialiteConfiguration.php
│   │   ├── UserServiceProvider.php
│   │   ├── EventServiceProvider.php
│   │   ├── RouteServiceProvider.php
│   │   └── Filament/
│   │       └── AdminPanelProvider.php
│   ├── Filament/
│   │   ├── Resources/
│   │   │   └── UserResource.php
│   │   ├── Widgets/
│   │   │   ├── Auth/
│   │   │   │   ├── LoginWidget.php
│   │   │   │   └── SocialLoginWidget.php
│   │   │   └── User/
│   │   │       ├── UserStatsWidget.php
│   │   │       └── UserActivityWidget.php
│   │   └── Pages/
│   │       └── Auth/
│   │           ├── LoginPage.php
│   │           └── RegisterPage.php
│   └── Http/
│       └── Controllers/
│           └── Auth/
├── config/
│   └── auth.php
├── database/
│   └── migrations/
└── resources/
    └── views/
        └── pages/
            └── auth/
```

## Dipendenze Principali

### Moduli
- **Xot**: Fornisce le classi base e l'infrastruttura core
- **Lang**: Gestione delle traduzioni
- **Notify**: Sistema di notifiche
- **UI**: Componenti di interfaccia utente

### Pacchetti
- Laravel Passport
- Laravel Socialite
- Spatie Permission
- Filament

## Best Practices

### 1. Estensione delle Classi
```php
// ❌ NON FARE QUESTO
use Filament\Widgets\Widget;
class LoginForm extends Widget { ... }

// ✅ FARE QUESTO
use Modules\Xot\Filament\Widgets\XotBaseWidget;
class LoginWidget extends XotBaseWidget { ... }
```

### 2. Gestione delle Traduzioni
```php
// ❌ NON FARE QUESTO
->label('Sorgente')

// ✅ FARE QUESTO
->label(['label' => 'Sorgente'])
```

### 3. Configurazione dei Provider
```php
// In Modules/User/app/Providers/UserServiceProvider.php
use Modules\User\Providers\Traits\HasPassportConfiguration;

class UserServiceProvider extends XotBaseServiceProvider
{
    use HasPassportConfiguration;

    public function boot(): void
    {
        $this->configurePassport();
    }
}
```

## Moderazione Utente Generica dal Modulo User

### Premessa e Neutralità
In questo modulo, la gestione della moderazione non deve mai fare riferimento a ruoli o tipi specifici (es. "dentista", "paziente"). Tutti i tipi di utente sono rappresentati come varianti (type/parental) del modello User, secondo il pattern Single Table Inheritance (STI) o Parental, utilizzando SEMPRE la colonna `type` (vedi [tighten/parental](https://github.com/tighten/parental)). Questo garantisce la massima riusabilità del modulo User in qualsiasi progetto.

### Architettura proposta
- **Model**: User è la base, ogni tipo di utente (es. admin, operator, specialist, ...), è un parental/type di User. La colonna di discriminazione è SEMPRE `type`.
- **Enum/ModelStates**: Lo stato di moderazione è gestito tramite enum o Spatie Model States, utilizzando SEMPRE la colonna `state` (vedi [spatie/laravel-model-states](https://spatie.be/docs/laravel-model-states/v2/working-with-states)), con valori come `pending`, `approved`, `rejected`, applicabile a qualunque tipo di utente.
- **Action**: Azioni queueable (spatie/laravel-queueable-action) per approve/reject, generiche e parametrizzate sul tipo di utente.
- **Notifiche**: Notifiche di stato centralizzate, con template e destinatari dinamici in base al type.
- **UI**: Pannello Filament unico per la moderazione, con filtri per type e stato.
- **Policy**: Policy centralizzate per la moderazione, con possibilità di override per type specifici.
- **Eventi/Listener**: Eventi per transizioni di stato, listener per notifiche e logging, generici e riutilizzabili.

### Flusso Moderazione Utente (Generico)
1. **Registrazione**: L'utente si registra tramite wizard unico, che raccoglie i dati base e quelli specifici del type. Il campo `type` viene valorizzato secondo la variante.
2. **Stato iniziale**: L'utente viene creato in stato `pending` (moderazione richiesta), valorizzando la colonna `state`.
3. **Moderazione**: Un moderatore visualizza la richiesta, può approvare o rifiutare (UI e azioni generiche).
4. **Transizione di stato**: Azione queueable aggiorna la colonna `state`, invia notifica, logga l'evento (tutto generico).
5. **Notifica**: L'utente riceve email con esito e, se approvato, link per completare la registrazione (template dinamico).
6. **Completamento**: L'utente può accedere e completare i dati solo se approvato.

## Convenzioni fondamentali per STI/Parental e Model States

### 1. Single Table Inheritance (STI) / Parental
- **Colonna obbligatoria:** `type` (e NON `user_type`)
- **Motivazione:** Segue la convenzione tighten/parental ([vedi doc](https://github.com/tighten/parental))
- **Esempio migrazione:**
```php
Schema::table('users', function ($table) {
    $table->string('type')->nullable();
});
```
- **Nota:** La colonna `type` deve essere nullable per permettere la compatibilità con modelli base e specializzati.

### 2. Model States (spatie/laravel-model-states)
- **Colonna obbligatoria:** `state` (e NON `moderation_status` o simili)
- **Motivazione:** Segue la convenzione spatie/laravel-model-states ([vedi doc](https://spatie.be/docs/laravel-model-states/v2/working-with-states/01-configuring-states))
- **Esempio migrazione:**
```php
Schema::table('users', function ($table) {
    $table->string('state')->nullable();
});
```
- **Nota:** La colonna `state` rappresenta lo stato generico del modello (pending, approved, rejected, ecc.)

### 3. Esempio di implementazione
```php
// Model User.php
use Parental\HasParent;
use Spatie\ModelStates\HasStates;

class User extends Model {
    use HasStates;
    // ...
    protected $casts = [
        'state' => UserState::class,
    ];
}

// Enum State
abstract class UserState extends State {
    // ...
}
```

## Business Logic: Solo Actions, mai Service

### Convenzione di progetto
- **Non utilizzare mai Service** per la business logic.
- Utilizzare SEMPRE le Actions queueable di [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action).
- Le Actions sono classi dedicate che incapsulano la logica di dominio e possono essere eseguite sia in modo sincrono che asincrono (in coda).

### Motivazione
- Maggiore testabilità e riusabilità
- Supporto nativo a queue, chaining, tagging, middleware, backoff, ecc.
- Costruttore con dependency injection (più flessibile dei Job standard)
- Uniformità e chiarezza architetturale

### Esempio di Action
```php
use Spatie\QueueableAction\QueueableAction;

class ApproveUserAction
{
    use QueueableAction;

    public function execute(User $user): void
    {
        // Logica di approvazione
        $user->state = 'approved';
        $user->save();
    }
}
```

## Audit e Logging: Solo Spatie Activitylog, mai ModerationLog custom

### Convenzione di progetto
- **Non utilizzare mai tabelle custom come ModerationLog** per tracciare le azioni di moderazione o audit.
- Utilizzare SEMPRE [spatie/laravel-activitylog](https://spatie.be/docs/laravel-activitylog/v4/introduction) per il logging di tutte le attività rilevanti (moderazione, cambi di stato, ecc.).

### Esempio di utilizzo
```php
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['state', 'type'];
    protected static $logName = 'user_moderation';
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
}

// Log manuale di un evento custom
activity()
    ->performedOn($user)
    ->causedBy(auth()->user())
    ->withProperties(['reason' => 'approved by admin'])
    ->log('User approved');
```

## Migrazioni: uso corretto di hasColumn con XotBaseMigration

### Regola fondamentale
- **NON usare mai** `Schema::hasColumn('users', 'state')` nelle migrazioni che estendono XotBaseMigration.
- **Usare SEMPRE** `$this->hasColumn('state')` (o altro nome colonna) come da convenzione XotBaseMigration.

### Esempio corretto
```php
if (! $this->hasColumn('state')) {
    $this->tableUpdate(function (Blueprint $table) {
        $table->string('state')->nullable();
    });
}
```

## Best Practice: Implementazione dei Contract

> **Nota fondamentale:**
> Tutti i metodi richiesti dalle interfacce (contract) devono essere implementati come **pubblici** nella classe o trait che li dichiara, anche se la logica è delegata a un metodo privato/protetto (es. `ownsTeamTrait`).

### Esempio concreto: TeamContract

- Il contract `HasTeamsContract` richiede il metodo pubblico `ownsTeam(TeamContract $team): bool`.
- Il trait `HasTeams` implementa la logica in `ownsTeamTrait`, ma **deve** dichiarare anche il metodo pubblico `ownsTeam` che delega a `ownsTeamTrait`.

```php
public function ownsTeam(TeamContract $team): bool
{
    return $this->ownsTeamTrait($team);
}
```

## Requisito strutturale: colonna owner_id in teams

> **Nota fondamentale:**
> La tabella `teams` deve avere la colonna `owner_id` (`uuid`, nullable) per garantire la compatibilità con il trait `HasTeams` e tutte le relazioni Eloquent che gestiscono la proprietà dei team.

### Esempio di migration
```php
Schema::table('teams', function (Blueprint $table) {
    $table->uuid('owner_id')->nullable()->after('id');
    // opzionale: $table->foreign('owner_id')->references('id')->on('users')->nullOnDelete();
});
```

## Documentazione Tecnica

### Collegamenti Principali
- [Architettura del Modulo](structure.md)
- [Configurazione Passport](passport.md)
- [Integrazione Socialite](socialite.txt)
- [Gestione Profili](user_profile_models.md)
- [Best Practices Filament](filament-best-practices.md)
- [Roadmap](roadmap.md)
- [Bottlenecks](bottlenecks.md)

### Autenticazione
- [Login Personalizzato](custom_login.md)
- [Autenticazione a Due Fattori](two_factor.txt)
- [Single Sign-On](sso.txt)
- [Gestione Password](password.md)

### Autorizzazione
- [Permessi Spatie](spatie_permissions.txt)
- [Gestione Ruoli](repositories.md)
- [Team e Collaborazioni](teams.md)

### Testing e Qualità
- [🚨 PHPStan Critical Rules](../Xot/docs/phpstan-critical-rules.md) - **🚨 CRITICO** - phpstan.neon INTOCCABILE
- [PHPStan Array Types Fixes](phpstan-array-types-fixes.md) - **⭐ NUOVO** - Correzioni tipi array mancanti
- [PHPStan Fixes](./phpstan_fixes.md)
<<<<<<< HEAD
=======
- [PHPStan Fixes (Current)](./phpstan-fixes.md) - **⭐ NUOVO** - Fixes attuali PHPStan
>>>>>>> 64fb2fa (.)
- [PHPStan Level 9](./PHPSTAN_LEVEL9_FIXES.md)
- [PHPStan Level 10](./PHPSTAN_LEVEL10_FIXES.md)

## Collegamenti Bidirezionali

### Integrazioni
- [Integrazione con Xot](../Xot/docs/README.md)
- [Integrazione con Lang](../Lang/docs/README.md)
- [Integrazione con Notify](../Notify/docs/README.md)
- [Integrazione con Activity](../Activity/docs/README.md)
- [Integrazione con Media](../Media/docs/README.md)
- [Integrazione con Tenant](../Tenant/docs/README.md)
- [Integrazione con UI](../UI/docs/README.md)

## Aggiornamenti Recenti

### 27 Gennaio 2025
- ✅ **Riorganizzazione Documentazione**: Spostati file specifici da docs_project alle cartelle docs dei moduli
  - **File spostati in User/docs/**:
    - `doctor-registration-widget.md` - Widget registrazione dottori
    - `doctor-registration.md` - Sistema registrazione dottori
    - `email-doctor-registration.md` - Email registrazione dottori
  - **Motivazione**: Separazione responsabilità, principio modulare, manutenibilità
  - **Regola**: docs_project solo per documentazione generale del progetto, file specifici di moduli nelle rispettive cartelle docs

## Note Importanti

### Estensione Classi
- Non estendere mai direttamente le classi di Filament
- Utilizzare sempre le classi base di Xot con prefisso XotBase
- Seguire le convenzioni di naming del modulo

### Trait e Service Provider
- I trait per i provider devono essere in `Providers/Traits/`
- Seguire la struttura esistente per nuovi trait
- Documentare sempre l'uso dei trait

### Traduzioni
- Utilizzare il LangServiceProvider per le traduzioni
- Non usare ->label() direttamente
- Struttura corretta: 'source' => ['label'=>'Sorgente']

> **Nota fondamentale:**
> Se stai creando o modificando una Filament Resource che estende XotBaseResource, NON dichiarare mai le proprietà statiche $navigationGroup, $navigationLabel, né il metodo statico table(Table $table): Table. Segui la regola documentata in [filament-best-practices.mdc](./filament-best-practices.mdc).

## 🔗 Collegamenti Moduli
- [Xot Core Framework](../Xot/docs/README.md)
- [Lang Translations](../Lang/docs/README.md)
- [Notify System](../Notify/docs/README.md)

---
*User Module Documentation - Framework Laraxot*