<?php

namespace App\Core\Repositories\Contracts;

use App\Modules\Auth\Models\User;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function findByPhoneNumber(string $phoneNumber, array $columns = ['*']): User;

    public function findByApiToken(string $apiToken, array $columns = ['*']): User;

    public function getAllIds(): User;
}
