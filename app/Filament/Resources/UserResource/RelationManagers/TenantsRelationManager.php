<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Modules\User\Filament\Resources\TenantResource\Pages\ListTenants;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;
use Modules\Xot\Filament\Traits\HasXotTable;

/**
 * Manages the relationship between users and tenants.
 *
 * This class provides the form schema and table configuration for the "tenants" relationship
 * with strong typing and enhanced structure for stability and professionalism.
 */
class TenantsRelationManager extends XotBaseRelationManager
{

    protected static string $relationship = 'tenants';

    protected static ?string $recordTitleAttribute = 'name';

    /**
     * Set up the form schema for tenant relations.
     *
     * @return array<\Filament\Forms\Components\Component>
     */
    public function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
        ];
    }

    /**
     * Define table columns for displaying tenant information.
     *
     * @return array<string, \Filament\Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        /** @var array<string, \Filament\Tables\Columns\Column> */
        $columns = app(ListTenants::class)->getTableColumns();
        
        // Ensure we only return Column instances, filter out any Layout\Component instances
        return array_filter($columns, function ($column): bool {
            return $column instanceof \Filament\Tables\Columns\Column;
        });
    }
}
