<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Webmozart\Assert\Assert;

/**
 * 
 *
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole query()
 * @property string $id
 * @property string|null $permission_id
 * @property string|null $role_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class PermissionRole extends BasePivot
{
<<<<<<< HEAD
    /** @var list<string> */
    public $fillable = [
        'id',
        'permission_id',
        'role_id',
        'created_at',
        'updated_at',
        'updated_by',
        'created_by'
    ];
=======
    /**
     * @var list<string>
     *
     * @psalm-var list{'permission_id', 'role_id'}
     */
    protected $fillable = ['permission_id', 'role_id'];
>>>>>>> 07cc6b5c (.)

    public function getTable(): string
    {
        Assert::string($table = config('permission.table_names.role_has_permissions'));

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
            'permission_id' => 'string',
            'role_id' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string'
        ];
=======
    /** @return array<string, string> */
    protected function casts(): array
    {
        $parent = parent::casts();
        $up = [
            'permission_id' => 'string',
            'role_id' => 'string',
        ];

        return array_merge($parent, $up);
>>>>>>> 07cc6b5c (.)
    }
}
