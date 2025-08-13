<?php

namespace App\Modules\Customer\Repositories\Contracts;

use App\Modules\Customer\Models\Customer;
use Illuminate\Database\Eloquent\Collection;

interface CustomerRepositoryInterface
{
    public function customerIsExistOrFail(string $phoneNumber): void;

    public function findByPhoneNumberOrFail(string $phoneNumber, array $columns): Customer;

    public function getByPhoneNumber(string $phoneNumber, array $columns = ['*']): Collection;
}
