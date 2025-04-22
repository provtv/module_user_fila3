<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TeamResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\User\Filament\Resources\UserResource;
use Modules\Xot\Filament\Resources\XotBaseResource\RelationManager\XotBaseRelationManager;
use Filament\Tables;

class UsersRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $inverseRelationship = 'teams';

    protected static ?string $recordTitleAttribute = 'name';

    /**
     * @return array<string, \Filament\Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name'),
            'email' => TextColumn::make('email'),
            'role' => TextColumn::make('role'),
        ];
    }
    
    /**
     * @return array<string, \Filament\Tables\Actions\Action>
     */
    public function getTableHeaderActions(): array
    {
        return [
            'attach' => Tables\Actions\AttachAction::make(),
        ];
    }
    
    /**
     * @return array<string, \Filament\Tables\Actions\Action|\Filament\Tables\Actions\ActionGroup>
     */
    public function getTableActions(): array
    {
        return [
            'view' => Tables\Actions\ViewAction::make(),
            'edit' => Tables\Actions\EditAction::make(),
            'detach' => Tables\Actions\DetachAction::make(),
            'delete' => Tables\Actions\DeleteAction::make(),
        ];
    }
    
    /**
     * @return array<string, \Filament\Tables\Actions\BulkAction>
     */
    public function getTableBulkActions(): array
    {
        return [
            'detach' => Tables\Actions\DetachBulkAction::make(),
            'delete' => Tables\Actions\DeleteBulkAction::make(),
        ];
    }
}
