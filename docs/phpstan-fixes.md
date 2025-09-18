<<<<<<< HEAD
# Correzioni PHPStan Livello 7 - Modulo User

Questo documento traccia gli errori PHPStan di livello 7 identificati nel modulo User e le relative soluzioni implementate.

## Errori Identificati

### 1. Errori in Profile.php

```
Line 49: PHPDoc tag @method for method Modules\User\Models\Profile::permission() return type contains unknown class Modules\User\Models\Builder.
Line 49: PHPDoc tag @method for method Modules\User\Models\Profile::role() return type contains unknown class Modules\User\Models\Builder.
Line 49: PHPDoc tag @method for method Modules\User\Models\Profile::withExtraAttributes() return type contains unknown class Modules\User\Models\Builder.
Line 49: PHPDoc tag @method for method Modules\User\Models\Profile::withoutPermission() return type contains unknown class Modules\User\Models\Builder.
Line 49: PHPDoc tag @method for method Modules\User\Models\Profile::withoutRole() return type contains unknown class Modules\User\Models\Builder.
```

## Soluzioni Implementate

### 1. Correzione in Profile.php

Il problema è che i tag PHPDoc facevano riferimento a una classe `Builder` nel namespace `Modules\User\Models` che non esiste. Abbiamo corretto i riferimenti utilizzando il namespace completo per la classe Builder:

```php
/**
 * ...
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withoutRole($roles, $guard = null)
 * ...
 */
```

### Versione HEAD

Questo garantisce che PHPStan possa risolvere correttamente il tipo `Builder` utilizzando il namespace completo `\Illuminate\Database\Eloquent\Builder`. 
## Collegamenti tra versioni di phpstan_fixes.md
* [phpstan_fixes.md](../../../Xot/project_docs/phpstan/phpstan_fixes.md)
* [phpstan_fixes.md](../../../Xot/project_docs/phpstan_fixes.md)
* [phpstan_fixes.md](../../../User/project_docs/phpstan_fixes.md)
* [phpstan_fixes.md](../../../UI/project_docs/phpstan_fixes.md)
* [phpstan_fixes.md](../../../Media/project_docs/phpstan_fixes.md)


### Versione Incoming

Questo garantisce che PHPStan possa risolvere correttamente il tipo `Builder` utilizzando il namespace completo `\Illuminate\Database\Eloquent\Builder`. 

---

# PHPStan Fixes and Type System Improvements

## Overview

This document outlines the systematic fixes applied to resolve PHPStan errors in the codebase, with particular focus on type system improvements and architectural consistency.

## 1. View-String Type Issue

### Problem
PHPStan was reporting errors for static properties `$view` in Widget classes:
```
Static property Modules\User\Filament\Widgets\EditUserWidget::$view (view-string) does not accept default value of type string.
```

### Root Cause
The Filament Widget base class uses `view-string` in PHPDoc annotations but declares the property as `string`:
```php
/**
 * @var view-string
 */
protected static string $view;
```

### Solution
Use proper PHPDoc annotations to maintain type safety while keeping the `string` declaration:

```php
/**
 * @var string
 */
protected static string $view = 'pub_theme::filament.widgets.edit-user';
```

### Files Fixed
- `Modules/User/app/Filament/Widgets/EditUserWidget.php`
- `Modules/User/app/Filament/Widgets/Auth/PasswordResetConfirmWidget.php`
- `Modules/User/app/Filament/Widgets/Auth/PasswordResetWidget.php`

## 2. Missing Class Errors

### Problem
PHPStan reports missing classes that are referenced but not found:
```
Class Modules\TechPlanner\Models\Cliente not found.
Class Modules\TechPlanner\Models\Apparecchio not found.
```

### Solution
These classes need to be created or the references need to be updated to use existing models.

### Files Requiring Action
- `Modules/TechPlanner/app/Console/Commands/ImportAccessDataCommand.php`
- `Modules/TechPlanner/app/Contracts/PivotContract.php`
- `Modules/TechPlanner/app/Contracts/WorkerContract.php`

## 3. Type Casting Issues

### Problem
Multiple instances of unsafe type casting:
```
Cannot cast mixed to string.
Cannot cast mixed to float.
```

### Solution
Add proper type checking before casting:

```php
// Before
$value = (string) $mixedValue;

// After
$value = is_string($mixedValue) ? $mixedValue : (string) $mixedValue;
```

## 4. Missing Type Declarations

### Problem
Methods and properties without type declarations:
```
Method Modules\TechPlanner\Models\Worker::setBirthDayAttribute() has parameter $value with no type specified.
```

### Solution
Add proper type declarations:

```php
public function setBirthDayAttribute($value): void
// Becomes
public function setBirthDayAttribute(mixed $value): void
```

## 5. Safe Function Usage

