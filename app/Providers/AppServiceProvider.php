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
        // Register components from App\Components namespace with explicit aliases
        // This overrides Laravel's default auto-discovery from App\View\Components
        Blade::component(\App\Components\DropdownMenu::class, 'dropdown-menu');
        Blade::component(\App\Components\PIM\Tabs::class, 'pim.tabs');
        Blade::component(\App\Components\Leave\Tabs::class, 'leave.tabs');
        Blade::component(\App\Components\Recruitment\Tabs::class, 'recruitment.tabs');
        Blade::component(\App\Components\Admin\ColorPicker::class, 'admin.color-picker');
    }
}