<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Support\Carbon;

/**
 * Modules\User\Models\TeamUser.
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser query()
 * @property int $id
 * @property string $uuid
 * @property string|null $team_id
 * @property string|null $user_id
 * @property string|null $role
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $customer_id
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereUuid($value)
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereDeletedBy($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
class TeamUser extends BasePivot
{
<<<<<<< HEAD
    /** @var string */
    protected $connection = 'user';

    /** @var list<string> */
    public $fillable = [
        'id',
        'uuid',
        'team_id',
        'user_id',
        'role',
        'customer_id',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            'team_id' => 'string',
            'user_id' => 'string',
            'role' => 'string',
            'customer_id' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'created_by' => 'string',
            'updated_by' => 'string',
            'deleted_by' => 'string'
        ];
    }
=======
    protected $connection = 'user';
>>>>>>> 07cc6b5c (.)
}
