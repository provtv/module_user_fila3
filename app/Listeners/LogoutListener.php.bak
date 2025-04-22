<?php

declare(strict_types=1);

/**
 * @see https://github.com/rappasoft/laravel-authentication-log/blob/main/src/Listeners/LogoutListener.php
 */

namespace Modules\User\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;
use Modules\User\Actions\GetCurrentDeviceAction;
use Modules\User\Models\AuthenticationLog;
use Modules\User\Models\DeviceUser;
use Modules\User\Contracts\HasAuthentications;

class LogoutListener
{
    protected Request $request;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     */
    public function handle(Logout $event): void
    {
        if (! config('authentication-log.logout_log', true)) {
            return;
        }

        if ($event->user && $event->user instanceof HasAuthentications) {
            $ip = $this->request->ip();
            $userAgent = $this->request->userAgent();
            // $location = optional(geoip()->getLocation($ip))->toArray();
            $location = [];

            $event->user->authentications()->create([
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'logout_at' => now(),
                'location' => $location,
            ]);
        }

        // Session::flash('login-success', 'Hello ' . $event->user->name . ', welcome back!');
        $device = app(GetCurrentDeviceAction::class)->execute();
        $user = $event->user;
        
        $pivot = DeviceUser::firstOrCreate(['user_id' => $user->getAuthIdentifier(), 'device_id' => $device->id]);
        $pivot->update(['logout_at' => now()]);

        // ----------
        if ($user instanceof HasAuthentications) {
            $ip = $this->request->ip();
            $userAgent = $this->request->userAgent();
            $log = $user->authentications()
                ->whereIpAddress($ip)
                ->whereUserAgent($userAgent)
                ->orderByDesc('login_at')
                ->first();

            if (! $log) {
                $log = new AuthenticationLog([
                    'ip_address' => $ip,
                    'user_agent' => $userAgent,
                ]);
            }

            $log->setAttribute('logout_at', now());

            $user->authentications()->save($log);
        }
    }

    public function forgetRememberTokens(Logout $event): void
    {
        if ($event->user && $event->user instanceof HasAuthentications) {
            $event->user->authentications()->whereNotNull('remember_token')->update([
                'remember_token' => null,
            ]);
        }
    }
}
