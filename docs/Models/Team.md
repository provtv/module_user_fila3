# Team

Il modello `Team` rappresenta un team nel sistema, implementando l'interfaccia `TeamContract`.

## Proprietà

- `id` - UUID del team
- `name` - Nome del team
- `owner_id` - ID del proprietario del team
- `personal_team` - Flag che indica se è un team personale

## Relazioni

- `owner` - BelongsTo con `User`, rappresenta il proprietario del team
- `users` - BelongsToMany con `User`, rappresenta i membri del team
- `teamPermissions` - HasMany con `TeamPermission`, rappresenta i permessi specifici del team

## Metodi

### Gestione Utenti

- `hasUser(UserContract $user): bool` - Verifica se un utente è membro del team
- `addUser(UserContract $user, string $role = 'member'): void` - Aggiunge un utente al team
- `removeUser(UserContract $user): void` - Rimuove un utente dal team
- `purge(): void` - Rimuove tutti gli utenti dal team

### Gestione Permessi

- `getPermissionsFor(?UserContract $user): array<string, bool>` - Ottiene i permessi di un utente nel team
- `teamPermissions(): HasMany` - Relazione con i permessi del team

## Note Importanti

- Il modello utilizza UUID come chiave primaria
- Implementa l'interfaccia `TeamContract`
- Gestisce i permessi attraverso la relazione `teamPermissions`

## Collegamenti Correlati

- [[TeamContract]]
- [[User]]
- [[TeamPermission]]
- [[HasTeamsContract]] 
