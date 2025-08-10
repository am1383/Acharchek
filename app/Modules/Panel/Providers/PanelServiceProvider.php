<?php

namespace App\Modules\Panel\Providers;

use App\Modules\Panel\Models\PanelPack;
use App\Modules\Panel\Repositories\Contracts\PanelPackRepositoryInterface;
use App\Modules\Panel\Repositories\Eloquent\PanelPackRepository;
use App\Modules\Panel\Services\Contracts\PanelPackServiceInterface;
use App\Modules\Panel\Services\Contracts\PanelServiceInterface;
use App\Modules\Panel\Services\PanelPackService;
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
        $this->app->bind(PanelPackServiceInterface::class, PanelPackService::class);

        $this->app->bind(PanelPackRepositoryInterface::class, function ($app): PanelPackRepository {
            return new PanelPackRepository($app->make(PanelPack::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
