<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;

/**
 * Modules\User\Models\DeviceUser.
 *
 * @property Device|null $device
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser query()
<<<<<<< HEAD
 * @property int $id
 * @property string $uuid
 * @property string|null $device_id
 * @property string|null $user_id
=======
 * @property string $id
 * @property string $device_id
 * @property string $user_id
>>>>>>> 07cc6b5c (.)
 * @property Carbon|null $login_at
 * @property Carbon|null $logout_at
 * @property string|null $push_notifications_token
 * @property bool|null $push_notifications_enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
<<<<<<< HEAD
 * @property string|null $created_by
 * @property string|null $updated_by
=======
 * @property string|null $updated_by
 * @property string|null $created_by
>>>>>>> 07cc6b5c (.)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser whereLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser whereLogoutAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser wherePushNotificationsEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser wherePushNotificationsToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser whereUserId($value)
<<<<<<< HEAD
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser whereDeletedBy($value)
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
=======
>>>>>>> 07cc6b5c (.)
 * @property ProfileContract|null $profile
 * @property UserContract|null $user
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @mixin \Eloquent
 */
class DeviceUser extends BasePivot
{
<<<<<<< HEAD
    /** @var string */
    protected $connection = 'user';

    /** @var list<string> */
    public $fillable = [
        'id',
        'uuid',
        'device_id',
        'user_id',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_at',
        'deleted_by'
=======
    /** @var list<string> */
    protected $fillable = [
        'id',
        'device_id',
        'user_id',
        'login_at',
        'logout_at',
        'push_notifications_token',
        'push_notifications_enabled',
>>>>>>> 07cc6b5c (.)
    ];

    /**
     * old_return BelongsTo<Device, DeviceUser>.
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    /**
     * old_return BelongsTo<Model&UserContract, DeviceUser>.
     */
    public function user(): BelongsTo
    {
        /** @var class-string<Model> */
        $userClass = XotData::make()->getUserClass();

        return $this->belongsTo($userClass);
    }

    /**
     * old_return BelongsTo<Model&ProfileContract, DeviceUser>.
     */
    public function profile(): BelongsTo
    {
        /* @var class-string<Model> */
        $profileClass = XotData::make()->getProfileClass();

        return $this->belongsTo($profileClass, 'user_id', 'user_id');
    }

<<<<<<< HEAD
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function casts(): array
=======
    /** @return array<string, string> */
    protected function casts(): array
>>>>>>> 07cc6b5c (.)
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
<<<<<<< HEAD
            'device_id' => 'string',
            'user_id' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'created_by' => 'string',
            'updated_by' => 'string',
            'deleted_by' => 'string'
=======
            'user_id' => 'string',
            'device_id' => 'string',
            // 'id' => 'string',
            // 'locales' => 'array',
            'push_notifications_token' => 'string',
            'push_notifications_enabled' => 'boolean',

            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',

            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',

            'login_at' => 'datetime',
            'logout_at' => 'datetime',
>>>>>>> 07cc6b5c (.)
        ];
    }
}
