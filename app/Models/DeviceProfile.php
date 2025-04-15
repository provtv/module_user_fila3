<?php

declare(strict_types=1);

namespace Modules\User\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Xot\Contracts\ProfileContract;

/**
 * Class DeviceProfile.
 *
 * @property ProfileContract|null $creator
 * @property Device|null          $device
 * @property ProfileContract|null $profile
 * @property ProfileContract|null $updater
 * @property User|null            $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile query()
 *
 * @mixin \Eloquent
 */
class DeviceProfile extends BaseModel
{
    /** @var list<string> */
    protected $fillable = [
        'device_id',
        'user_id',
        'profile_id',
        'creator_id',
        'updater_id',
    ];

    /**
     * @return BelongsTo<Device, DeviceProfile>
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    /**
     * @return BelongsTo<User, DeviceProfile>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<ProfileContract, DeviceProfile>
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(ProfileContract::class);
    }

    /**
     * @return BelongsTo<ProfileContract, DeviceProfile>
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(ProfileContract::class, 'creator_id');
    }

    /**
     * @return BelongsTo<ProfileContract, DeviceProfile>
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(ProfileContract::class, 'updater_id');
    }
}
=======
/**
 * 
 *
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property Device|null $device
 * @property \Modules\Xot\Contracts\ProfileContract|null $profile
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @property User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile query()
 * @mixin \Eloquent
 */
class DeviceProfile extends DeviceUser {}
>>>>>>> 07cc6b5c (.)
