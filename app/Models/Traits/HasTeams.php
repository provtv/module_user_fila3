<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\User\Contracts\TeamContract;
use Modules\User\Models\Membership;
use Modules\User\Models\Role;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Webmozart\Assert\Assert;
<<<<<<< HEAD
use Modules\User\Models\Team;
=======
>>>>>>> 07cc6b5c (.)

/**
 * Trait HasTeams.
 *
<<<<<<< HEAD
 * @property Team|null $currentTeam
 * @property int|null $current_team_id
 * @property-read Collection<int, Team> $teams
 * @property-read Collection<int, Team> $ownedTeams
=======
 * @property TeamContract $currentTeam
 * @property int|null $current_team_id
 * @property Collection $teams
 * @property Collection $ownedTeams
>>>>>>> 07cc6b5c (.)
 */
trait HasTeams
{
    /**
     * Determine if the given team is the current team.
     */
    public function isCurrentTeam(TeamContract $teamContract): bool
    {
        if ($this->currentTeam === null) {
            return false;
        }

        return $teamContract->getKey() == $this->currentTeam->getKey();
    }

    /**
     * Get the current team of the user's context.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\Modules\User\Contracts\TeamContract, static>
     */
    public function currentTeam(): BelongsTo
    {
<<<<<<< HEAD
        /** @var class-string<Team> $teamClass */
        $teamClass = XotData::make()->getTeamClass();
=======
        $xot = XotData::make();
        if ($this->current_team_id === null && $this->id) {
            $this->switchTeam($this->personalTeam());
        }

        if ($this->allTeams()->isEmpty() && $this->getKey() !== null) {
            $this->current_team_id = null;
            $this->save();
        }

        $teamClass = $xot->getTeamClass();

>>>>>>> 07cc6b5c (.)
        return $this->belongsTo($teamClass, 'current_team_id');
    }

