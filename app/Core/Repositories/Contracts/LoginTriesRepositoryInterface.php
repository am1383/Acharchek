<?php

namespace App\Core\Repositories\Contracts;

use App\Modules\Auth\Models\LoginTries;

interface LoginTriesRepositoryInterface extends BaseRepositoryInterface
{
    public function findByPhoneNumberOrFail(string $phoneNumber, array $columns = ['*']): LoginTries;

    public function updateOrFailById(int $Id, array $attributes): void;
}
