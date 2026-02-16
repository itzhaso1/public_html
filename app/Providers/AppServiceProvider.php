<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (Schema::hasTable('settings')) {
            $settings = Cache::remember('app_settings', 60 * 60, function () {
                return Setting::with('media')->latest()->first();
            });

            if (! $settings) {
                return;
            }

            $logo = $settings->getMediaUrl('setting', $settings, null, 'media', 'logo');
            $favicon = $settings->getMediaUrl('setting', $settings, null, 'media', 'favicon');

            View::share([
                'settings' => $settings,
                'logo' => $logo,
                'favicon' => $favicon,
            ]);
        }

        // Share cached menu categories for website views
        View::composer('website.*', function ($view) {
            $locale = app()->getLocale();

            $categories = Cache::remember("website.categories.menu.$locale", 60 * 10, function () {
                return Category::with(['translations', 'media', 'children.translations'])
                    ->whereNull('parent_id')
                    ->where('status', 'active')
                    ->get();
            });

            $view->with('categories', $categories);
        });
    }
}
