<?php

/**
 * @see https://github.com/ryangjchandler/filament-user-resource/blob/main/src/resources/UserResource/Pages/EditUser.php
<<<<<<< HEAD
=======
 * Pagina di modifica utente per Filament.
>>>>>>> 07cc6b5c (.)
 */

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;
use Modules\User\Filament\Resources\UserResource;
<<<<<<< HEAD
=======
use Modules\User\Models\User;
>>>>>>> 07cc6b5c (.)
use Webmozart\Assert\Assert;

use Modules\Xot\Filament\Resources\XotBaseResource\RelationManager\XotBaseRelationManager;

<<<<<<< HEAD
=======
/**
 * Pagina per la modifica degli utenti con particolare gestione della password.
 */
>>>>>>> 07cc6b5c (.)
class EditUser extends EditRecord
{
    // //
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        Assert::isArray($data);
        if (! array_key_exists('new_password', $data) || ! filled($data['new_password'])) {
            return $data;
        }

<<<<<<< HEAD
        $this->record->update(['password' => Hash::make($data['new_password'])]);
=======
        // Verifichiamo che record sia un'istanza valida di User
        Assert::notNull($this->record);
        Assert::isInstanceOf($this->record, User::class);
        
        // Gestione sicura del tipo di password per evitare errori di cast
        $newPassword = $data['new_password'];
        
        // Verifichiamo il tipo e convertiamo in modo sicuro
        if (!is_string($newPassword)) {
            if (!is_scalar($newPassword)) {
                throw new \InvalidArgumentException('La password deve essere una stringa');
            }
            $newPassword = (string) $newPassword;
        }
            
        $this->record->update(['password' => Hash::make($newPassword)]);
>>>>>>> 07cc6b5c (.)
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
