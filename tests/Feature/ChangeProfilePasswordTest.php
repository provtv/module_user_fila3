<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\User\Models\User;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class ChangeProfilePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_change_profile_password(): void
    {
        // Crea un utente e un profilo
        /** @var UserContract&Authenticatable&Model $user */
        $user = User::factory()->create([
            'password' => bcrypt('old_password'),
        ]);

        $profileClass = XotData::make()->getProfileClass();
        /** @var ProfileContract $profile */
        $profile = $profileClass::factory()->create([
            'user_id' => $user->id,
        ]);

        // Simula l'autenticazione
        $this->actingAs($user);

        // Esegui il cambio password
        $response = $this->post(route('filament.resources.profiles.change-password', [
            'record' => $profile->id,
        ]), [
            'current_password' => 'old_password',
            'new_password' => 'new_password',
            'new_password_confirmation' => 'new_password',
        ]);

        // Verifica che la risposta sia di successo
        $response->assertSuccessful();

        // Verifica che la password sia stata aggiornata
        $this->assertTrue(Hash::check('new_password', $user->fresh()->password));
    }

    public function test_cannot_change_password_with_wrong_current_password(): void
    {
        // Crea un utente e un profilo
        /** @var UserContract&Authenticatable&Model $user */
        $user = User::factory()->create([
            'password' => bcrypt('old_password'),
        ]);

        $profileClass = XotData::make()->getProfileClass();
        /** @var ProfileContract $profile */
        $profile = $profileClass::factory()->create([
            'user_id' => $user->id,
        ]);

        // Simula l'autenticazione
        $this->actingAs($user);

        // Prova a cambiare la password con la password corrente errata
        $response = $this->post(route('filament.resources.profiles.change-password', [
            'record' => $profile->id,
        ]), [
            'current_password' => 'wrong_password',
            'new_password' => 'new_password',
            'new_password_confirmation' => 'new_password',
        ]);

        // Verifica che la risposta contenga un errore
        $response->assertSessionHasErrors('current_password');

        // Verifica che la password non sia stata cambiata
        $this->assertTrue(Hash::check('old_password', $user->fresh()->password));
    }
} 