### Problem
Unsafe function usage detected by thecodingmachine/safe:
```
Function chmod is unsafe to use. It can return FALSE instead of throwing an exception.
```

### Solution
Use Safe functions:
```php
// Before
chmod($file, 0755);

// After
use function Safe\chmod;
chmod($file, 0755);
```

## 6. Filament Component Issues

### Problem
Incorrect class references and missing methods:
```
Call to static method make() on an unknown class Modules\TechPlanner\Filament\Resources\ClientResource\Pages\Filament\Infolists\Components\Section.
```

### Solution
Use correct Filament component classes:
```php
// Before
use Modules\TechPlanner\Filament\Resources\ClientResource\Pages\Filament\Infolists\Components\Section;

// After
use Filament\Infolists\Components\Section;
```

## Implementation Strategy

### Phase 1: Type System Fixes
1. Fix view-string type issues in Widget classes
2. Add missing type declarations
3. Fix unsafe type casting

### Phase 2: Missing Classes
1. Create missing model classes or update references
2. Fix contract and interface references

### Phase 3: Safe Functions
1. Replace unsafe functions with Safe equivalents
2. Add proper use statements

### Phase 4: Filament Components
1. Fix incorrect class references
2. Update component imports

## Best Practices

### 1. Type Declarations
- Always declare parameter and return types
- Use `mixed` type for parameters that can accept various types
- Add proper PHPDoc annotations for complex types

### 2. Safe Operations
- Use Safe functions for file operations
- Add proper error handling for type casting
- Validate data before operations

### 3. Filament Integration
- Always extend XotBase classes, never Filament classes directly
- Use correct component imports
- Follow the established architectural patterns

### 4. Documentation
- Update documentation when making architectural changes
- Document type system improvements
- Maintain consistency across modules

## Testing

After applying fixes:
1. Run PHPStan analysis: `./vendor/bin/phpstan analyse Modules`
2. Run tests: `php artisan test`
3. Verify Filament functionality
4. Check for any new errors introduced

## Notes

- The `view-string` type is a PHPStan-specific type for view template paths
- Safe functions provide exception-throwing alternatives to standard PHP functions
- All Filament components should extend XotBase classes for consistency
- Type system improvements enhance code reliability and maintainability 
=======
# PHPStan Fixes - User Module

## Errori Risolti

### 1. Reset Password Method Return Type Error
**File**: `app/Filament/Widgets/Auth/ResetPasswordWidget.php`
**Errore**: `A void method must not return a value`
**Causa**: Il metodo `resetPassword()` era dichiarato come `void` ma restituiva un redirect quando il reset aveva successo
**Soluzione**: Cambiato il tipo di ritorno da `void` a `?\Illuminate\Http\RedirectResponse`

```php
// PRIMA (ERRATO)
/**
 * @return \Illuminate\Http\RedirectResponse|void
 */
public function resetPassword(): void {
    // ... logica di reset
    if ($status === Password::PASSWORD_RESET) {
        session()->flash('status', __($status));
        return redirect()->route('login');  // ERRORE: void method non può restituire valori
    } else {
        $this->addError('email', __($status));
    }
}

// DOPO (CORRETTO)
/**
 * @return \Illuminate\Http\RedirectResponse|null
 */
public function resetPassword(): ?\Illuminate\Http\RedirectResponse {
    // ... logica di reset
    if ($status === Password::PASSWORD_RESET) {
        session()->flash('status', __($status));
        return redirect()->route('login');  // OK: nullable type può restituire redirect
    } else {
        $this->addError('email', __($status));
    }
    
    return null;  // OK: nullable type può restituire null
}
```

**Motivazione**: Il metodo `resetPassword()` può restituire un redirect quando il reset della password ha successo, oppure non restituire nulla quando ci sono errori (gestiti tramite `addError`).

**Business Logic**: Questo widget Filament gestisce il reset delle password degli utenti, utilizzando il sistema di reset password di Laravel. Quando il reset ha successo, reindirizza l'utente alla pagina di login con un messaggio di conferma.

### 2. Login Authentication Method Return Type Error
**File**: `app/Http/Livewire/Auth/Login.php`
**Errore**: `A void method must not return a value`
**Causa**: Il metodo `authenticate()` era dichiarato come `void` ma restituiva un redirect quando l'autenticazione aveva successo
**Soluzione**: Cambiato il tipo di ritorno da `void` a `?\Illuminate\Http\RedirectResponse`

```php
// PRIMA (ERRATO)
/**
 * @return RedirectResponse|void
 */
public function authenticate(): void {
    // ... logica di autenticazione
    if (Auth::attempt($data, $remember)) {
        session()->regenerate();
        return $this->getRedirectUrl();  // ERRORE: void method non può restituire valori
    }
    // ... gestione errori
}

// DOPO (CORRETTO)
/**
 * @return RedirectResponse|null
 */
public function authenticate(): ?\Illuminate\Http\RedirectResponse {
    // ... logica di autenticazione
    if (Auth::attempt($data, $remember)) {
        session()->regenerate();
        return $this->getRedirectUrl();  // OK: nullable type può restituire redirect
    }
    // ... gestione errori
    return null;  // OK: nullable type può restituire null
}
```