    /**
     * Switch the user's context to the given team.
     */
<<<<<<< HEAD
    public function switchTeam(Team $team): bool
    {
        if (! $this->belongsToTeam($team)) {
            return false;
        }

        $this->forceFill([
            'current_team_id' => $team->id,
        ])->save();

        $this->setRelation('currentTeam', $team);
=======
    public function switchTeam(?TeamContract $teamContract): bool
    {
        if (! $teamContract instanceof TeamContract || ! $this->belongsToTeam($teamContract)) {
            return false;
        }

        $this->forceFill(['current_team_id' => $teamContract->getKey()])->save();
        $this->setRelation('currentTeam', $teamContract);
>>>>>>> 07cc6b5c (.)

        return true;
    }

    /**
     * Get all of the teams the user owns or belongs to.
     *
     * @return Collection<TeamContract>
     */
    public function allTeams(): Collection
    {
<<<<<<< HEAD
        return $this->teams()->get();
=======
        return $this->ownedTeams->merge($this->teams)->sortBy('name');
>>>>>>> 07cc6b5c (.)
    }

    /**
     * Get all of the teams the user owns.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\Modules\User\Contracts\TeamContract>
     */
    public function ownedTeams(): HasMany
    {
<<<<<<< HEAD
        /** @var class-string<Team> $teamClass */
        $teamClass = XotData::make()->getTeamClass();
        return $this->hasMany($teamClass, 'user_id');
=======
        $xot = XotData::make();
        $teamClass = $xot->getTeamClass();

        return $this->hasMany($teamClass);
>>>>>>> 07cc6b5c (.)
    }

    /**
     * Get all of the teams the user belongs to.
     * 
<<<<<<< HEAD
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\Modules\User\Contracts\TeamContract>
     */
    public function teams(): BelongsToMany
    {
        /** @var class-string<Team> $teamClass */
        $teamClass = XotData::make()->getTeamClass();
        return $this->belongsToMany($teamClass)
            ->withPivot('role')
            ->withTimestamps()
            ->as('membership');
=======
     * @return BelongsToMany<\Modules\User\Contracts\TeamContract, static>
     * @phpstan-return BelongsToMany<\Modules\User\Contracts\TeamContract&\Illuminate\Database\Eloquent\Model, static>
     */
    public function teams(): BelongsToMany
    {
        $xot = XotData::make();
        $teamClass = $xot->getTeamClass();

        return $this->belongsToManyX($teamClass, null, null, 'team_id');
        // ->as('membership')
>>>>>>> 07cc6b5c (.)
    }

    /**
     * Get the user's "personal" team.
     */
    public function personalTeam(): ?TeamContract
    {
        $personalTeam = $this->ownedTeams->where('personal_team', true)->first();
        if ($personalTeam === null) {
            return null;
        }

        Assert::nullOrIsInstanceOf($personalTeam, TeamContract::class, 'Personal team must implement TeamContract.');

        return $personalTeam;
    }

    /**
     * Determine if the user owns the given team.
     */
<<<<<<< HEAD
    public function ownsTeam(Team $team): bool
    {
        return $this->ownedTeams()->where('id', $team->id)->exists();
=======
    public function ownsTeam(?TeamContract $teamContract): bool
    {
        return $teamContract instanceof TeamContract && $this->id === $teamContract->{$this->getForeignKey()};
>>>>>>> 07cc6b5c (.)
    }

    /**
     * Determine if the user belongs to the given team.
     */
<<<<<<< HEAD
    public function belongsToTeam(Team $team): bool
    {
        return $this->teams()->where('team_id', $team->id)->exists();
=======
    public function belongsToTeam(?TeamContract $teamContract): bool
    {
        return $teamContract instanceof TeamContract
            && ($this->ownsTeam($teamContract) || $this->teams->contains(fn($team) => $team->getKey() === $teamContract->getKey()));
>>>>>>> 07cc6b5c (.)
    }

    /**
     * Get the role that the user has on the team.
     */
<<<<<<< HEAD
    public function teamRole(Team $team): ?Role
    {
        if (! $this->belongsToTeam($team)) {
            return null;
        }

        $pivot = $this->teams()->where('team_id', $team->id)->first()?->pivot;
        return $pivot ? Role::findByName($pivot->role) : null;
=======
    public function teamRole(TeamContract $teamContract): ?Role
    {
        if (! $this->belongsToTeam($teamContract)) {
            return null;
        }

        // Troviamo l'utente all'interno del team
        $user = $teamContract->users()->where('id', $this->id)->first();

        // Verifica che l'utente esista e sia del tipo corretto
        Assert::notNull($user, 'User not found in team.');
        Assert::isInstanceOf($user, XotData::make()->getUserClass(), 'Invalid user type.');

        /**
         * @var Model&UserContract $user
         */
        $membership = $user->getRelationValue('membership');

        // Verifica che il membership esista e sia del tipo corretto
        Assert::notNull($membership, 'Membership not found.');
        Assert::isInstanceOf($membership, Membership::class, 'Invalid membership type.');

        // Ora che sappiamo che $membership è un'istanza di Membership, possiamo accedere a $membership->role
        return Role::firstOrCreate(
            ['name' => $membership->role],
            []
        );
    }

    /**
     * Determine if the user has the given role on the given team.
     */
    public function hasTeamRole(TeamContract $teamContract, string $role): bool
    {
        if ($this->ownsTeam($teamContract)) {
            return true;
        }

        /*
        return $this->belongsToTeam($teamContract) && optional(FilamentJet::findRole($teamContract->users->where(
            'id',
            $this->id
        )->first()?->membership->role))->key === $role;
        */
        return $this->belongsToTeam($teamContract) && $this->teamRole($teamContract) !== null;
>>>>>>> 07cc6b5c (.)
    }

    /**
     * Get the user's permissions for the given team.
     */
<<<<<<< HEAD
    public function teamPermissions(Team $team): array
    {
        $role = $this->teamRole($team);
        return $role ? $role->permissions->pluck('name')->toArray() : [];
=======
    public function teamPermissions(TeamContract $teamContract): array
    {
        if ($this->ownsTeam($teamContract)) {
            return ['*'];
        }

        return (array) $this->teamRole($teamContract)->permissions;
>>>>>>> 07cc6b5c (.)
    }

    /**
     * Determine if the user has the given permission on the given team.
     */
<<<<<<< HEAD
    public function hasTeamPermission(Team $team, string $permission): bool
    {
        return $this->belongsToTeam($team) && in_array($permission, $this->teamPermissions($team), true);
=======
    public function hasTeamPermission(TeamContract $teamContract, string $permission): bool
    {
        if ($this->ownsTeam($teamContract)) {
            return true;
        }

        $permissions = $this->teamPermissions($teamContract);

        return in_array($permission, $permissions, true)
            || in_array('*', $permissions, true)
            || (Str::endsWith($permission, ':create') && in_array('*:create', $permissions, true))
            || (Str::endsWith($permission, ':update') && in_array('*:update', $permissions, true));
>>>>>>> 07cc6b5c (.)
    }

    /**
     * Invite a user to a team.
     */
    public function inviteToTeam(UserContract $user, TeamContract $team): bool
    {
        if ($this->ownsTeam($team)) {
            $team->members()->attach($user->id, ['role' => 'member']);

            return true;
        }

        return false;
    }

    /**
     * Remove a user from the team.
     */
    public function removeFromTeam(UserContract $user, TeamContract $team): bool
    {
        if ($this->ownsTeam($team)) {
            $team->members()->detach($user->id);

            return true;
        }

        return false;
    }

    /**
     * Check if the user is an owner or a member.
     */
    public function isOwnerOrMember(TeamContract $team): bool
    {
        return $this->ownsTeam($team) || $this->belongsToTeam($team);
    }

    /**
     * Promote a member to team admin.
     */
    public function promoteToAdmin(UserContract $user, TeamContract $team): bool
    {
        if ($this->ownsTeam($team)) {
            $team->members()->updateExistingPivot($user->id, ['role' => 'admin']);

            return true;
        }

        return false;
    }

    /**
     * Demote a member from team admin.
     */
    public function demoteFromAdmin(UserContract $user, TeamContract $team): bool
    {
        if ($this->ownsTeam($team)) {
            $team->members()->updateExistingPivot($user->id, ['role' => 'member']);

            return true;
        }

        return false;
    }

    /**
     * Get all admins of the team.
     */
    public function getTeamAdmins(TeamContract $team): Collection
    {
        return $team->members()->wherePivot('role', 'admin')->get();
    }

    /**
     * Get all members of the team.
     */
    public function getTeamMembers(TeamContract $team): Collection
    {
        return $team->members()->wherePivot('role', 'member')->get();
    }
<<<<<<< HEAD

    public function canManageTeam(Team $team): bool
    {
        return $this->ownsTeam($team) || $this->hasTeamPermission($team, 'manage');
    }

    public function canAddTeamMembers(Team $team): bool
    {
        return $this->ownsTeam($team) || $this->hasTeamPermission($team, 'add_team_members');
    }

    public function canDeleteTeam(Team $team): bool
    {
        return $this->ownsTeam($team);
    }

    public function canRemoveTeamMembers(Team $team): bool
    {
        return $this->ownsTeam($team) || $this->hasTeamPermission($team, 'remove_team_members');
    }

    public function canUpdateTeam(Team $team): bool
    {
        return $this->ownsTeam($team) || $this->hasTeamPermission($team, 'update_team');
    }

    public function createTeam(array $input): Team
    {
        /** @var class-string<Team> $teamClass */
        $teamClass = XotData::make()->getTeamClass();

        /** @var Team $team */
        $team = $this->ownedTeams()->create([
            'name' => $input['name'],
            'personal_team' => $input['personal_team'] ?? false,
        ]);

        $this->switchTeam($team);

        return $team;
    }

    public function updateTeamName(Team $team, string $name): void
    {
        if ($this->canUpdateTeam($team)) {
            $team->forceFill([
                'name' => $name,
            ])->save();
        }
    }

    public function addTeamMember(Team $team, string $email, string $role = null): void
    {
        if ($this->canAddTeamMembers($team)) {
            /** @var class-string<Model&UserContract> $userClass */
            $userClass = XotData::make()->getUserClass();

            /** @var Model&UserContract $newTeamMember */
            $newTeamMember = $userClass::where('email', $email)->firstOrFail();

            $team->users()->attach(
                $newTeamMember,
                ['role' => $role]
            );
        }
    }

    public function removeTeamMember(Team $team, int $userId): void
    {
        if ($this->canRemoveTeamMembers($team)) {
            $team->users()->detach($userId);
        }
    }

    public function deleteTeam(Team $team): void
    {
        if ($this->canDeleteTeam($team)) {
            $team->delete();
        }
    }
=======
>>>>>>> 07cc6b5c (.)
}
