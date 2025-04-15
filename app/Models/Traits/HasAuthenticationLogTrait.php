<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

<<<<<<< HEAD
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
=======
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;
>>>>>>> 07cc6b5c (.)
use Modules\User\Models\AuthenticationLog;

/**
 * Trait HasAuthenticationLogTrait.
 *
 * This trait provides functionality for logging authentication events for any model that uses it.
 * It includes methods for retrieving the latest authentication logs, login timestamps, IP addresses,
 * and other related information, including tracking consecutive login days.
 *
<<<<<<< HEAD
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\AuthenticationLog> $authentications
 * @property-read string|null $login_at The timestamp of the last login.
 * @property-read string|null $ip_address The IP address of the last login.
 */
=======
 * @property MorphMany<AuthenticationLog, static> $authentications      The authentication logs related to the model.
 * @property MorphOne<AuthenticationLog, static>  $latestAuthentication The most recent authentication log entry.
 * @property-read string|null $login_at The timestamp of the last login.
 * @property-read string|null $ip_address The IP address of the last login.
 */
/**
 * @property MorphMany<AuthenticationLog> $authentications
 * @property MorphOne<AuthenticationLog> $latestAuthentication
 * @property \Illuminate\Support\Carbon|null $login_at
 * @property string|null $ip_address
 */
>>>>>>> 07cc6b5c (.)
trait HasAuthenticationLogTrait
{
    /**
     * Get all of the model's authentication logs.
     *
<<<<<<< HEAD
     * @return HasMany<AuthenticationLog>
     */
    public function authentications(): HasMany
    {
        return $this->hasMany(AuthenticationLog::class);
=======
     * @return MorphMany<AuthenticationLog, static>
     */
    public function authentications(): MorphMany
    {
        return $this->morphMany(AuthenticationLog::class, 'authenticatable')
            ->latest('login_at');
>>>>>>> 07cc6b5c (.)
    }

    /**
     * Get the latest authentication attempt for the model.
     *
<<<<<<< HEAD
     * @return AuthenticationLog|null
     */
    public function latestAuthentication(): ?AuthenticationLog
    {
        return $this->authentications()->first();
=======
     * @return MorphOne<AuthenticationLog, static>
     */
    public function latestAuthentication(): MorphOne
    {
        return $this->morphOne(AuthenticationLog::class, 'authenticatable')
            ->latestOfMany('login_at');
>>>>>>> 07cc6b5c (.)
    }

    /**
     * Specify how to notify about authentication logs.
     *
     * @return list<string> a list of notification channels
     */
    public function notifyAuthenticationLogVia(): array
    {
        return ['mail'];
    }

    /**
     * Get the timestamp of the most recent login attempt.
     *
     * @return ?Carbon the timestamp of the last login or null if none exists
     */
    public function lastLoginAt(): ?Carbon
    {
<<<<<<< HEAD
        $latestAuth = $this->latestAuthentication();
        return $latestAuth ? $latestAuth->login_at : null;
=======
        /** @var AuthenticationLog|null $auth */
        $auth = $this->authentications()->first();
        return $auth !== null ? $auth->login_at : null;
>>>>>>> 07cc6b5c (.)
    }

    /**
     * Get the timestamp of the most recent successful login attempt.
     *
     * @return ?Carbon the timestamp of the last successful login or null if none exists
     */
    public function lastSuccessfulLoginAt(): ?Carbon
    {
<<<<<<< HEAD
        $latestAuth = $this->authentications()->first();
        return $latestAuth ? $latestAuth->login_at : null;
=======
        /** @var AuthenticationLog|null $auth */
        $auth = $this->authentications()->where('login_successful', true)->first();
        return $auth !== null ? $auth->login_at : null;
>>>>>>> 07cc6b5c (.)
    }

    /**
     * Get the IP address of the most recent login attempt.
     *
     * @return ?string the IP address of the last login or null if none exists
     */
    public function lastLoginIp(): ?string
    {
<<<<<<< HEAD
        $latestAuth = $this->latestAuthentication();
        return $latestAuth ? $latestAuth->ip_address : null;
=======
        /** @var AuthenticationLog|null $auth */
        $auth = $this->authentications()->first();
        return $auth !== null ? $auth->ip_address : null;
>>>>>>> 07cc6b5c (.)
    }

    /**
     * Get the IP address of the most recent successful login attempt.
     *
     * @return ?string the IP address of the last successful login or null if none exists
     */
    public function lastSuccessfulLoginIp(): ?string
    {
<<<<<<< HEAD
        $latestAuth = $this->authentications()->first();
        return $latestAuth ? $latestAuth->ip_address : null;
=======
        /** @var AuthenticationLog|null $auth */
        $auth = $this->authentications()->where('login_successful', true)->first();
        return $auth !== null ? $auth->ip_address : null;
>>>>>>> 07cc6b5c (.)
    }

    /**
     * Get the timestamp of the second most recent login attempt (previous login).
     *
     * @return ?Carbon the timestamp of the previous login or null if less than two logins exist
     */
    public function previousLoginAt(): ?Carbon
    {
<<<<<<< HEAD
        $previousAuth = $this->authentications()->skip(1)->first();
        return $previousAuth ? $previousAuth->login_at : null;
=======
        /** @var AuthenticationLog|null $auth */
        $auth = $this->authentications()->skip(1)->first();
        return $auth !== null ? $auth->login_at : null;
>>>>>>> 07cc6b5c (.)
    }

    /**
     * Get the IP address of the second most recent login attempt (previous login).
     *
     * @return ?string the IP address of the previous login or null if less than two logins exist
     */
    public function previousLoginIp(): ?string
    {
<<<<<<< HEAD
        $previousAuth = $this->authentications()->skip(1)->first();
        return $previousAuth ? $previousAuth->ip_address : null;
=======
        /** @var AuthenticationLog|null $auth */
        $auth = $this->authentications()->skip(1)->first();
        return $auth !== null ? $auth->ip_address : null;
>>>>>>> 07cc6b5c (.)
    }

    /**
     * Calculate the number of consecutive days the user has logged in.
     *
     * @return int the number of consecutive days the user has logged in
     */
    public function consecutiveDaysLogin(): int
    {
        return once(function (): int {
            $date = Carbon::now();
            $days = 0;

            // Count the logins for the current day.
            $count = $this->authentications()->whereDate('login_at', $date)->count();

            while ($count > 0) {
                $date = $date->subDay();
                $count = $this->authentications()->whereDate('login_at', $date)->count();
                $days++;
            }

            return $days;
        });
    }
<<<<<<< HEAD

    public function getAuthenticationLogsAttribute(): array
    {
        return [
            'total_attempts' => $this->authentications()->whereDate('login_at', Carbon::today())->count(),
            'total_failed_attempts' => $this->authentications()->whereDate('login_at', Carbon::today())->where('login_successful', false)->count(),
        ];
    }
=======
>>>>>>> 07cc6b5c (.)
}
