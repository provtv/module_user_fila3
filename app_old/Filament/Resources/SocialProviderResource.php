<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Modules\User\Filament\Resources\SocialProviderResource\Pages;
use Modules\User\Models\SocialProvider;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * @property SocialProvider $record
 *                                  -------
 */
class SocialProviderResource extends XotBaseResource
{
    protected static ?string $model = SocialProvider::class;

    public static function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->placeholder(static::trans('fields.name.placeholder'))
                ->helperText(static::trans('fields.name.helper_text')),

            KeyValue::make('scopes')
                // ->placeholder(static::trans('fields.scopes.placeholder'))
                ->helperText(static::trans('fields.scopes.helper_text')),

            KeyValue::make('parameters')
                // ->placeholder(static::trans('fields.parameters.placeholder'))
                ->helperText(static::trans('fields.parameters.helper_text')),

            Toggle::make('stateless')
                ->helperText(static::trans('fields.stateless.helper_text')),

            Toggle::make('active')
                ->helperText(static::trans('fields.active.helper_text')),

            Toggle::make('socialite')
                ->helperText(static::trans('fields.socialite.helper_text')),

            Textarea::make('svg')
                ->columnSpanFull()
                ->placeholder(static::trans('fields.svg.placeholder'))
                ->helperText(static::trans('fields.svg.helper_text')),
        ];
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSocialProviders::route('/'),
            'create' => Pages\CreateSocialProvider::route('/create'),
            'view' => Pages\ViewSocialProvider::route('/{record}'),
            'edit' => Pages\EditSocialProvider::route('/{record}/edit'),
        ];
    }
}
