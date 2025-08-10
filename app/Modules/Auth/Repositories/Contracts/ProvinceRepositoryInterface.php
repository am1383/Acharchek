<?php

namespace App\Modules\Auth\Repositories\Contracts;

use App\Core\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface ProvinceRepositoryInterface extends BaseRepositoryInterface
{
    public function getProvinces(): Collection;
}
