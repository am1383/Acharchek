<?php

namespace App\Modules\Auth\Repositories\Contracts;

use App\Modules\Auth\Models\User;

interface UserRepositoryInterface
{
    public function findByPhoneNumber(string $phoneNumber): User;
}
