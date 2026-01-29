<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register components from App\Components namespace
        // Laravel will auto-generate aliases based on class names
        Blade::component(\App\Components\DropdownMenu::class);
        Blade::component(\App\Components\PIM\Tabs::class);
        Blade::component(\App\Components\Leave\Tabs::class);
        Blade::component(\App\Components\Recruitment\Tabs::class);
        Blade::component(\App\Components\Admin\ColorPicker::class);
    }
}