# Piano di Correzione PHPStan Livello 1 - Modulo User

## Problemi Identificati

### 1. Classi Non Trovate
- **Contratti**
  - `Modules\Xot\Contracts\UserContract`
  - `Modules\Xot\Contracts\ProfileContract`
  
- **Framework Laravel**
  - `Illuminate\Auth\Notifications\*`
  - `Illuminate\Foundation\Support\Providers\*`
  - `Illuminate\Notifications\Messages\*`
  
- **Pacchetti Esterni**
  - `Spatie\Permission\*`
  - `Filament\*`
  - `SocialiteProviders\*`
  - `Webmozart\Assert\*`

### 2. Metodi Non Trovati
- Relazioni Eloquent:
  - `belongsTo()`
  - `belongsToMany()`
  - `hasMany()`
  
- Metodi di Trait:
  - `authentications()`
  - `ownsTeam()`
  - `belongsToTeam()`

### 3. Funzioni Helper
- Laravel:
  - `config()`
  - `__()`
  - `route()`
  - `url()`
  - `now()`
  - `app_path()`
  
- Safe PHP:
  - `Safe\class_implements`
  - `Safe\class_uses`

### 4. Problemi di Tipizzazione
- Parametri con tipi invalidi nei metodi delle policy
- Proprietà non definite in BaseUser
- Return type non validi in provider

## Piano di Correzione

### Fase 1: Dipendenze
1. Verificare composer.json per le dipendenze mancanti
2. Aggiungere le dipendenze necessarie:
   ```json
   {
       "require": {
           "laravel/framework": "^10.0",
           "spatie/laravel-permission": "^5.0",
           "filament/filament": "^3.0",
           "socialiteproviders/manager": "^4.0",
           "webmozart/assert": "^1.0"
       }
   }
   ```

### Fase 2: Contratti
1. Importare i contratti dal modulo Xot
2. Creare stub per i contratti mancanti
3. Aggiornare i namespace

### Fase 3: Trait e Relazioni
1. Implementare i metodi mancanti nei trait
2. Correggere le definizioni delle relazioni
3. Aggiungere le tipizzazioni corrette

### Fase 4: Helper e Funzioni
1. Importare le funzioni helper di Laravel
2. Aggiungere gli import per Safe PHP
3. Creare helper personalizzati se necessario

### Fase 5: Tipizzazione
1. Correggere i tipi nei parametri delle policy
2. Definire le proprietà mancanti in BaseUser
3. Aggiornare i return type nei provider

## Priorità
1. Contratti e dipendenze (blockers)
2. Trait e relazioni (core functionality)
3. Helper e funzioni (supporto)
4. Tipizzazione (qualità del codice)

## Note
- Non modificare phpstan.neon
- Mantenere la compatibilità con le versioni esistenti
- Documentare ogni modifica
- Testare dopo ogni fase

## Collegamenti
- [Documentazione PHPStan](/docs/phpstan.md)
- [Contratti del Modulo](/docs/modules/user/contracts.md)
- [Modelli](/docs/modules/user/models.md)
- [Best Practices](/docs/best_practices.md) 
