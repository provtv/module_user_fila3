<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\PermissionResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Modules\User\Filament\Resources\PermissionResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewPermission extends \Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord
{
    protected static string $resource = PermissionResource::class;

    /**
     * @return array<string, \Filament\Infolists\Components\Component>
     */
    public function getInfolistSchema(): array
    {
        return [
            'name' => TextEntry::make('name')
                ->label('Name'),
            'guard_name' => TextEntry::make('guard_name')
                ->label('Guard Name'),
            'active' => TextEntry::make('active')
                ->label('Active')
                ->formatStateUsing(fn ($state): string => $state ? 'Yes' : 'No'),
            'created_at' => TextEntry::make('created_at')
                ->label('Created At')
                ->dateTime(),
        ];
    }
}
