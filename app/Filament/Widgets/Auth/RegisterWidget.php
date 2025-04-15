<?php

namespace Modules\User\App\Filament\Widgets\Auth;

use Filament\Widgets\Widget;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Modules\User\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class RegisterWidget extends Widget
{
    protected static string $view = 'user::widgets.auth.register-widget';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

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
                            ->unique(table: User::class)
                            ->autocomplete('email')
                            ->placeholder(__('user::auth.register.email_placeholder')),

                        TextInput::make('password')
                            ->label(__('user::auth.register.password'))
                            ->password()
                            ->required()
                            ->rule(Password::default())
                            ->autocomplete('new-password')
                            ->placeholder(__('user::auth.register.password_placeholder')),

                        TextInput::make('password_confirmation')
                            ->label(__('user::auth.register.password_confirmation'))
                            ->password()
                            ->required()
                            ->same('password')
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
