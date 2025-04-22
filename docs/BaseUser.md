# BaseUser

La classe `BaseUser` è una classe astratta che implementa le interfacce `UserContract` e `HasTeamsContract`. Fornisce l'implementazione base per la gestione degli utenti nel sistema.

## Interfacce Implementate

- `UserContract`: Contratto base per gli utenti
- `HasTeamsContract`: Contratto per la gestione dei team

## Traits Utilizzati

- `HasApiTokens`
- `HasFactory`
- `HasRoles`
- `HasTeams`
- `HasUuids`
- `HasAuthenticationLogTrait`
- `HasTenantsRelation`
- `Notifiable`
- `RelationX`

## Relazioni Principali

- `tenants(): BelongsToMany<Tenant>` - Relazione many-to-many con i tenant
- `teams(): BelongsToMany<Team>` - Relazione many-to-many con i team
- `roles(): BelongsToMany<Role>` - Relazione many-to-many con i ruoli
- `devices(): BelongsToMany<Device>` - Relazione many-to-many con i dispositivi
- `socialiteUsers(): HasMany<SocialiteUser>` - Relazione one-to-many con gli account social
- `authentications(): HasMany<AuthenticationLog>` - Relazione one-to-many con i log di autenticazione

## Metodi Principali

### Team Management

- `teamRole(Team $team): ?string` - Ottiene il ruolo dell'utente nel team specificato
- `canRemoveTeamMember(Team $team, HasTeamsContract $user): bool` - Verifica se l'utente può rimuovere un membro del team
- `canUpdateTeamMember(Team $team, HasTeamsContract $user): bool` - Verifica se l'utente può aggiornare un membro del team
- `teamPermissions(Team $team): array<string, bool>` - Ottiene i permessi dell'utente nel team

### Role Management

- `hasRole($roles, ?string $guard = null): bool` - Verifica se l'utente ha un determinato ruolo
- `assignRole($roles): self` - Assegna uno o più ruoli all'utente
- `removeRole($role): self` - Rimuove un ruolo dall'utente

## Note Importanti

- La classe utilizza UUID come chiave primaria
- Implementa il multi-tenancy attraverso la relazione `tenants`
- Supporta l'autenticazione social attraverso la relazione `socialiteUsers`
- Gestisce i log di autenticazione attraverso la relazione `authentications`

## Collegamenti Correlati

- [[HasTeamsContract]]
- [[UserContract]]
- [[Team]]
- [[Role]]
- [[Tenant]]
- [[Device]]
- [[SocialiteUser]]
- [[AuthenticationLog]] 
