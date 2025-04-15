<?php

/**
 * ---.
 */

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Models\Traits\RelationX;
use Spatie\Permission\Models\Role as SpatieRole;
use Webmozart\Assert\Assert;

/**
 * Modules\User\Models\Role.
 *
 * @property string $id
 * @property string $uuid
 * @property string|null $team_id
 * @property string $name
 * @property string $guard_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Collection<int, Permission> $permissions
 * @property int|null $permissions_count
 * @property Team|null $team
 * @property EloquentCollection<int, Model&UserContract> $users
 * @property int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUuid($value)
 * @property int $id
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedBy($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Role withoutPermission($permissions)
 * @property PermissionRole|null $pivot
 * @mixin \Eloquent
 */
class Role extends SpatieRole
{
    use HasFactory;
    use RelationX;

    // use HasUuids;

    final public const ROLE_ADMINISTRATOR = 1;

    final public const ROLE_OWNER = 2;

    final public const ROLE_USER = 3;

    /** @var string */
    protected $connection = 'user';

    /** @var string */
    protected $keyType = 'string';

<<<<<<< HEAD
    /** @var list<string> */
    public $fillable = [
        'id',
        'name',
        'guard_name',
        'created_at',
        'updated_at',
        'updated_by',
        'created_by'
    ];
=======
    // protected $fillable=['id','']
>>>>>>> 07cc6b5c (.)

    public function getTable(): string
    {
        Assert::string($table = config('permission.table_names.roles'));

        return $table;
    }

<<<<<<< HEAD
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'id' => 'string',
=======
    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
>>>>>>> 07cc6b5c (.)
            'name' => 'string',
            'guard_name' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
<<<<<<< HEAD
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string'
=======
>>>>>>> 07cc6b5c (.)
        ];
    }

    /**
     * Get all of the teams the user belongs to.
     */
    public function team(): BelongsTo
    {
        $xotData = XotData::make();
        /** @var class-string<Model> */
        $teamClass = $xotData->getTeamClass();

        return $this->belongsTo($teamClass);
    }

    /**
     * A role may be given various permissions.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToManyX(Permission::class);
    }
}