**Motivazione**: Il metodo `authenticate()` può restituire un redirect quando l'autenticazione ha successo, oppure non restituire nulla quando ci sono errori (gestiti tramite `addError`).

**Business Logic**: Questo componente Livewire gestisce l'autenticazione degli utenti con redirect intelligente basato sui ruoli dell'utente. Quando l'autenticazione ha successo, reindirizza l'utente all'URL appropriato per il suo ruolo.

### 3. Console Command Constructor Return Type Error
**File**: `app/Console/Commands/AssignTeamCommand.php`
**Errore**: `Method Modules\User\Console\Commands\AssignTeamCommand::__construct() cannot declare a return type`
**Causa**: Il costruttore era dichiarato con un tipo di ritorno `void` nel PHPDoc
**Soluzione**: Rimosso il tipo di ritorno `void` dal PHPDoc del costruttore

```php
// PRIMA (ERRATO)
/**
 * Create a new command instance.
 *
 * @return void
 */
public function __construct() {
    parent::__construct();
}

// DOPO (CORRETTO)
/**
 * Create a new command instance.
 */
public function __construct() {
    parent::__construct();
}
```

**Motivazione**: In PHP, i costruttori non possono dichiarare un tipo di ritorno esplicito. Il tipo di ritorno è sempre implicito e non può essere specificato.

        **Business Logic**: Questo comando Artisan gestisce l'assegnazione di team agli utenti nel sistema. È parte del sistema di gestione utenti e team del framework Laraxot.

        ### 4. Console Command Constructor Return Type Error (Tenant)
        **File**: `app/Console/Commands/AssignTenantCommand.php`
        **Errore**: `Method Modules\User\Console\Commands\AssignTenantCommand::__construct() cannot declare a return type`
        **Causa**: Il costruttore era dichiarato con un tipo di ritorno `void` nel PHPDoc
        **Soluzione**: Rimosso il tipo di ritorno `void` dal PHPDoc del costruttore

        ```php
        // PRIMA (ERRATO)
        /**
         * Create a new command instance.
         *
         * @return void
         */
        public function __construct() {
            parent::__construct();
        }

        // DOPO (CORRETTO)
        /**
         * Create a new command instance.
         */
        public function __construct() {
            parent::__construct();
        }
        ```

        **Motivazione**: In PHP, i costruttori non possono dichiarare un tipo di ritorno esplicito. Il tipo di ritorno è sempre implicito e non può essere specificato.

        **Business Logic**: Questo comando Artisan gestisce l'assegnazione di tenant agli utenti nel sistema. È parte del sistema multi-tenancy del framework Laraxot.

        ### 5. Git Conflict Resolution Error
        **File**: `app/Console/Commands/AssignRoleCommand.php`
        **Errore**: `Syntax error, unexpected T_SL on line 35`
        **Causa**: Conflitto Git non risolto con marker di conflitto (`<<<<<<<`, `=======`, `>>>>>>>`)
        **Soluzione**: Risolto il conflitto Git mantenendo la sintassi standard per il costruttore

        ```php
        // PRIMA (ERRATO - Conflitto Git)
        /**
         * Create a new command instance.
         */
        <<<<<<< HEAD
        public function __construct() {
        =======
        public function __construct()
        {
        >>>>>>> 40e74a85 (.)
            parent::__construct();
        }

        // DOPO (CORRETTO)
        /**
         * Create a new command instance.
         */
        public function __construct()
        {
            parent::__construct();
        }
        ```

        **Motivazione**: I marker di conflitto Git devono essere risolti prima che il codice possa essere analizzato correttamente da PHPStan.

        **Business Logic**: Questo comando Artisan gestisce l'assegnazione di ruoli agli utenti nel sistema. È parte del sistema di gestione ruoli e permessi del framework Laraxot.

        ## Pattern Identificati

        ### Filament Widget Methods
        - I metodi dei widget Filament possono restituire diversi tipi a seconda del contesto
- Utilizzare union types (`TypeA|TypeB`) quando un metodo può restituire tipi diversi
- Gestire correttamente i casi di successo e errore

### Password Reset Flow
- Utilizzare il sistema Password di Laravel per il reset
- Gestire i messaggi di stato tramite session flash
- Reindirizzare solo in caso di successo, gestire errori tramite `addError`

## Collegamenti
- [README.md](./README.md)
- [Authentication Documentation](./authentication.md)
- [Filament Best Practices](./filament-best-practices.md)
>>>>>>> 64fb2fa (.)
