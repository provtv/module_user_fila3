<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\User\Models\AuthenticationLog;

class RecentLoginsWidget extends BaseWidget
{
    protected static ?string $heading = 'Recent Logins'; // Rendi static la proprietà

    protected int|string|array $columnSpan = 'full';

    /**
     * Define the query to fetch recent logins.
     */
    protected function getTableQuery(): Builder|Relation|null
    {
        return AuthenticationLog::query()
            ->where('login_successful', true)
            ->orderBy('login_at', 'desc')
            ->limit(10); // Mostra gli ultimi 10 logins
    }

    /**
     * Define the columns to display in the table.
     */
    public function getTableColumns(): array
    {
        /** @var array<string, \Filament\Tables\Columns\Column> */
        return [
            \Filament\Tables\Columns\TextColumn::make('user'),
            \Filament\Tables\Columns\TextColumn::make('login_at'),
            \Filament\Tables\Columns\TextColumn::make('ip_address'),
            \Filament\Tables\Columns\TextColumn::make('user_agent'),
        ];
    }

    /**
     * Optionally configure additional table settings.
     * 
     * @return array<string, \Filament\Tables\Actions\Action|\Filament\Tables\Actions\ActionGroup>
     */
    public function getTableActions(): array
    {
        return [
        ];
    }
}
