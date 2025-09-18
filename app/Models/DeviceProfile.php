<?php

declare(strict_types=1);

namespace Modules\User\Models;

/**
 * DeviceProfile Model
 * 
 * Represents the relationship between a device and a user profile.
 * Extends the base DeviceUser model to add specific functionality.
 *
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property Device|null $device
 * @property \Modules\Xot\Contracts\ProfileContract|null $profile
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @property User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile query()
 * @mixin IdeHelperDeviceProfile
 * @mixin \Eloquent
 */
class DeviceProfile extends DeviceUser
{
    /**
     * Create a new model instance.
     *
     * @param array<string, mixed> $attributes
     */
    public function __construct(): void {
        parent::__construct($attributes);
    }
}
