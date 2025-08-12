<?php

namespace App\Modules\Customer\Repositories\Contracts;

use App\Core\Repositories\Contracts\BaseRepositoryInterface;
use App\Modules\Customer\Models\CustomerSecret;

interface CustomerSecretRepositoryInterface extends BaseRepositoryInterface
{
    public function findByPhoneNumberOrFail(string $phoneNumber, array $columns): CustomerSecret;
}
