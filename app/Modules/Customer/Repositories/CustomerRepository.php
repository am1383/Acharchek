<?php

namespace App\Modules\Customer\Repositories;

use App\Modules\Customer\Models\Customer;
use App\Modules\Customer\Repositories\Contracts\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function __construct(protected Model $model) {}

    public function customerIsExistOrFail(string $phoneNumber): void
    {
        $this->model->where('phone', $phoneNumber)
            ->firstOrFail();
    }

    public function findByPhoneNumberOrFail(string $phoneNumber, array $columns): Customer
    {
        return $this->model->select($columns)
            ->where('phone', $phoneNumber)
            ->firstOrFail();
    }

    public function getByPhoneNumber(string $phoneNumber, array $columns = ['*']): Collection
    {
        return $this->model->select($columns)
            ->where('phone', $phoneNumber)
            ->get();
    }
}
