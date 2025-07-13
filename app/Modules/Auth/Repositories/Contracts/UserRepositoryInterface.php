<?php

namespace App\Modules\Auth\Repositories\Contracts;

use App\Core\Repositories\Contracts\BaseRepositoryInterface;
use App\Modules\Auth\Models\User;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function findByPhoneNumber(string $phoneNumber): User;
}
