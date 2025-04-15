<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordWidget extends BaseAuthWidget
{
    protected static string $view = 'user::widgets.auth.reset-password-widget';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('email')
                            ->label(__('user::auth.reset-password.email'))
                            ->email()
                            ->required()
                            ->autocomplete('email')
                            ->placeholder(__('user::auth.reset-password.email_placeholder')),

                        TextInput::make('password')
                            ->label(__('user::auth.reset-password.password'))
                            ->password()
                            ->required()
                            ->minLength(8)
                            ->same('password_confirmation')
                            ->autocomplete('new-password')
                            ->placeholder(__('user::auth.reset-password.password_placeholder')),

                        TextInput::make('password_confirmation')
                            ->label(__('user::auth.reset-password.password_confirmation'))
                            ->password()
                            ->required()
                            ->autocomplete('new-password')
                            ->placeholder(__('user::auth.reset-password.password_confirmation_placeholder')),
                    ])
                    ->columns(1),
            ])
            ->statePath('data');
    }

    public function resetPassword(): void
    {
        $data = $this->form->getState();

        $status = Password::reset(
            [
                'email' => $data['email'],
                'password' => $data['password'],
                'password_confirmation' => $data['password_confirmation'],
                'token' => request()->route('token'),
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('status', __($status));
            redirect()->route('login');
        } else {
            $this->addError('email', __($status));
        }
    }
}
