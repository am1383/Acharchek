<?php

namespace App\Modules\Auth\Repositories\Contracts;

use App\Core\Repositories\Contracts\BaseRepositoryInterface;

interface BusinessServiceRepositoryInterface extends BaseRepositoryInterface
{
    public function getAllIds(): array;
}
