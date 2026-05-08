<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (\Illuminate\Support\Facades\Schema::hasTable('stages')) {
            \Illuminate\Support\Facades\View::share('all_stages', \App\Models\Stage::all());
        }

        if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
            $settings = \App\Models\Setting::all()->pluck('value', 'key')->toArray();
            \Illuminate\Support\Facades\View::share('settings', $settings);
        }
    }

}
