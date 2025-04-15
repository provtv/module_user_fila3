<?php

declare(strict_types=1);

namespace Modules\User\Models\Scopes;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
<<<<<<< HEAD

=======
use Modules\User\Models\Tenant;

/**
 * Scope che limita le query ai record associati al tenant corrente.
 */
>>>>>>> 07cc6b5c (.)
class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
<<<<<<< HEAD
        $tenant_id = Filament::getTenant()->getKey();
=======
        $tenant_id = Filament::getTenant()?->getKey();
>>>>>>> 07cc6b5c (.)
        if ($tenant_id !== null) {
            $builder->where('tenant_id', '=', $tenant_id);
        }
    }
}
