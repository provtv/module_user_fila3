<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Filament\Panel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Modules\User\Contracts\TeamContract;
use Modules\User\Models\Tenant;
=======
use Illuminate\Support\Collection;
use Modules\User\Contracts\TeamContract;
>>>>>>> 07cc6b5c (.)
use Modules\Xot\Datas\XotData;

// use Modules\User\Models\OwnerRole;

/**
 * @property TeamContract $currentTeam
<<<<<<< HEAD
 * @property-read Collection<int, Tenant> $tenants
 * @property-read Collection<int, Tenant> $ownedTenants
=======
>>>>>>> 07cc6b5c (.)
 */
trait HasTenants
{
    /**
     * ..
     **/
    public function canAccessTenant(Model $tenant): bool
    {
        // return $this->teams->contains($tenant);
        return $this->tenants()->whereKey($tenant)->exists();
        // return true;
    }

    public function getTenants(Panel $panel): array|Collection
    {
        return $this->tenants;
    }

    /**
     * Get all of the tenants the user belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\Illuminate\Database\Eloquent\Model>
     */
    public function tenants(): BelongsToMany
    {
<<<<<<< HEAD
        /** @var class-string<Tenant> $tenantClass */
        $tenantClass = XotData::make()->getTenantClass();
        return $this->belongsToMany($tenantClass)
            ->withTimestamps()
            ->withPivot('role');
    }

    public function ownedTenants(): HasMany
    {
        /** @var class-string<Tenant> $tenantClass */
        $tenantClass = XotData::make()->getTenantClass();
        return $this->hasMany($tenantClass, 'owner_id');
    }

    public function belongsToTenant(Tenant $tenant): bool
    {
        return $this->tenants()->where('tenant_id', $tenant->id)->exists();
    }

    public function ownsTenant(Tenant $tenant): bool
    {
        return $this->ownedTenants()->where('id', $tenant->id)->exists();
    }

    public function createTenant(array $input): Tenant
    {
        /** @var class-string<Tenant> $tenantClass */
        $tenantClass = XotData::make()->getTenantClass();

        /** @var Tenant $tenant */
        $tenant = $this->ownedTenants()->create([
            'name' => $input['name'],
            'domain' => $input['domain'] ?? null,
            'settings' => $input['settings'] ?? [],
        ]);

        return $tenant;
    }

    public function canManageTenant(Tenant $tenant): bool
    {
        return $this->ownsTenant($tenant) || $this->hasRole('admin');
    }

    public function canUpdateTenant(Tenant $tenant): bool
    {
        return $this->canManageTenant($tenant);
    }

    public function canDeleteTenant(Tenant $tenant): bool
    {
        return $this->ownsTenant($tenant);
    }

    public function updateTenant(Tenant $tenant, array $input): void
    {
        if ($this->canUpdateTenant($tenant)) {
            $tenant->forceFill([
                'name' => $input['name'],
                'domain' => $input['domain'] ?? $tenant->domain,
                'settings' => array_merge($tenant->settings ?? [], $input['settings'] ?? []),
            ])->save();
        }
    }

    public function deleteTenant(Tenant $tenant): void
    {
        if ($this->canDeleteTenant($tenant)) {
            $tenant->delete();
        }
    }

    public function addTenantMember(Tenant $tenant, string $email, string $role = null): void
    {
        if ($this->canManageTenant($tenant)) {
            /** @var class-string<\Illuminate\Database\Eloquent\Model&\Modules\Xot\Contracts\UserContract> $userClass */
            $userClass = XotData::make()->getUserClass();

            /** @var \Illuminate\Database\Eloquent\Model&\Modules\Xot\Contracts\UserContract $newMember */
            $newMember = $userClass::where('email', $email)->firstOrFail();

            $tenant->users()->attach(
                $newMember,
                ['role' => $role]
            );
        }
    }

    public function removeTenantMember(Tenant $tenant, int $userId): void
    {
        if ($this->canManageTenant($tenant)) {
            $tenant->users()->detach($userId);
        }
=======
        $xot = XotData::make();
        /** @var class-string<Model> */
        $tenant_class = $xot->getTenantClass();

        // $this->setConnection('mysql');
        return $this->belongsToManyX($tenant_class, null, null, 'tenant_id');
        // ->as('membership')
>>>>>>> 07cc6b5c (.)
    }
}
