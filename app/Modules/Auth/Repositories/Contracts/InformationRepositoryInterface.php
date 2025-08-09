<?php

namespace App\Modules\Auth\Repositories\Contracts;

use App\Core\Repositories\Contracts\BaseRepositoryInterface;
use App\Modules\Auth\Models\Information;

interface InformationRepositoryInterface extends BaseRepositoryInterface
{
    public function findByUserId(int $userId, array $columns): Information;
}
