<?php

namespace Modules\User\App\Filament\Widgets\Auth;

use Filament\Widgets\Widget;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginWidget extends Widget
{
    protected static string $view = 'user::widgets.auth.login-widget';

    public ?array $data = [];

    public function mount(): void
    {
        if (Auth::check()) {
            redirect()->intended(route('dashboard'));
        }

        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('email')
                            ->label(__('user::auth.login.email'))
                            ->email()
                            ->required()
                            ->autocomplete('email')
                            ->placeholder(__('user::auth.login.email_placeholder')),

                        TextInput::make('password')
                            ->label(__('user::auth.login.password'))
                            ->password()
                            ->required()
                            ->autocomplete('current-password')
                            ->placeholder(__('user::auth.login.password_placeholder')),

                        Checkbox::make('remember')
                            ->label(__('user::auth.login.remember')),
                    ])
                    ->columns(1),
            ])
            ->statePath('data');
    }

    public function login(): void
    {
        $data = $this->form->getState();

        if (!Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ], $data['remember'] ?? false)) {
            throw ValidationException::withMessages([
                'data.email' => [__('user::auth.login.failed')],
            ]);
        }

        session()->regenerate();

        redirect()->intended(route('dashboard'));
    }
}
