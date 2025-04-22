# Parental: Ereditarietà a Tabella Singola in SaluteOra

## Indice
- [Introduzione](#introduzione)
- [Concetti Fondamentali](#concetti-fondamentali)
- [Implementazione in SaluteOra](#implementazione-in-saluteora)
- [Casi d'Uso nel Modulo User](#casi-duso-nel-modulo-user)
- [Best Practices](#best-practices)
- [Troubleshooting](#troubleshooting)
- [Riferimenti](#riferimenti)

## Introduzione

Parental è una libreria sviluppata da Tighten che implementa il pattern di **Single Table Inheritance (STI)** in Laravel. Questo documento analizza in dettaglio come utilizzare Parental nel contesto del modulo User di SaluteOra per gestire diversi tipi di utenti mantenendo un'architettura pulita e performante.

### Cos'è la Single Table Inheritance?

La Single Table Inheritance è un pattern di progettazione che permette di estendere un modello base (genitore) con modelli specializzati (figli) che condividono la stessa tabella nel database. Questo approccio offre diversi vantaggi:

- **Semplicità dello schema database**: una sola tabella per tutti i tipi di entità correlate
- **Prestazioni ottimizzate**: nessun join necessario per recuperare dati specializzati
- **Flessibilità nell'evoluzione del dominio**: facile aggiunta di nuovi tipi specializzati

## Concetti Fondamentali

### 1. Modello Genitore e Modelli Figli

In Parental, definiamo:
- Un **modello genitore** che rappresenta l'entità base (es. `User`)
- Uno o più **modelli figli** che estendono il genitore con comportamenti specifici (es. `Admin`, `Patient`, `Doctor`)

### 2. Trait Principali

Parental fornisce due trait fondamentali:

- **`HasChildren`**: Applicato al modello genitore per permettergli di restituire istanze dei modelli figli appropriati
- **`HasParent`**: Applicato ai modelli figli per permettere loro di utilizzare la tabella del genitore

### 3. Colonna di Tipo

Per distinguere tra i diversi tipi di entità nella stessa tabella, Parental utilizza una colonna di tipo (default: `type`) che memorizza:
- Il nome completo della classe del modello figlio, oppure
- Un alias configurabile più leggibile

## Implementazione in SaluteOra

### Configurazione Base

1. **Installazione della libreria**:
   ```bash
   composer require tightenco/parental
   ```

2. **Aggiunta della colonna di tipo**:
   ```php
   Schema::table('users', function ($table) {
       $table->string('type')->nullable();
   });
   ```

3. **Configurazione del modello genitore**:
   ```php
   namespace Modules\User\Models;

   use Illuminate\Foundation\Auth\User as Authenticatable;
   use Parental\HasChildren;

   class User extends Authenticatable
   {
       use HasChildren;

       protected $fillable = [
           'name',
           'email',
           'password',
           'type'
       ];

       // Opzionale: definire alias per i tipi
       protected $childTypes = [
           'admin' => \Modules\User\Models\Admin::class,
           'patient' => \Modules\User\Models\Patient::class,
           'doctor' => \Modules\User\Models\Doctor::class,
       ];
   }
   ```

4. **Configurazione dei modelli figli**:
   ```php
   namespace Modules\User\Models;

   use Parental\HasParent;

   class Admin extends User
   {
       use HasParent;

       // Metodi e proprietà specifici per Admin
       public function canAccessDashboard()
       {
           return true;
       }
   }
   ```

### Personalizzazioni Avanzate

#### Cambio del nome della colonna di tipo

Se si desidera utilizzare un nome diverso da `type` per la colonna di discriminazione:

```php
class User extends Authenticatable
{
    use HasChildren;

    protected $childColumn = 'user_type';
}
```

#### Utilizzo di alias per i tipi

Per evitare di memorizzare nomi di classi completi nel database:

```php
class User extends Authenticatable
{
    use HasChildren;

    protected $childTypes = [
        'amministratore' => \Modules\User\Models\Admin::class,
        'paziente' => \Modules\User\Models\Patient::class,
        'medico' => \Modules\User\Models\Doctor::class,
    ];
}
```

## Casi d'Uso nel Modulo User

### 1. Gestione Utenti con Ruoli Diversi

In SaluteOra, possiamo utilizzare Parental per implementare diversi tipi di utenti con comportamenti specifici:

```php
// Creazione di utenti specializzati
$admin = Admin::create([
    'name' => 'Mario Rossi',
    'email' => 'admin@saluteora.it',
    'password' => Hash::make('password')
]);

$patient = Patient::create([
    'name' => 'Giulia Bianchi',
    'email' => 'paziente@example.com',
    'password' => Hash::make('password'),
    'codice_fiscale' => 'BNCGLI80A01H501A',
    'data_nascita' => '1980-01-01'
]);

// Recupero di tutti gli utenti (con il tipo corretto)
$users = User::all(); // Restituisce una collezione di Admin, Patient, ecc.

// Filtraggio per tipo specifico
$admins = User::where('type', 'admin')->get(); // o l'alias configurato
```

### 2. Integrazione con il Sistema di Autorizzazioni

Parental si integra perfettamente con i sistemi di autorizzazione di Laravel:

```php
// In AuthServiceProvider.php
Gate::define('access-dashboard', function ($user) {
    // Verifica automaticamente se l'utente è un'istanza di Admin
    return $user instanceof \Modules\User\Models\Admin || 
           ($user instanceof \Modules\User\Models\Doctor && $user->hasPermission('dashboard'));
});
```

### 3. Estensione dei Modelli con Relazioni Specifiche

Ogni modello figlio può definire relazioni specifiche:

```php
class Patient extends User
{
    use HasParent;

    // Relazioni specifiche per i pazienti
    public function appointments()
    {
        return $this->hasMany(\Modules\Appointment\Models\Appointment::class, 'patient_id');
    }

    public function medicalRecords()
    {
        return $this->hasMany(\Modules\MedicalRecord\Models\MedicalRecord::class, 'patient_id');
    }
}

class Doctor extends User
{
    use HasParent;

    // Relazioni specifiche per i medici
    public function specialties()
    {
        return $this->belongsToMany(\Modules\Doctor\Models\Specialty::class);
    }

    public function availabilities()
    {
        return $this->hasMany(\Modules\Doctor\Models\Availability::class);
    }
}
```

## Best Practices

### 1. Quando Usare Parental vs. Relazioni Tradizionali

**Utilizzare Parental quando**:
- I diversi tipi di utenti condividono la maggior parte degli attributi
- Si desidera evitare join frequenti tra tabelle di utenti correlate
- La logica di business richiede polimorfismo a livello di modello

**Preferire relazioni tradizionali quando**:
- I diversi tipi di utenti hanno molti attributi specifici
- Si prevede una crescita significativa e differenziata tra i diversi tipi
- È necessario ottimizzare query specifiche per tipo

### 2. Gestione delle Migrazioni

Quando si aggiungono attributi specifici per un tipo di utente:

```php
Schema::table('users', function (Blueprint $table) {
    // Campi comuni a tutti gli utenti
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->string('type')->nullable();
    
    // Campi specifici per pazienti (nullable)
    $table->string('codice_fiscale')->nullable();
    $table->date('data_nascita')->nullable();
    
    // Campi specifici per medici (nullable)
    $table->string('numero_iscrizione_albo')->nullable();
    $table->string('specializzazione')->nullable();
});
```

### 3. Ottimizzazione delle Performance

- **Indici appropriati**:
  ```php
  Schema::table('users', function (Blueprint $table) {
      $table->index('type');
  });
  ```

- **Eager Loading selettivo**:
  ```php
  // Carica relazioni specifiche in base al tipo
  $users = User::all()->each(function ($user) {
      if ($user instanceof Patient) {
          $user->load('medicalRecords');
      } elseif ($user instanceof Doctor) {
          $user->load('specialties', 'availabilities');
      }
  });
  ```

## Troubleshooting

### Problemi Comuni e Soluzioni

1. **Il tipo non viene impostato correttamente**
   - Verifica che `type` (o la colonna personalizzata) sia inclusa in `$fillable`
   - Controlla che la colonna esista nella tabella del database

2. **I modelli restituiti sono sempre del tipo genitore**
   - Assicurati che il trait `HasChildren` sia applicato al modello genitore
   - Verifica che i valori nella colonna `type` corrispondano ai nomi delle classi o agli alias configurati

3. **Errori con le relazioni nei modelli figli**
   - Ricorda che le relazioni devono essere definite con la chiave esterna basata sul nome della tabella del genitore
   - Usa `getMorphClass()` quando necessario per ottenere il nome della classe corretto

4. **Problemi con Laravel Nova**
   - Registra il provider `\Parental\Providers\NovaResourceProvider::class` nel `NovaServiceProvider`

## Riferimenti

- [Documentazione ufficiale di Parental](https://github.com/tighten/parental)
- [Articolo: "Single Table Inheritance in Laravel with Parental"](https://tighten.com/blog/single-table-inheritance-in-laravel-with-parental/)
- [Pattern di progettazione: Single Table Inheritance](https://martinfowler.com/eaaCatalog/singleTableInheritance.html)
