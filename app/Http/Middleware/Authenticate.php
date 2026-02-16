<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Admin / Manager areas
        if ($request->routeIs('admin.*') || $request->is('*admin*')) {
            return route('admin.login');
        }

        if ($request->routeIs('manager.*') || $request->is('*manager*')) {
            return route('manager.login');
        }

        // Default: website user login
        return route('auth.login');
    }
}
