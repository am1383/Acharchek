<?php

namespace App\Providers;

use App\Modules\Admin\Providers\AdminServiceProvider;
use App\Modules\Auth\Providers\AuthServiceProvider;
use App\Modules\Customer\Providers\CustomerServiceProvider;
use App\Modules\Location\Providers\LocationServiceProvider;
use App\Modules\Panel\Providers\PanelServiceProvider;
use App\Modules\SMS\Providers\SMSServiceProvider;
use App\Modules\User\Providers\UserServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(AdminServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(UserServiceProvider::class);
        $this->app->register(PanelServiceProvider::class);
        $this->app->register(SMSServiceProvider::class);
        $this->app->register(LocationServiceProvider::class);
        $this->app->register(CustomerServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
