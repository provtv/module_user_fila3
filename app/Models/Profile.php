<?php

declare(strict_types=1);

namespace Modules\User\Models;

/**
 * 
 *
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes $extra
 * @property-read string $avatar
 * @property-read \Modules\Broker\Models\Profile|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\DeviceUser> $deviceUsers
 * @property-read int|null $device_users_count
 * @property-read \Modules\User\Models\ProfileTeam|\Modules\User\Models\DeviceProfile|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Device> $devices
 * @property-read int|null $devices_count
 * @property-read string|null $first_name
 * @property-read string|null $full_name
 * @property-read string|null $last_name
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\DeviceUser> $mobileDeviceUsers
 * @property-read int|null $mobile_device_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Device> $mobileDevices
 * @property-read int|null $mobile_devices_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Team> $teams
 * @property-read int|null $teams_count
 * @property-read \Modules\Broker\Models\Profile|null $updater
 * @property-read \Modules\Broker\Models\User|null $user
 * @property-read string|null $user_name
 * @method static \Modules\User\Database\Factories\ProfileFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withoutRole($roles, $guard = null)
 * @mixin \Eloquent
 */
<<<<<<< HEAD
class Profile extends BaseProfile
{
    /** @var list<string> */
    public $fillable = [
        'id',
        'user_id',
        'first_name',
        'last_name',
        'full_name',
        'email',
        'is_active',
        'extra',
        'avatar',
        'credits',
        'slug',
        'oauth_enable',
        'credentials_enable',
        'created_at',
        'updated_at',
        'updated_by',
        'created_by'
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
            'user_id' => 'string',
            'first_name' => 'string',
            'last_name' => 'string',
            'full_name' => 'string',
            'email' => 'string',
            'is_active' => 'bool',
            'extra' => 'array',
            'avatar' => 'string',
            'credits' => 'int',
            'slug' => 'string',
            'oauth_enable' => 'bool',
            'credentials_enable' => 'bool',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string'
        ];
    }
}
=======
class Profile extends BaseProfile {}
>>>>>>> 07cc6b5c (.)
