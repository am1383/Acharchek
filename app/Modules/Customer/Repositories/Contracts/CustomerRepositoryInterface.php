<?php

namespace App\Modules\Customer\Repositories\Contracts;

use App\Modules\Customer\Models\Customer;

interface CustomerRepositoryInterface
{
    public function customerIsExistOrFail(string $phoneNumber): void;

    public function findByPhoneNumberOrFail(string $phoneNumber, array $columns): Customer;
}
