<?php

namespace App\Modules\Customer\Providers;

use App\Modules\Customer\Models\Customer;
use App\Modules\Customer\Models\CustomerSecret;
use App\Modules\Customer\Repositories\Contracts\CustomerRepositoryInterface;
use App\Modules\Customer\Repositories\Contracts\CustomerSecretRepositoryInterface;
use App\Modules\Customer\Repositories\CustomerRepository;
use App\Modules\Customer\Repositories\CustomerSecretRepository;
use App\Modules\Customer\Services\CustomerService;
use App\Modules\Customer\Services\CustomerServiceInterface;
use Illuminate\Support\ServiceProvider;

class CustomerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CustomerServiceInterface::class, CustomerService::class);

        $this->app->bind(CustomerRepositoryInterface::class, function ($app): CustomerRepository {
            return new CustomerRepository($app->make(Customer::class));
        });

        $this->app->bind(CustomerSecretRepositoryInterface::class, function ($app): CustomerSecretRepository {
            return new CustomerSecretRepository($app->make(CustomerSecret::class));
        });
    }
}
