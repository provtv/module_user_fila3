<?php

declare(strict_types=1);

/**
 * @see https://github.com/savannabits/filament-tenancy-starter/blob/main/app/Filament/resources/TenantResource.php
 */

namespace Modules\User\Filament\Resources;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;
use Modules\User\Filament\Resources\TenantResource\Pages\CreateTenant;
use Modules\User\Filament\Resources\TenantResource\Pages\EditTenant;
use Modules\User\Filament\Resources\TenantResource\Pages\ListTenants;
use Modules\User\Filament\Resources\TenantResource\Pages\ViewTenant;
use Modules\User\Filament\Resources\TenantResource\RelationManagers;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Modules\Xot\Services\XotService;

use Modules\Xot\Filament\Resources\XotBaseResource\RelationManager\XotBaseRelationManager;

class TenantResource extends XotBaseResource
{
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * Get the model class name for this resource.
     *
     * @return class-string<\Illuminate\Database\Eloquent\Model>
     */
    public static function getModel(): string
    {
        $xot = app(XotService::class);
        return $xot->getTenantClass();
    }

    public static function getFormSchema(): array
    {
        return [
            Section::make()
                ->schema([
                        TextInput::make('name')
                            ->required()
                            ->unique(table: 'tenants', ignoreRecord: true)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (callable $set, $state) {
                                $set('slug', Str::slug($state));
                                $set('domain', Str::slug($state));
                            })
                            ->columnSpanFull()
                            ->placeholder('Nome del tenant')
                            ->helperText('Inserisci il nome del tenant'),

                        TextInput::make('slug')
                            ->required()
                            ->disabled(fn ($context) => $context !== 'create')
                            ->unique(table: 'tenants', ignoreRecord: true)
                            ->helperText('Lo slug verrà generato automaticamente dal nome'),

                        TextInput::make('domain')
                            ->required()
                            ->visible(fn ($context) => $context === 'create')
                            ->unique(table: 'domains', ignoreRecord: true)
                            ->prefix('https://')
                            ->suffix('.'.request()->getHost())
                            ->placeholder('dominio')
                            ->helperText('Il dominio del tenant'),

                        TextInput::make('email_address')
                            ->email()
                            ->placeholder('email@example.com')
                            ->helperText('Indirizzo email del tenant'),

                        TextInput::make('phone')
                            ->tel()
                            ->placeholder('Telefono')
                            ->helperText('Numero di telefono del tenant'),

                        TextInput::make('mobile')
                            ->tel()
                            ->placeholder('Cellulare')
                            ->helperText('Numero di cellulare del tenant'),

                        TextInput::make('address')
                            ->placeholder('Indirizzo')
                            ->helperText('Indirizzo del tenant'),

                        ColorPicker::make('primary_color')
                            ->helperText('Colore primario del tenant'),

                        ColorPicker::make('secondary_color')
                            ->helperText('Colore secondario del tenant'),
                    ])
                    ->columns(2)
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // RelationManagers\DomainsRelationManager::class,
            RelationManagers\UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTenants::route('/'),
            'create' => CreateTenant::route('/create'),
            'view' => ViewTenant::route('/{record}'),
            'edit' => EditTenant::route('/{record}/edit'),
        ];
    }
}
