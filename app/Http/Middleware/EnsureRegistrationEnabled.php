<?php

declare(strict_types=1);



namespace Modules\User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class EnsureRegistrationEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $enabled=Config::boolean('auth.registration_enabled', true);
        // Controlla se la registrazione è disabilitata
        if (!$enabled) {
            return redirect()->route('pages.view', ['slug'=>'register_disabled']);
        }

        return $next($request);
    }
}