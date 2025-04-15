<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Filament\Facades\Filament;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Contracts\TeamContract;
use Modules\User\Models\Scopes\TenantScope;
=======
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Contracts\TeamContract;
use Modules\User\Models\Scopes\TenantScope;
use Modules\User\Models\Tenant;
>>>>>>> 07cc6b5c (.)
use Modules\Xot\Datas\XotData;

/**
 * @property TeamContract $currentTeam
 */
trait InteractsWithTenant
{
    /**
<<<<<<< HEAD
=======
     * Tenant corrente.
     *
     * @var Model|null
     */
    protected ?Model $currentTenant = null;

    /**
>>>>>>> 07cc6b5c (.)
     * Relazione con il tenant a cui appartiene il modello.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\Illuminate\Database\Eloquent\Model, self>
     * @phpstan-return \Illuminate\Database\Eloquent\Relations\BelongsTo<\Illuminate\Database\Eloquent\Model, $this>
     */
    public function tenant(): BelongsTo
    {
<<<<<<< HEAD
        /** @var class-string<\Illuminate\Database\Eloquent\Model> $class */
        $class = XotData::make()->getTenantClass();

        return $this->belongsTo($class);
=======
        $tenant = $this->getTenant();
        if ($tenant === null) {
            $this->loadTenantFromSession();
            $tenant = $this->getTenant();
        }

        $tenantClass = config('tenant.tenant_model', Tenant::class);

        // @phpstan-ignore-next-line
        return $this->belongsTo($tenantClass, 'tenant_id');
    }

    /**
     * Ottiene il tenant corrente.
     *
     * @return Model|null
     */
    protected function getTenant(): ?Model
    {
        return $this->currentTenant;
    }

    /**
     * Carica il tenant dalla sessione.
     *
     * @return void
     */
    protected function loadTenantFromSession(): void
    {
        try {
            $this->currentTenant = Filament::getTenant();
        } catch (\Throwable $e) {
            // Se Filament non è disponibile, lascia il tenant come null
            $this->currentTenant = null;
        }
>>>>>>> 07cc6b5c (.)
    }

    /**
     * The "booted" method of the model.
     */
    protected static function bootInteractsWithTenant(): void
    {
        static::addGlobalScope(new TenantScope);

        static::creating(
            static function ($model): void {
                if ($model !== null) {
<<<<<<< HEAD
                    $model->tenant_id = Filament::getTenant()->getKey();
=======
                    $tenant = Filament::getTenant();
                    if ($tenant !== null) {
                        $model->tenant_id = $tenant->getKey();
                    }
>>>>>>> 07cc6b5c (.)
                }
            }
        );
    }

    /**
     * Interact with the user's first name.
     */
    protected function setTenantIdAttribute(?int $value): void
    {
<<<<<<< HEAD
        if ($value === null) {
            $value = Filament::getTenant()->getKey();
        }
        $this->attributes['tenant_id'] = $value;
=======
        $tenant = Filament::getTenant();
        if ($value === null && $tenant !== null) {
            $tenantId = $tenant->getKey();
            if (is_int($tenantId)) {
                $value = $tenantId;
            }
        }

        if ($value !== null) {
            $this->attributes['tenant_id'] = $value;
        }
    }

    /**
     * Applica lo scope del tenant.
     */
    protected function applyTenantScope(): void
    {
        $tenant = $this->getTenant();
        if ($tenant === null) {
            $this->loadTenantFromSession();
            $tenant = $this->getTenant();
        }

        if ($tenant !== null) {
            $tenantId = $tenant->getKey();
            if ($tenantId !== null) {
                static::addGlobalScope(new TenantScope());
            }
        }
>>>>>>> 07cc6b5c (.)
    }
}
