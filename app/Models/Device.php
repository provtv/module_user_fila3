<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\User\Database\Factories\DeviceFactory;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;

/**
 * Device model representing a user's device in the system.
 *
 * @property EloquentCollection<int, \Illuminate\Database\Eloquent\Model&UserContract> $users
 * @property int|null $users_count
 * @method static DeviceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Device newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device query()
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereBrowser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereIsDesktop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereIsMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereIsPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereIsRobot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereIsTablet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereLanguages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereMobileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device wherePlatform($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereRobot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereVersion($value)
 * @property DeviceUser $pivot
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @property string $id
 * @property string|null $mobile_id
 * @property array|null $languages
 * @property string|null $device
 * @property string|null $platform
 * @property string|null $browser
 * @property string|null $version
 * @property bool|null $is_robot
 * @property string|null $robot
 * @property bool|null $is_desktop
 * @property bool|null $is_mobile
 * @property bool|null $is_tablet
 * @property bool|null $is_phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $uuid
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereUuid($value)
 * @mixin \Eloquent
 */
class Device extends BaseModel
{
    /** @var list<string> */
<<<<<<< HEAD
    public $fillable = [
        'id',
=======
    protected $fillable = [
        'id',
        'uuid',
>>>>>>> 07cc6b5c (.)
        'mobile_id',
        'languages',
        'device',
        'platform',
        'browser',
        'version',
        'is_robot',
        'robot',
        'is_desktop',
        'is_mobile',
        'is_tablet',
        'is_phone',
<<<<<<< HEAD
        'created_at',
        'updated_at',
        'updated_by',
        'created_by',
        'uuid'
=======
>>>>>>> 07cc6b5c (.)
    ];

    /**
     * Define the many-to-many relationship between devices and users.
     *
     * return BelongsToMany<UserContract, Device>
     */
    public function users(): BelongsToMany
    {
        $userClass = XotData::make()->getUserClass();

        return $this->belongsToManyX($userClass);
    }

    /**
     * Define the attribute casting for the model.
     *
     * @return array<string, string>
     */
<<<<<<< HEAD
    public function casts(): array
    {
        return [
            'id' => 'string',
            'mobile_id' => 'string',
            'languages' => 'array',
            'device' => 'string',
            'platform' => 'string',
            'browser' => 'string',
            'version' => 'string',
            'is_robot' => 'boolean',
            'robot' => 'string',
            'is_desktop' => 'boolean',
            'is_mobile' => 'boolean',
            'is_tablet' => 'boolean',
            'is_phone' => 'boolean',
=======
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
>>>>>>> 07cc6b5c (.)
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
<<<<<<< HEAD
            'uuid' => 'string'
=======
            'languages' => 'array',
            'is_robot' => 'boolean',
            'is_desktop' => 'boolean',
            'is_mobile' => 'boolean',
            'is_tablet' => 'boolean',
            'is_phone' => 'boolean',
>>>>>>> 07cc6b5c (.)
        ];
    }
}
