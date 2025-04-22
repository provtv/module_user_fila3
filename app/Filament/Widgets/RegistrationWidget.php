<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Filament\Forms\Form;
use Filament\Widgets\Widget;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Auth\Events\Registered;
use Filament\Forms\Components\Checkbox;
use Modules\Xot\Contracts\UserContract;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;

class RegistrationWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'user::filament.widgets.registration';
    protected int | string | array $columnSpan = 'full';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Dati Personali')
                        ->icon('heroicon-o-user')
                        ->description('Inserisci i tuoi dati personali')
                        ->schema([
                            TextInput::make('name')
                                ->label('Nome')
                                ->placeholder('Inserisci il tuo nome')
                                ->required()
                                ->maxLength(255)
                                ->prefixIcon('heroicon-o-user')
                                ->extraAttributes(['class' => 'bg-blue-50/30']),

                            TextInput::make('surname')
                                ->label('Cognome')
                                ->placeholder('Inserisci il tuo cognome')
                                ->required()
                                ->maxLength(255)
                                ->prefixIcon('heroicon-o-identification')
                                ->extraAttributes(['class' => 'bg-blue-50/30']),

                            TextInput::make('email')
                                ->label('Email')
                                ->placeholder('La tua email sarà usata per l\'accesso')
                                ->email()
                                ->required()
                                ->unique('users')
                                ->maxLength(255)
                                ->prefixIcon('heroicon-o-envelope')
                                ->extraAttributes(['class' => 'bg-blue-50/30']),
                        ]),

                    Step::make('Credenziali')
                        ->icon('heroicon-o-key')
                        ->description('Crea le tue credenziali di accesso')
                        ->schema([
                            TextInput::make('password')
                                ->label('Password')
                                ->placeholder('Minimo 8 caratteri')
                                ->password()
                                ->required()
                                ->minLength(8)
                                ->same('password_confirmation')
                                ->prefixIcon('heroicon-o-lock-closed')
                                ->extraAttributes(['class' => 'bg-blue-50/30']),

                            TextInput::make('password_confirmation')
                                ->label('Conferma Password')
                                ->placeholder('Ripeti la password')
                                ->password()
                                ->required()
                                ->minLength(8)
                                ->prefixIcon('heroicon-o-check-circle')
                                ->extraAttributes(['class' => 'bg-blue-50/30']),
                        ]),

                    Step::make('Privacy')
                        ->icon('heroicon-o-lock-closed')
                        ->description('Informativa sulla privacy')
                        ->schema([
                            Checkbox::make('terms')
                                ->label(new HtmlString('Accetto i <a href="#" class="text-blue-800 hover:underline font-medium">Termini di Servizio</a> e l\'<a href="#" class="text-blue-800 hover:underline font-medium">Informativa sulla Privacy</a>'))
                                ->required()
                                ->extraAttributes(['class' => 'mt-2 border-blue-300']),

                            Checkbox::make('newsletter')
                                ->label(new HtmlString('Desidero ricevere aggiornamenti via email sul progetto <span class="font-medium">SaluteOra</span>'))
                                ->helperText('Potrai disiscriverti in qualsiasi momento')
                                ->extraAttributes(['class' => 'mt-4 border-blue-300']),
                        ]),
                ])
                ->skippable(false)
                ->submitAction(new HtmlString('<button type="submit" class="w-full bg-blue-900 text-white text-lg font-medium py-3 px-6 rounded-full hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-opacity-50 shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-center">
                    <span>COMPLETA REGISTRAZIONE</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>'))
            ])
            ->statePath('data');
    }

    public function register(): \Illuminate\Http\RedirectResponse
    {
        $state = $this->form->getState();

        /** @var UserContract $user */
        $user = app(UserContract::class)::create([
            'name' => $state['name'],
            'surname' => $state['surname'],
            'email' => $state['email'],
            'password' => Hash::make($state['password']),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('filament.admin.pages.dashboard');
    }
}
