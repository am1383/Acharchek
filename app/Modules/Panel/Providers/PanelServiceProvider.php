<?php

namespace App\Modules\Panel\Providers;

use App\Modules\Admin\Services\Contracts\PanelServiceInterface;
use App\Modules\Panel\Services\PanelService;
use Illuminate\Support\ServiceProvider;

class PanelServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PanelServiceInterface::class, PanelService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
