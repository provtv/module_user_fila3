<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\User\Models\User;

class RegisterWidget extends BaseAuthWidget
{
    protected static string $view = 'user::widgets.auth.register-widget';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->label(__('user::auth.register.name'))
                            ->required()
                            ->maxLength(255)
                            ->autocomplete('name')
                            ->placeholder(__('user::auth.register.name_placeholder')),

                        TextInput::make('email')
                            ->label(__('user::auth.register.email'))
                            ->email()
                            ->required()
                            ->unique('users', 'email')
                            ->autocomplete('email')
                            ->placeholder(__('user::auth.register.email_placeholder')),

                        TextInput::make('password')
                            ->label(__('user::auth.register.password'))
                            ->password()
                            ->required()
                            ->minLength(8)
                            ->same('password_confirmation')
                            ->autocomplete('new-password')
                            ->placeholder(__('user::auth.register.password_placeholder')),

                        TextInput::make('password_confirmation')
                            ->label(__('user::auth.register.password_confirmation'))
                            ->password()
                            ->required()
                            ->autocomplete('new-password')
                            ->placeholder(__('user::auth.register.password_confirmation_placeholder')),
                    ])
                    ->columns(1),
            ])
            ->statePath('data');
    }

    public function register(): void
    {
        $data = $this->form->getState();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        redirect()->intended(route('dashboard'));
    }
}
