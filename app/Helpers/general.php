<?php

use Illuminate\Support\Facades\Route;

if (! function_exists('admin_guard')) {
    function admin_guard()
    {
        return auth('admin');
    }
}

if (! function_exists('manager_guard')) {
    function manager_guard()
    {
        return auth('manager');
    }
}

if (! function_exists('check_guard')) {
    function check_guard()
    {
        $guards = ['admin', 'manager'];

        foreach ($guards as $guardName) {
            if (! auth($guardName)->check()) {
                continue;
            }

            // Wrap the guard so Blade can safely access `$guard->name`
            // while still allowing `$guard->user()` and other guard methods.
            return new class($guardName) {
                public string $name;
                private $guard;

                public function __construct(string $name)
                {
                    $this->name = $name;
                    $this->guard = auth($name);
                }

                public function user()
                {
                    return $this->guard->user();
                }

                public function guard()
                {
                    return $this->guard;
                }

                public function __call($method, $args)
                {
                    return $this->guard->{$method}(...$args);
                }
            };
        }

        return null;
    }
}

if (! function_exists('get_user_data')) {
    function get_user_data()
    {
        $guards = ['admin', 'manager'];
        foreach ($guards as $guard) {
            if (auth($guard)->check()) {
                return auth($guard)->user();
            }
        }

        return null;
    }
}

if (! function_exists('loadDashboardRoutes')) {
    function loadDashboardRoutes()
    {
        $dashboardPath = base_path('routes/dashboard');
        $files = glob($dashboardPath.'/*.php');

        foreach ($files as $file) {
            Route::middleware('web')->group($file);
        }
    }
}

if (! function_exists('is_active')) {
    /**
     * Check if the current route matches the given route(s).
     *
     * @param  string|array  $routes
     */
    function is_active($routes): string
    {
        if (is_array($routes)) {
            foreach ($routes as $route) {
                if (request()->routeIs($route)) {
                    return 'active';
                }
            }
        } else {
            if (request()->routeIs($routes)) {
                return 'active';
            }
        }

        return '';
    }
}
