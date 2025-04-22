<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modules\User\Models\TeamPermission
 *
 * @property string $id
 * @property string $team_id
 * @property string $user_id
 * @property string $permission
 * @property \DateTime|null $created_at
 * @property \DateTime|null $updated_at
 * @property Team $team
 * @property User $user
 */
class TeamPermission extends Model
{
    /** @var string */
    protected $connection = 'user';

    /** @var array<string> */
    protected $fillable = [
        'team_id',
        'user_id',
        'permission',
    ];

    /**
     * Get the team that owns the permission.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the user that owns the permission.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
