<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\DetachBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TeamsRelationManager extends RelationManager
{
    protected static string $relationship = 'teams';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('personal_team')
                    ->label('Personal Team')
                    ->boolean()
                    ->default(fn ($record, $livewire) => $livewire->getOwnerRecord()->current_team_id === $record->id),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        TextInput::make('role')
                            ->default('editor')
                            ->required(),
                    ]),
            ])
            ->actions([
                DetachAction::make()
                    ->after(function ($record, $livewire): void {
                        $user = $livewire->getOwnerRecord();
                        $team_id = $record->getKey();
                        $user->update([
                            'current_team_id' => null,
                        ]);
                    }),
            ])
            ->bulkActions([
                DetachBulkAction::make(),
            ]);
    }
}
